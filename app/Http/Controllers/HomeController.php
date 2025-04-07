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
        return view('job-seeker.dashboard');
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
} 