<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
use App\Models\Task;
use App\Models\WorkLog;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;

class JobSeekerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'job-seeker']);
    }
    
    /**
     * Display job seeker's active tasks.
     *
     * @return \Illuminate\View\View
     */
    public function activeTasks()
    {
        // Get actual tasks from the database
        $contracts = Contract::where('job_seeker_id', Auth::id())
            ->with(['job', 'job.client', 'tasks'])
            ->get();
            
        $tasks = collect();
        
        foreach ($contracts as $contract) {
            $contractTasks = $contract->tasks->map(function($task) use ($contract) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'client' => $contract->job->client->name,
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'due_date' => $task->due_date,
                    'progress' => $task->progress
                ];
            });
            
            $tasks = $tasks->concat($contractTasks);
        }
        
        // If no tasks found, provide placeholder data for UI display
        if ($tasks->isEmpty()) {
            $tasks = collect([
                [
                    'id' => 1,
                    'title' => 'Web Application Frontend Development',
                    'client' => 'TechCorp Solutions',
                    'status' => 'in-progress',
                    'priority' => 'high',
                    'due_date' => now()->addDays(5)->format('Y-m-d'),
                    'progress' => 65
                ],
                [
                    'id' => 2,
                    'title' => 'Ecommerce Website Migration',
                    'client' => 'Fashion Boutique Inc',
                    'status' => 'in-progress',
                    'priority' => 'medium',
                    'due_date' => now()->addDays(10)->format('Y-m-d'),
                    'progress' => 30
                ],
                [
                    'id' => 3,
                    'title' => 'Mobile App UI Design',
                    'client' => 'Health & Fitness Co',
                    'status' => 'pending',
                    'priority' => 'low',
                    'due_date' => now()->addDays(14)->format('Y-m-d'),
                    'progress' => 0
                ],
            ]);
        }
        
        return view('job-seeker.tasks', compact('tasks'));
    }
    
    /**
     * Display job seeker's work log.
     *
     * @return \Illuminate\View\View
     */
    public function workLog()
    {
        // Get actual work logs from the database
        $workLogs = WorkLog::where('job_seeker_id', Auth::id())
            ->with(['task', 'task.contract', 'task.contract.job', 'task.contract.job.client'])
            ->latest('date')
            ->get()
            ->map(function($log) {
                return [
                    'id' => $log->id,
                    'date' => $log->date,
                    'task' => $log->task->title,
                    'client' => $log->task->contract->job->client->name,
                    'hours' => $log->hours,
                    'description' => $log->description
                ];
            });
            
        // If no logs found, provide placeholder data for UI display
        if ($workLogs->isEmpty()) {
            $workLogs = collect([
                [
                    'id' => 1,
                    'date' => now()->subDays(1)->format('Y-m-d'),
                    'task' => 'Web Application Frontend Development',
                    'client' => 'TechCorp Solutions',
                    'hours' => 6,
                    'description' => 'Implemented responsive navbar and hero section as per design mockups.'
                ],
                [
                    'id' => 2,
                    'date' => now()->subDays(2)->format('Y-m-d'),
                    'task' => 'Web Application Frontend Development',
                    'client' => 'TechCorp Solutions',
                    'hours' => 8,
                    'description' => 'Created user dashboard and settings page. Implemented dark mode functionality.'
                ],
                [
                    'id' => 3,
                    'date' => now()->subDays(3)->format('Y-m-d'),
                    'task' => 'Ecommerce Website Migration',
                    'client' => 'Fashion Boutique Inc',
                    'hours' => 5,
                    'description' => 'Data migration planning and initial database schema setup.'
                ],
            ]);
        }
        
        // Calculate stats
        $totalHours = $workLogs->sum('hours');
        $averageHoursPerDay = $workLogs->count() > 0 ? round($totalHours / $workLogs->count(), 1) : 0;
        
        return view('job-seeker.worklog', compact('workLogs', 'totalHours', 'averageHoursPerDay'));
    }
    
    /**
     * Display job seeker's contracts.
     *
     * @return \Illuminate\View\View
     */
    public function contracts()
    {
        // For demo purposes, create sample contracts
        $contracts = collect([
            [
                'id' => 1,
                'title' => 'Web Application Development',
                'client' => 'TechCorp Solutions',
                'start_date' => now()->subDays(15)->format('Y-m-d'),
                'end_date' => now()->addDays(45)->format('Y-m-d'),
                'status' => 'active',
                'payment_type' => 'hourly',
                'rate' => 35,
                'total_earned' => 1050
            ],
            [
                'id' => 2,
                'title' => 'Ecommerce Website Migration',
                'client' => 'Fashion Boutique Inc',
                'start_date' => now()->subDays(5)->format('Y-m-d'),
                'end_date' => now()->addDays(25)->format('Y-m-d'),
                'status' => 'active',
                'payment_type' => 'fixed',
                'rate' => 2500,
                'total_earned' => 1000
            ],
            [
                'id' => 3,
                'title' => 'Logo Design Project',
                'client' => 'Local Restaurant',
                'start_date' => now()->subDays(30)->format('Y-m-d'),
                'end_date' => now()->subDays(20)->format('Y-m-d'),
                'status' => 'completed',
                'payment_type' => 'fixed',
                'rate' => 500,
                'total_earned' => 500
            ],
        ]);
        
        return view('job-seeker.contracts', compact('contracts'));
    }
    
    /**
     * Display job seeker's earnings.
     *
     * @return \Illuminate\View\View
     */
    public function earnings()
    {
        // For demo purposes, create sample earnings data
        $earnings = [
            'current_month' => 2550,
            'previous_month' => 3200,
            'total_earnings' => 12450,
            'pending_payments' => 850,
            'transactions' => [
                [
                    'id' => 'TRX123456',
                    'date' => now()->subDays(2)->format('Y-m-d'),
                    'client' => 'TechCorp Solutions',
                    'project' => 'Web Application Development',
                    'amount' => 700,
                    'status' => 'paid'
                ],
                [
                    'id' => 'TRX123455',
                    'date' => now()->subDays(7)->format('Y-m-d'),
                    'client' => 'Fashion Boutique Inc',
                    'project' => 'Ecommerce Website Migration',
                    'amount' => 1000,
                    'status' => 'paid'
                ],
                [
                    'id' => 'TRX123454',
                    'date' => now()->subDays(9)->format('Y-m-d'),
                    'client' => 'TechCorp Solutions',
                    'project' => 'Web Application Development',
                    'amount' => 700,
                    'status' => 'paid'
                ],
                [
                    'id' => 'TRX123453',
                    'date' => now()->subDays(14)->format('Y-m-d'),
                    'client' => 'Health & Fitness Co',
                    'project' => 'Mobile App UI Design',
                    'amount' => 850,
                    'status' => 'pending'
                ],
            ]
        ];
        
        // Monthly earnings for chart data
        $monthlyEarnings = [
            'Jan' => 950,
            'Feb' => 1200,
            'Mar' => 1700,
            'Apr' => 1400,
            'May' => 2100,
            'Jun' => 1800,
            'Jul' => 2550,
            'Aug' => 0,
            'Sep' => 0,
            'Oct' => 0,
            'Nov' => 0,
            'Dec' => 0
        ];
        
        return view('job-seeker.earnings', compact('earnings', 'monthlyEarnings'));
    }
    
    /**
     * Display job seeker's portfolio.
     *
     * @return \Illuminate\View\View
     */
    public function portfolio()
    {
        // For demo purposes, create sample portfolio projects
        $portfolioProjects = collect([
            [
                'id' => 1,
                'title' => 'E-commerce Website Redesign',
                'client' => 'Fashion Boutique Inc',
                'description' => 'Complete redesign of an e-commerce platform with focus on user experience and mobile responsiveness.',
                'technologies' => ['HTML', 'CSS', 'JavaScript', 'React', 'Node.js'],
                'image' => 'portfolio-1.jpg',
                'completed_at' => now()->subMonths(2)->format('Y-m-d')
            ],
            [
                'id' => 2,
                'title' => 'Health & Fitness Mobile App',
                'client' => 'Health & Fitness Co',
                'description' => 'Mobile application for tracking workouts, nutrition, and personal health goals with social sharing capabilities.',
                'technologies' => ['React Native', 'Firebase', 'Redux'],
                'image' => 'portfolio-2.jpg',
                'completed_at' => now()->subMonths(5)->format('Y-m-d')
            ],
            [
                'id' => 3,
                'title' => 'Corporate Website Development',
                'client' => 'TechCorp Solutions',
                'description' => 'Fully responsive corporate website with custom CMS for easy content management.',
                'technologies' => ['WordPress', 'PHP', 'MySQL', 'JavaScript'],
                'image' => 'portfolio-3.jpg',
                'completed_at' => now()->subMonths(8)->format('Y-m-d')
            ],
        ]);
        
        return view('job-seeker.portfolio', compact('portfolioProjects'));
    }
    
    /**
     * Display job seeker's reviews.
     *
     * @return \Illuminate\View\View
     */
    public function reviews()
    {
        // For demo purposes, create sample reviews
        $reviews = collect([
            [
                'id' => 1,
                'client' => 'John Smith',
                'client_company' => 'TechCorp Solutions',
                'project' => 'Web Application Development',
                'rating' => 5,
                'comment' => 'Excellent work! Delivered the project ahead of schedule and exceeded our expectations. Very responsive and professional.',
                'date' => now()->subMonths(1)->format('Y-m-d')
            ],
            [
                'id' => 2,
                'client' => 'Amanda Wilson',
                'client_company' => 'Fashion Boutique Inc',
                'project' => 'E-commerce Website Redesign',
                'rating' => 4,
                'comment' => 'Great job on the website redesign. The new design looks amazing and our sales have increased since launch.',
                'date' => now()->subMonths(3)->format('Y-m-d')
            ],
            [
                'id' => 3,
                'client' => 'Michael Johnson',
                'client_company' => 'Health & Fitness Co',
                'project' => 'Mobile App UI Design',
                'rating' => 5,
                'comment' => 'Incredible attention to detail and very creative solutions. The app UI design is beautiful and intuitive.',
                'date' => now()->subMonths(5)->format('Y-m-d')
            ],
        ]);
        
        // Calculate average rating
        $averageRating = $reviews->avg('rating');
        
        return view('job-seeker.reviews', compact('reviews', 'averageRating'));
    }
    
    /**
     * Display the task workspace.
     *
     * @param int $taskId
     * @return \Illuminate\View\View
     */
    public function workspace($taskId)
    {
        // For demo purposes, create a sample task
        $task = [
            'id' => $taskId,
            'title' => 'Web Application Frontend Development',
            'client' => 'TechCorp Solutions',
            'description' => 'Develop a responsive frontend for a web application using React and Tailwind CSS. The application should include a dashboard, user profile, and settings pages.',
            'requirements' => [
                'Responsive design that works on mobile, tablet, and desktop',
                'Dark mode implementation',
                'Accessible according to WCAG 2.1 standards',
                'Cross-browser compatibility',
                'Optimized performance and loading times'
            ],
            'status' => 'in-progress',
            'priority' => 'high',
            'due_date' => now()->addDays(5)->format('Y-m-d'),
            'progress' => 65,
            'attachments' => [
                [
                    'name' => 'design_mockups.zip',
                    'size' => '12MB',
                    'type' => 'application/zip',
                    'uploaded_at' => now()->subDays(7)->format('Y-m-d')
                ],
                [
                    'name' => 'project_requirements.pdf',
                    'size' => '2.3MB',
                    'type' => 'application/pdf',
                    'uploaded_at' => now()->subDays(7)->format('Y-m-d')
                ]
            ],
            'messages' => [
                [
                    'sender' => 'John Smith',
                    'sender_type' => 'client',
                    'message' => 'How is progress on the dashboard page coming along?',
                    'timestamp' => now()->subDays(2)->format('Y-m-d H:i:s')
                ],
                [
                    'sender' => 'You',
                    'sender_type' => 'job-seeker',
                    'message' => 'It\'s going well. I\'ve completed about 70% of the dashboard components. I expect to have a demo ready by tomorrow.',
                    'timestamp' => now()->subDays(2)->addHours(1)->format('Y-m-d H:i:s')
                ],
                [
                    'sender' => 'John Smith',
                    'sender_type' => 'client',
                    'message' => 'Great! Looking forward to seeing it.',
                    'timestamp' => now()->subDays(2)->addHours(2)->format('Y-m-d H:i:s')
                ]
            ]
        ];
        
        return view('job-seeker.workspace', compact('task'));
    }
    
    /**
     * Submit work for a task.
     *
     * @param Request $request
     * @param int $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitWork(Request $request, $taskId)
    {
        $request->validate([
            'work_description' => 'required|string|min:10',
            'hours_worked' => 'required|numeric|min:0.5',
            'work_file' => 'nullable|file|max:10240', // 10MB max
        ]);
        
        // Process the submission (in a real app, this would save to the database)
        
        return redirect()->route('jobseeker.tasks')
            ->with('success', 'Work submitted successfully!');
    }
} 