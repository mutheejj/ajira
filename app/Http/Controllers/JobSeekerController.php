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
use App\Models\Message;
use App\Models\Submission;

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
     * Display the job seeker dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get application statistics
        $applications = JobApplication::where('job_seeker_id', $user->id);
        $applicationStats = [
            'total' => $applications->count(),
            'in_progress' => $applications->whereIn('status', ['pending', 'reviewing', 'interviewed'])->count(),
            'accepted' => $applications->where('status', 'accepted')->count(),
            'rejected' => $applications->where('status', 'rejected')->count(),
        ];
        
        // Get active tasks
        $contracts = Contract::where('job_seeker_id', $user->id)
            ->with(['job', 'job.client', 'tasks'])
            ->get();
            
        $tasks = collect();
        foreach ($contracts as $contract) {
            $contractTasks = $contract->tasks->map(function($task) use ($contract) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'client' => $contract->job->client->name,
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'due_date' => $task->due_date,
                    'progress' => $task->progress
                ];
            });
            $tasks = $tasks->concat($contractTasks);
        }
        
        // Get recent work logs
        $workLogs = WorkLog::where('job_seeker_id', $user->id)
            ->with(['task', 'task.contract.job.client'])
            ->latest()
            ->take(5)
            ->get();
            
        // Get earnings statistics
        $earnings = [
            'total' => Contract::where('job_seeker_id', $user->id)
                ->where('status', 'completed')
                ->sum('amount'),
            'pending' => Contract::where('job_seeker_id', $user->id)
                ->where('status', 'in_progress')
                ->sum('amount'),
        ];
        
        return view('job-seeker.dashboard', compact(
            'applicationStats',
            'tasks',
            'workLogs',
            'earnings'
        ));
    }
    
    /**
     * Display job seeker's active tasks.
     *
     * @return \Illuminate\View\View
     */
    public function activeTasks()
    {
        $userId = Auth::id();
        
        // Get job applications for the job seeker (from JobApplication model)
        $jobApplications = JobApplication::where('job_seeker_id', $userId)
            ->with(['job', 'job.client'])
            ->get();
            
        // Also check for applications from the Application model
        $standardApplications = collect();
        if (class_exists(\App\Models\Application::class)) {
            $standardApplications = \App\Models\Application::where('user_id', $userId)
                ->with(['jobPost', 'jobPost.client'])
                ->get()
                ->map(function($application) {
                    // Transform to match JobApplication structure as an array instead of stdClass
                    return [
                        'id' => $application->id,
                        'job_id' => $application->job_post_id,
                        'job_seeker_id' => $application->user_id,
                        'status' => $application->status,
                        'created_at' => $application->created_at,
                        'cover_letter' => $application->cover_letter,
                        'job' => $application->jobPost,
                        'client' => $application->jobPost->client ?? null,
                    ];
                });
        }
        
        // Combine both types of applications using concat instead of merge
        $applications = $jobApplications->concat($standardApplications);

        // Get actual tasks from the database
        $contracts = Contract::where('job_seeker_id', $userId)
            ->with(['job', 'job.client', 'tasks'])
            ->get();
            
        $tasks = collect();
        
        foreach ($contracts as $contract) {
            $contractTasks = $contract->tasks->map(function($task) use ($contract) {
                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'client' => $contract->job->client->name,
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'due_date' => $task->due_date,
                    'progress' => $task->progress
                ];
            });
            
            $tasks = $tasks->concat($contractTasks);
        }
        
        // For accepted applications without a contract yet, create placeholder tasks
        foreach ($applications as $application) {
            $applicationStatus = is_object($application) ? $application->status : $application['status'];
            
            if ($applicationStatus === 'accepted') {
                // Check if this job already has a contract with tasks
                $jobId = is_object($application) ? ($application->job_id ?? $application->job->id) : ($application['job_id'] ?? $application['job']->id);
                
                // Check if this job already has tasks in the $tasks collection
                $hasExistingTasks = $contracts->filter(function($contract) use ($jobId) {
                        return $contract->job_id == $jobId;
                    })->count() > 0;
                
                // If no tasks exist yet, create a placeholder task
                if (!$hasExistingTasks) {
                    $job = is_object($application) ? $application->job : $application['job'];
                    $client = is_object($application) ? ($job->client ?? null) : ($job->client ?? null);
                    
                    // Only add if we have job and client information
                    if ($job && $client) {
                        $tasks->push([
                            'id' => 'pending_' . $jobId,
                            'title' => 'Initial Setup: ' . $job->title,
                            'description' => 'Your application has been accepted. Tasks will be assigned to you soon.',
                            'client' => $client->name,
                            'status' => 'pending',
                            'priority' => 'medium',
                            'due_date' => now()->addDays(7),
                            'progress' => 0
                        ]);
                    }
                }
            }
        }
        
        return view('job-seeker.tasks', compact('tasks', 'applications'));
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
        $jobSeekerId = Auth::id(); // Get the logged-in job seeker's ID

        // Fetch contracts for the logged-in job seeker from the database
        // Adjust the query based on your actual database structure and relationships
        $contracts = Contract::where('job_seeker_id', $jobSeekerId)
                             ->with('client') // Eager load client info if relationship exists
                             ->orderBy('start_date', 'desc')
                             ->get()
                             ->map(function ($contract) {
                                 // Format or structure data as needed for the view
                                 return [
                                     'id' => $contract->id,
                                     'title' => $contract->title,
                                     // Assuming a 'client' relationship exists returning a User model with a 'name' attribute
                                     // Or if client name is directly on the contract table, use $contract->client_name
                                     'client' => $contract->client->name ?? 'N/A',
                                     'start_date' => $contract->start_date->format('Y-m-d'),
                                     'end_date' => $contract->end_date ? $contract->end_date->format('Y-m-d') : null, // Handle potential null end dates
                                     'status' => $contract->status,
                                     'payment_type' => $contract->payment_type,
                                     'rate' => $contract->rate, // Hourly rate or fixed price based on payment_type
                                     'total_earned' => $contract->total_earned ?? 0 // Assuming a total_earned field exists
                                 ];
                             });

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
     * Display the workspace for a specific task.
     *
     * @param string $taskId
     * @return \Illuminate\View\View
     */
    public function workspace($taskId)
    {
        $user = Auth::user();
        
        // Determine if taskId is a pending placeholder or a real task ID
        if (strpos($taskId, 'pending_') === 0) {
            // This is a pending setup task based on an accepted application
            $jobId = substr($taskId, 8); // Remove 'pending_' prefix
            
            // Get the application for this job
            $application = \App\Models\Application::where('user_id', $user->id)
                ->whereHas('jobPost', function($query) use ($jobId) {
                    $query->where('id', $jobId);
                })
                ->with(['jobPost', 'jobPost.client'])
                ->first();
            
            if (!$application) {
                return redirect()->route('jobseeker.tasks')
                    ->with('error', 'Task not found or you do not have access to this task.');
            }
            
            // Construct a pending task template
            $task = [
                'id' => $taskId,
                'title' => 'Initial Setup: ' . $application->jobPost->title,
                'description' => $application->jobPost->description,
                'client' => $application->jobPost->client->name,
                'client_id' => $application->jobPost->client->id,
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => now()->addDays(7),
                'progress' => 0,
                'is_pending_setup' => true,
            ];
            
            $client = $application->jobPost->client;
            
            // Get messages between the job seeker and client
            $messages = Message::where(function($query) use ($user, $client) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $client->id);
            })->orWhere(function($query) use ($user, $client) {
                $query->where('sender_id', $client->id)
                      ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at')
            ->get();
            
            return view('job-seeker.workspace', compact('task', 'client', 'messages'));
        } else {
            // This is a real task with a numeric ID
            $task = Task::where('id', $taskId)
                ->where('job_seeker_id', $user->id)
                ->first();
            
            if (!$task) {
                // If not found, check if this is a task recently created by a client
                $task = Task::where('id', $taskId)
                    ->where('job_seeker_id', $user->id)
                    ->first();
                
                if (!$task) {
                    return redirect()->route('jobseeker.tasks')
                        ->with('error', 'Task not found or you do not have access to this task.');
                }
            }
            
            // Get the client
            $client = User::find($task->client_id);
            
            if (!$client) {
                return redirect()->route('jobseeker.tasks')
                    ->with('error', 'Client information not found for this task.');
            }
            
            // Transform to match view expectations
            $taskData = [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'client' => $client->name,
                'client_id' => $client->id,
                'status' => $task->status,
                'priority' => $task->priority,
                'due_date' => $task->due_date,
                'progress' => $task->progress ?? 0,
                'payment' => $task->payment,
                'contract_details' => $task->contract_id ? 'Part of contract #' . $task->contract_id : 'Direct assignment',
            ];
            
            // Get task attachments
            if ($task->attachments()->count() > 0) {
                $taskData['attachments'] = $task->attachments->map(function($attachment) {
                    return [
                        'name' => $attachment->file_name,
                        'url' => $attachment->file_url,
                    ];
                });
            }
            
            // Get previous submissions
            $submissions = Submission::where('task_id', $task->id)
                ->orderBy('created_at', 'desc')
                ->get();
            
            if ($submissions->count() > 0) {
                $taskData['submissions'] = $submissions;
            }
            
            // Get messages between the job seeker and client
            $messages = Message::where(function($query) use ($user, $client) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $client->id);
            })->orWhere(function($query) use ($user, $client) {
                $query->where('sender_id', $client->id)
                      ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at')
            ->get();
            
            return view('job-seeker.workspace', compact('taskData', 'client', 'messages'));
        }
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
        // Validate input
        $validated = $request->validate([
            'submission_type' => 'required|in:file,link,text',
            'work_file' => 'required_if:submission_type,file|file|max:10240|mimes:pdf,doc,docx,zip,rar,jpg,jpeg,png',
            'work_link' => 'required_if:submission_type,link|url',
            'work_text' => 'required_if:submission_type,text',
            'comment' => 'nullable|string|max:1000',
        ]);
        
        $user = Auth::user();
        
        // Log submission data for debugging
        \Log::info('Submission data received:', [
            'submission_type' => $request->submission_type,
            'has_file' => $request->hasFile('work_file'),
            'work_link' => $request->work_link,
            'work_text' => $request->work_text,
            'comment' => $request->comment
        ]);
        
        // Check if the task ID is valid
        if (strpos($taskId, 'pending_') === 0) {
            return redirect()->back()->with('error', 'Cannot submit work for a pending task. Please wait for the client to assign specific tasks.');
        }
        
        // Find the task
        $task = Task::where('id', $taskId)
            ->where('job_seeker_id', $user->id)
            ->first();
        
        if (!$task) {
            return redirect()->route('jobseeker.tasks')
                ->with('error', 'Task not found or you do not have access to this task.');
        }
        
        // Create a new submission
        $submission = new Submission();
        $submission->task_id = $task->id;
        $submission->user_id = $user->id;
        $submission->submission_type = $request->submission_type;
        $submission->description = $request->comment ?? 'No description provided';
        $submission->status = 'pending';
        $submission->hours_worked = 0;
        
        // Handle the submission based on type
        if ($request->submission_type === 'file' && $request->hasFile('work_file')) {
            $file = $request->file('work_file');
            
            // Log file details
            \Log::info('File details', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
                'error' => $file->getError()
            ]);
            
            $fileName = time() . '_' . $file->getClientOriginalName();
            try {
                $filePath = $file->storeAs('submissions/' . $task->id, $fileName, 'public');
                
                \Log::info('File stored successfully', [
                    'path' => $filePath
                ]);
                
                $submission->file_name = $file->getClientOriginalName();
                $submission->file_path = $filePath;
                $submission->file_url = asset('storage/' . $filePath);
                $submission->file_type = $file->getClientMimeType();
                $submission->file_size = $file->getSize();
            } catch (\Exception $e) {
                \Log::error('File upload error', [
                    'error' => $e->getMessage()
                ]);
                return redirect()->back()->with('error', 'File upload failed: ' . $e->getMessage());
            }
        } elseif ($request->submission_type === 'link') {
            $submission->external_link = $request->work_link;
        } elseif ($request->submission_type === 'text') {
            $submission->submission_text = $request->work_text;
        } else {
            // Log error if we reach this point
            \Log::error('Invalid submission type or missing required data', [
                'submission_type' => $request->submission_type,
                'has_file' => $request->hasFile('work_file'),
            ]);
            
            return redirect()->back()->with('error', 'Invalid submission. Please make sure to provide the required ' . $request->submission_type . ' data.');
        }
        
        $submission->save();
        
        // Update task status if it was pending
        if ($task->status === 'pending') {
            $task->status = 'in_progress';
            $task->save();
        }
        
        // Send notification to client
        try {
            $client = User::find($task->client_id);
            if ($client) {
                // Create a message to notify the client
                Message::create([
                    'sender_id' => $user->id,
                    'receiver_id' => $client->id,
                    'task_id' => $task->id,
                    'content' => 'I have submitted my work for review. Please check the submission.',
                    'is_read' => false,
                ]);
                
                // Send email notification
                \Mail::to($client->email)->send(new \App\Mail\SubmissionReceivedMail($submission, $task, $user, $client));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send submission notification: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Your work has been submitted successfully.');
    }
    
    /**
     * Send a message to a client about a task.
     *
     * @param Request $request
     * @param int $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request, $taskId)
    {
        // Validate input
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);
        
        $user = Auth::user();
        
        // Check if the task ID is valid
        if (strpos($taskId, 'pending_') === 0) {
            // This is a pending setup task, we'll store the message without a task ID
            $message = new Message();
            $message->sender_id = $user->id;
            $message->receiver_id = $request->recipient_id;
            $message->content = $request->message;
            $message->save();
            
            return redirect()->back()->with('success', 'Your message has been sent.');
        }
        
        // Find the task
        $task = Task::where('id', $taskId)
            ->where('job_seeker_id', $user->id)
            ->first();
        
        if (!$task) {
            return redirect()->route('jobseeker.tasks')
                ->with('error', 'Task not found or you do not have access to this task.');
        }
        
        // Get the client
        $client = User::find($task->client_id);
        
        if (!$client) {
            return redirect()->route('jobseeker.tasks')
                ->with('error', 'Client information not found for this task.');
        }
        
        // Create a new message
        $message = new Message();
        $message->sender_id = $user->id;
        $message->receiver_id = $client->id;
        $message->task_id = $task->id;
        $message->content = $request->message;
        $message->is_read = false;
        $message->save();
        
        // Send email notification to client
        try {
            \Mail::to($client->email)->send(new \App\Mail\NewMessageMail($message, $task, $user, $client));
        } catch (\Exception $e) {
            \Log::error('Failed to send message notification email: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Your message has been sent.');
    }
    
    /**
     * Mark a task as completed.
     *
     * @param int $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeTask($taskId)
    {
        $user = Auth::user();
        
        // Find the task
        $task = Task::where('id', $taskId)
            ->where('job_seeker_id', $user->id)
            ->first();
        
        if (!$task) {
            return redirect()->route('jobseeker.tasks')
                ->with('error', 'Task not found or you do not have access to this task.');
        }
        
        // Update the task status to completed
        $task->status = 'completed';
        $task->progress = 100;
        $task->save();
        
        // Notify the client
        try {
            $client = User::find($task->client_id);
            if ($client) {
                // Create a message to notify the client
                Message::create([
                    'sender_id' => $user->id,
                    'receiver_id' => $client->id,
                    'task_id' => $task->id,
                    'content' => 'I have marked this task as completed.',
                    'is_read' => false,
                ]);
                
                // Send email notification
                if (class_exists(\App\Mail\TaskCompletedMail::class)) {
                    \Mail::to($client->email)->send(new \App\Mail\TaskCompletedMail($task, $user, $client));
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send task completion notification: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Task has been marked as completed.');
    }
} 