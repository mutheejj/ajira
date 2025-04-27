<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['dashboard']);
    }

    /**
     * Show the application home page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get all active job posts with pagination (more than just 6)
        $jobsQuery = JobPost::with('client')
            ->where('status', 'active')
            ->latest();
            
        // Apply category filter if provided
        if ($request->has('category') && $request->category != 'all') {
            $jobsQuery->where('category', $request->category);
        }
        
        // Apply experience level filter if provided
        if ($request->has('experience_level') && $request->experience_level != 'all') {
            $jobsQuery->where('experience_level', $request->experience_level);
        }
        
        // Apply job type filter if provided
        if ($request->has('job_type') && $request->job_type != 'all') {
            $jobsQuery->where('project_type', $request->job_type);
        }
        
        // Apply budget filter if provided
        if ($request->has('budget') && $request->budget != 'all') {
            switch ($request->budget) {
                case 'under-100':
                    $jobsQuery->where('budget', '<', 100);
                    break;
                case '100-500':
                    $jobsQuery->whereBetween('budget', [100, 500]);
                    break;
                case '500-1000':
                    $jobsQuery->whereBetween('budget', [500, 1000]);
                    break;
                case '1000-5000':
                    $jobsQuery->whereBetween('budget', [1000, 5000]);
                    break;
                case 'over-5000':
                    $jobsQuery->where('budget', '>', 5000);
                    break;
            }
        }
        
        // Get featured jobs (first page)
        $featuredJobs = $jobsQuery->take(9)->get();
        
        // Get category counts for display in filters
        $categoryStats = JobPost::where('status', 'active')
            ->select('category', \DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
            
        // Pass sample counts for popular categories if empty
        if ($categoryStats->isEmpty()) {
            $categoryStats = collect([
                ['category' => 'Web Development', 'count' => 1245],
                ['category' => 'Design & Creative', 'count' => 876],
                ['category' => 'Marketing', 'count' => 632],
                ['category' => 'Content Writing', 'count' => 518],
                ['category' => 'Finance & Accounting', 'count' => 423],
                ['category' => 'Cloud Computing', 'count' => 386],
                ['category' => 'Customer Service', 'count' => 352],
                ['category' => 'Admin & Support', 'count' => 305],
            ]);
        }
        
        // Get unique clients who have posted jobs
        $activeClients = User::whereHas('jobPosts', function($query) {
                $query->where('status', 'active');
            })
            ->take(6)
            ->get();

        return view('home', compact('featuredJobs', 'categoryStats', 'activeClients'));
    }

    /**
     * Show the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        if ($user->user_type === 'client') {
            return redirect()->route('client.dashboard');
        } elseif ($user->user_type === 'job-seeker') {
            return redirect()->route('jobseeker.dashboard');
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('home');
    }

    /**
     * Show the client dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function clientDashboard()
    {
        return view('client.dashboard');
    }

    /**
     * Show the job seeker dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function jobseekerDashboard()
    {
        $user = Auth::user();
        
        // Get application statistics
        $applications = \App\Models\Application::where('user_id', $user->id);
        $applicationStats = [
            'total' => $applications->count(),
            'in_progress' => $applications->whereIn('status', ['pending', 'accepted'])->count(), // Simplified for example
            'withdrawn' => $applications->where('status', 'withdrawn')->count(),
            'rejected' => $applications->where('status', 'rejected')->count(),
        ];
        
        // Get Recent Applications (Limit 3-5)
        $recentApplications = \App\Models\Application::where('user_id', $user->id)
            ->with(['jobPost.client']) // Eager load Job Post and Client
            ->latest()
            ->take(3) // Fetch latest 3 applications
            ->get();
            
        // Get IDs of jobs user has applied to
        $appliedJobIds = \App\Models\Application::where('user_id', $user->id)->pluck('job_post_id')->toArray();
        
        // Get Recommended Jobs (Recent active jobs not applied to, Limit 3-5)
        $recommendedJobs = JobPost::where('status', 'active')
            ->whereNotIn('id', $appliedJobIds) // Exclude jobs already applied to
            ->with('client') // Eager load client
            ->latest()
            ->take(3) // Fetch latest 3 recommended jobs
            ->get();
        
        // Initialize empty collections for tasks and work logs
        $tasks = collect();
        $workLogs = collect();
        $earnings = [
            'total' => 0,
            'pending' => 0,
        ];
        
        // Check if the Contract model exists
        if (class_exists(\App\Models\Contract::class)) {
            // Get active tasks
            $contracts = \App\Models\Contract::where('job_seeker_id', $user->id)
                ->with(['job', 'job.client', 'tasks']) // Use job relation instead of jobPost
                ->get();
                
            foreach ($contracts as $contract) {
                $contractTasks = $contract->tasks->map(function($task) use ($contract) {
                    return [
                        'id' => $task->id,
                        'title' => $task->title,
                        'client' => $contract->job->client->name, // Access client via job instead of jobPost
                        'status' => $task->status,
                        'priority' => $task->priority,
                        'due_date' => $task->due_date,
                        'progress' => $task->progress
                    ];
                });
                $tasks = $tasks->concat($contractTasks);
            }
            
            // Get recent work logs
            if (class_exists(\App\Models\WorkLog::class)) {
                $workLogs = \App\Models\WorkLog::where('job_seeker_id', $user->id) // Use correct column name
                    ->with(['task', 'task.contract.jobPost.client']) // Adjust relation path
                    ->latest()
                    ->take(5)
                    ->get();
            }
                
            // Get earnings statistics
            $earnings = [
                'total' => \App\Models\Contract::where('job_seeker_id', $user->id)
                    ->where('status', 'completed')
                    ->sum('amount'), // Assuming amount is on Contract model
                'pending' => \App\Models\Contract::where('job_seeker_id', $user->id)
                    ->whereIn('status', ['in_progress', 'pending']) // Example statuses
                    ->sum('amount'),
            ];
        }
        
        return view('job-seeker.dashboard', compact(
            'applicationStats',
            'recentApplications', // Pass recent applications to view
            'recommendedJobs', // Pass recommended jobs to view
            'tasks',
            'workLogs',
            'earnings'
        ));
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the platform statistics page.
     *
     * @return \Illuminate\View\View
     */
    public function stats()
    {
        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::where('user_type', 'client')->count(),
            'total_job_seekers' => User::where('user_type', 'job-seeker')->count(),
            'total_jobs' => JobPost::count(),
            'active_jobs' => JobPost::where('status', 'active')->count(),
            'completed_jobs' => JobPost::where('status', 'completed')->count(), // Assuming 'completed' status exists
            'total_applications' => \App\Models\Application::count(),
            'total_contracts' => 0, // Placeholder - Add if Contract model exists
            'total_earnings' => 0, // Placeholder - Add if payment tracking exists
        ];
        
        if (class_exists(\App\Models\Contract::class)) {
            $stats['total_contracts'] = \App\Models\Contract::count();
            // You might want more specific contract stats (e.g., active, completed)
        }
        
        // Add more stats as needed...
        
        return view('stats.index', compact('stats'));
    }
} 