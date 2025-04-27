<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobPost;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Message;
use App\Models\Task;
use App\Models\Submission;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'client']);
    }

    /**
     * Display client dashboard with relevant statistics and data.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        // Retrieve statistics
        $stats = [
            'active_jobs' => $user->jobPosts()->where('status', 'active')->count(),
            'total_jobs' => $user->jobPosts()->count(),
            'pending_applications' => 0, // Will be calculated below
            'active_contracts' => 0, // Placeholder for contracts feature
            'conversion_rate' => 0,
            'monthly_spending' => [] // Will be filled below
        ];
        
        // Get job posts with their application counts
        $jobPosts = $user->jobPosts()->latest()->limit(5)->get();
        
        // Calculate pending applications count and get recent applications
        $jobIds = $user->jobPosts()->pluck('id');
        $pendingApplications = \App\Models\Application::whereIn('job_post_id', $jobIds)
            ->where('status', 'pending')
            ->count();
        $recentApplications = \App\Models\Application::whereIn('job_post_id', $jobIds)
            ->with(['user', 'jobPost'])
            ->latest()
            ->limit(5)
            ->get();
        
        $stats['pending_applications'] = $pendingApplications;
        
        // Calculate applications per job count for conversion rate
        $totalApplications = \App\Models\Application::whereIn('job_post_id', $jobIds)->count();
        if ($stats['total_jobs'] > 0) {
            $stats['conversion_rate'] = round(($totalApplications / $stats['total_jobs']) * 100);
        }
        
        // Get top freelancers (based on number of applications to client's jobs)
        $topFreelancers = \App\Models\User::whereHas('applications', function($query) use ($jobIds) {
            $query->whereIn('job_post_id', $jobIds);
        })
        ->withCount(['applications' => function($query) use ($jobIds) {
            $query->whereIn('job_post_id', $jobIds);
        }])
        ->orderBy('applications_count', 'desc')
        ->limit(5)
        ->get();
        
        // Generate monthly spending data for the chart (placeholder)
        $monthlySpending = [];
        
        // Generate labels for the last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthName = $month->format('M');
            $monthlySpending[$monthName] = rand(100, 5000); // Random placeholder data
        }
        
        $stats['monthly_spending'] = $monthlySpending;
        
        return view('client.dashboard', compact('user', 'stats', 'jobPosts', 'recentApplications', 'topFreelancers'));
    }
    
    /**
     * Display all jobs posted by the client.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function jobs(Request $request)
    {
        $user = auth()->user();
        
        // Prepare query with filters
        $query = $user->jobPosts();
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        
        $allowedSortFields = ['created_at', 'title', 'budget'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }
        
        $query->orderBy($sortBy, $sortDir);
        
        // Get jobs with application counts
        $jobs = $query->withCount(['applications', 'applications as accepted_applications_count' => function($query) {
            $query->where('status', 'accepted');
        }])->paginate(10);
        
        // Get status counts for filters
        $statusCounts = [
            'all' => $user->jobPosts()->count(),
            'active' => $user->jobPosts()->where('status', 'active')->count(),
            'completed' => $user->jobPosts()->where('status', 'completed')->count(),
            'draft' => $user->jobPosts()->where('status', 'draft')->count(),
            'closed' => $user->jobPosts()->where('status', 'closed')->count(),
        ];
        
        return view('client.jobs', compact('jobs', 'statusCounts'));
    }
    
    /**
     * Show the form for creating a new job post.
     *
     * @return \Illuminate\Http\Response
     */
    public function createJob()
    {
        try {
            // Get categories and skills for select dropdowns
            $categories = [];
            $skills = [];
            
            // Check if Category model exists
            if (class_exists('\App\Models\Category')) {
                $categories = \App\Models\Category::orderBy('name')->get();
            }
            
            // Check if Skill model exists
            if (class_exists('\App\Models\Skill')) {
                $skills = \App\Models\Skill::orderBy('name')->get();
            }
            
            \Log::info('Loading create job form with categories count: ' . count($categories) . ', skills count: ' . count($skills));
            
            return view('client.create-job', compact('categories', 'skills'));
        } catch (\Exception $e) {
            \Log::error('Error loading create job form: ' . $e->getMessage());
            // Return the view without the models if there's an error
            return view('client.create-job');
        }
    }
    
    /**
     * Store a new job post.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeJob(Request $request)
    {
        \Log::info('Job post data received', ['data' => $request->except('attachment')]);
        
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:100',
                'category' => 'required|string',
                'description' => 'required|string|min:20',
                'skills' => 'required|array|min:1',
                'skills.*' => 'string',
                'budget' => 'required|numeric|min:5',
                'currency' => 'required|string|in:USD,KES,EUR,GBP',
                'rate_type' => 'required|string|in:fixed,hourly',
                'job_type' => 'required|string|in:one-time,ongoing',
                'experience_level' => 'required|string|in:entry,intermediate,expert',
                'location_type' => 'required|string|in:remote,on-site,hybrid',
                'location' => 'nullable|string|max:100',
                'attachment' => 'nullable|file|max:5120',
                'status' => 'nullable|string|in:draft,active',
                'duration' => 'nullable|integer|min:1',
                'application_deadline' => 'nullable|date|after_or_equal:today',
            ]);
            
            \Log::info('Job post validation passed', ['skills' => $request->skills]);
            
            $client = Auth::user();
            
            if (!$client) {
                \Log::error('User not authenticated when trying to post a job');
                return redirect()->route('login')
                    ->with('error', 'You must be logged in to post a job');
            }
            
            $jobPost = new \App\Models\JobPost();
            $jobPost->client_id = $client->id;
            $jobPost->title = $request->title;
            $jobPost->category = $request->category;
            $jobPost->description = $request->description;
            $jobPost->requirements = $request->description; // Use description as requirements for now
            
            // Ensure skills is properly encoded as JSON
            if (is_array($request->skills)) {
                $jobPost->skills = json_encode($request->skills);
                \Log::info('Skills encoded successfully', ['skills_count' => count($request->skills)]);
            } else {
                \Log::warning('Skills is not an array', ['skills' => $request->skills]);
                $jobPost->skills = json_encode([$request->skills]);
            }
            
            $jobPost->budget = $request->budget;
            $jobPost->currency = $request->currency;
            $jobPost->rate_type = $request->rate_type;
            $jobPost->job_type = $request->job_type;
            $jobPost->experience_level = $request->experience_level;
            $jobPost->location_type = $request->location_type;
            $jobPost->location = $request->location;
            $jobPost->status = $request->status ?? 'active';
            $jobPost->duration = $request->duration ?? 30; // Default duration of 30 days
            $jobPost->application_deadline = $request->application_deadline; // Save the application deadline
            
            // Handle attachment if provided
            if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
                try {
                    $path = $request->file('attachment')->store('job_attachments', 'public');
                    $jobPost->attachment = $path;
                    \Log::info('Attachment uploaded successfully', ['path' => $path]);
                } catch (\Exception $e) {
                    \Log::error('Error uploading attachment: ' . $e->getMessage());
                    // Continue without the attachment
                }
            }
            
            $jobPost->save();
            
            \Log::info('Job post created successfully', ['job_id' => $jobPost->id]);
            
            return redirect()->route('client.jobs')
                ->with('success', 'Job post created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error creating job post', [
                'errors' => $e->errors(),
                'input' => $request->except(['attachment'])
            ]);
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            \Log::error('Error creating job post: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'input' => $request->except(['attachment'])
            ]);
            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Show client profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->user();
        
        // Retrieve statistics
        $stats = [
            'active_jobs' => $user->jobPosts()->where('status', 'active')->count(),
            'total_jobs' => $user->jobPosts()->count(),
            'active_contracts' => 0, // Placeholder for contracts feature
            'hired_freelancers' => 0, // Placeholder
        ];
        
        // Get list of countries and industries for dropdowns
        $countries = $this->getCountriesList();
        $industries = $this->getIndustriesList();
        
        return view('client.profile', compact('user', 'stats', 'countries', 'industries'));
    }
    
    /**
     * View all applications for the client's jobs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function applications(Request $request)
    {
        $user = auth()->user();
        $jobIds = $user->jobPosts()->pluck('id')->toArray();
        
        // Prepare query with filters
        $query = Application::with(['user', 'jobPost'])
            ->whereIn('job_post_id', $jobIds);
            
        // Apply filters
        if ($request->filled('job_id')) {
            $query->where('job_post_id', $request->job_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        
        $allowedSortFields = ['created_at', 'bid_amount'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }
        
        $query->orderBy($sortBy, $sortDir);
        
        // Get applications
        $applications = $query->paginate(10);
        
        // Get all client jobs for filter dropdown
        $jobs = $user->jobPosts;
        
        // Calculate statistics for the dashboard
        $statistics = [
            'total' => Application::whereIn('job_post_id', $jobIds)->count(),
            'pending' => Application::whereIn('job_post_id', $jobIds)->where('status', 'pending')->count(),
            'shortlisted' => Application::whereIn('job_post_id', $jobIds)->where('status', 'accepted')->count(),
            'rejected' => Application::whereIn('job_post_id', $jobIds)->where('status', 'rejected')->count()
        ];
        
        // Format the applications to match view expectations
        foreach ($applications as $application) {
            // Add the jobSeeker property that the view expects
            $application->jobSeeker = $application->user;
            
            // Add the job property that the view expects
            $application->job = $application->jobPost;
            
            // Add the match_score property (example calculation - you can improve this)
            $application->match_score = rand(50, 100); // Placeholder for demo
            
            // Add the applied_date property
            $application->applied_date = $application->created_at;
        }
        
        // Get status counts for filters - not used in this view currently
        $statusCounts = [
            'all' => $statistics['total'],
            'pending' => $statistics['pending'],
            'accepted' => $statistics['shortlisted'],
            'rejected' => $statistics['rejected']
        ];
        
        return view('client.applications', compact('applications', 'jobs', 'statistics', 'statusCounts'));
    }
    
    /**
     * Display client's active contracts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activeContracts(Request $request)
    {
        $user = auth()->user();
        
        // Get all contracts for this client with related job, job seeker, and tasks
        $query = \App\Models\Contract::where('client_id', $user->id)
                ->with(['job', 'jobSeeker', 'tasks']);
        
        // Apply filters if needed
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('jobSeeker', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Get contracts
        $activeContracts = $query->paginate(10);
        
        return view('client.active-contracts', compact('activeContracts'));
    }
    
    /**
     * Display a specific task with messages and allow sending instructions.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function viewTask($taskId)
    {
        $user = auth()->user();
        
        // Get the task with related contract, job seeker, and submissions
        $task = \App\Models\Task::with([
            'contract', 
            'contract.jobSeeker', 
            'submissions' => function($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->findOrFail($taskId);
        
        // Ensure the client owns this task
        if ($task->contract->client_id !== $user->id) {
            return redirect()->route('client.active-contracts')
                ->with('error', 'You are not authorized to view this task.');
        }
        
        // Get messages for the task
        $messages = \App\Models\Message::where('task_id', $taskId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Mark unread messages as read
        \App\Models\Message::where('task_id', $taskId)
            ->where('receiver_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Get freelancer/job seeker information
        $jobSeeker = $task->contract->jobSeeker;
        
        return view('client.task-details', [
            'task' => $task,
            'messages' => $messages,
            'jobSeeker' => $jobSeeker
        ]);
    }
    
    /**
     * Send a message for a task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request, $taskId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $task = Task::findOrFail($taskId);
        
        // Ensure the client owns this task
        if ($task->contract->client_id != auth()->id()) {
            return redirect()->back()->with('error', 'You do not have permission to send messages for this task.');
        }

        // Create a new message
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $task->contract->job_seeker_id,
            'task_id' => $task->id,
            'content' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
    
    /**
     * Send task instructions with optional attachment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $taskId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendTaskInstructions(Request $request, $taskId)
    {
        $request->validate([
            'instructions' => 'required|string|max:5000',
            'attachment' => 'nullable|file|max:10240', // 10MB max file size
        ]);

        $task = Task::findOrFail($taskId);
        
        // Ensure the client owns this task
        if ($task->contract->client_id != auth()->id()) {
            return redirect()->back()->with('error', 'You do not have permission to update this task.');
        }

        // Update task instructions
        $task->instructions = $request->instructions;
        
        // Handle file upload if provided
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($task->attachment_path) {
                Storage::disk('public')->delete($task->attachment_path);
            }
            
            $file = $request->file('attachment');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->store('task-attachments', 'public');
            
            $task->attachment_path = $filePath;
            $task->attachment_name = $fileName;
        }
        
        $task->save();
        
        // Create a new message to notify the job seeker
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $task->contract->job_seeker_id,
            'task_id' => $task->id,
            'content' => 'I\'ve updated the task instructions. Please check the task details.',
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Task instructions updated successfully.');
    }
    
    /**
     * Display client payment history.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payments(Request $request)
    {
        $user = auth()->user();
        
        // This is a placeholder - replace with actual payment logic when implemented
        $payments = [];
        
        return view('client.payments', compact('payments'));
    }
    
    /**
     * Display client reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function reports()
    {
        $user = auth()->user();
        
        // This is a placeholder - replace with actual reports logic when implemented
        $reports = [];
        
        return view('client.reports', compact('reports'));
    }
    
    /**
     * Display the task details for a specific task.
     *
     * @param int $taskId
     * @return \Illuminate\Http\Response
     */
    public function taskDetails($taskId)
    {
        $client = auth()->user();
        
        // Get the task with relationships
        $task = Task::where('id', $taskId)
            ->where('client_id', $client->id)
            ->with(['jobSeeker', 'attachments'])
            ->firstOrFail();
        
        // Get submissions for this task
        $submissions = Submission::where('task_id', $task->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get messages for this task
        $messages = Message::where(function($query) use ($client, $task) {
            $query->where('sender_id', $client->id)
                  ->where('receiver_id', $task->job_seeker_id)
                  ->where('task_id', $task->id);
        })->orWhere(function($query) use ($client, $task) {
            $query->where('sender_id', $task->job_seeker_id)
                  ->where('receiver_id', $client->id)
                  ->where('task_id', $task->id);
        })
        ->orderBy('created_at')
        ->get();
        
        // Get job seeker information
        $jobSeeker = $task->jobSeeker;
        
        return view('client.task-details', compact('task', 'submissions', 'messages', 'jobSeeker'));
    }
    
    /**
     * Submit feedback for a submission.
     *
     * @param Request $request
     * @param int $submissionId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitFeedback(Request $request, $submissionId)
    {
        $request->validate([
            'feedback' => 'required|string|max:1000',
            'status' => 'required|in:approved,rejected,pending',
        ]);
        
        $client = auth()->user();
        
        // Get the submission
        $submission = Submission::with(['task' => function($query) use ($client) {
            $query->where('client_id', $client->id);
        }])->findOrFail($submissionId);
        
        // Check if the submission belongs to the client's task
        if (!$submission->task || $submission->task->client_id !== $client->id) {
            return redirect()->route('client.tasks')
                ->with('error', 'Unauthorized access to submission.');
        }
        
        // Update the submission
        $submission->status = $request->status;
        $submission->feedback = $request->feedback;
        $submission->feedback_at = now();
        $submission->save();
        
        // If the submission is approved and this is the latest submission, mark the task as completed
        if ($request->status === 'approved') {
            $latestSubmission = Submission::where('task_id', $submission->task_id)
                ->orderBy('created_at', 'desc')
                ->first();
                
            if ($latestSubmission->id === $submission->id) {
                $submission->task->status = 'completed';
                $submission->task->progress = 100;
                $submission->task->save();
            }
        }
        
        // Send notification to job seeker
        try {
            $jobSeeker = User::find($submission->task->job_seeker_id);
            if ($jobSeeker) {
                \Mail::to($jobSeeker->email)->send(new \App\Mail\SubmissionFeedbackMail($submission, $jobSeeker, $client));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send submission feedback email: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }
    
    /**
     * Update client profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:20',
            'industry' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'profile_photo' => 'nullable|image|max:5120', // 5MB max
        ]);
        
        // Process profile photo if uploaded
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }
            
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $path;
        }
        
        $user->update($validated);
        
        return redirect()->route('client.profile')->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Show billing and payment methods page.
     *
     * @return \Illuminate\Http\Response
     */
    public function billing()
    {
        $user = auth()->user();
        
        // Placeholder data for payment methods
        $paymentMethods = collect([
            (object)[
                'id' => 1,
                'type' => 'credit_card',
                'name' => 'Visa ending in 4242',
                'last4' => '4242',
                'exp_month' => '12',
                'exp_year' => '2025',
                'is_default' => true
            ],
            (object)[
                'type' => 'paypal',
                'name' => 'PayPal',
                'email' => $user->email,
                'is_default' => false
            ]
        ]);
        
        // Placeholder data for transactions
        $transactions = collect([
            (object)[
                'id' => 'inv_123456',
                'description' => 'Pro Subscription',
                'date' => now()->subDays(2),
                'amount' => 49.00,
                'currency' => 'USD',
                'status' => 'successful',
                'type' => 'subscription',
                'plan' => 'Pro'
            ],
            (object)[
                'id' => 'inv_123455',
                'description' => 'Featured Job Listing',
                'date' => now()->subDays(15),
                'amount' => 29.00,
                'currency' => 'USD',
                'status' => 'successful',
                'type' => 'payment',
                'item' => 'Job Boost'
            ],
            (object)[
                'id' => 'inv_123454',
                'description' => 'Pro Subscription',
                'date' => now()->subDays(32),
                'amount' => 49.00,
                'currency' => 'USD',
                'status' => 'successful',
                'type' => 'subscription',
                'plan' => 'Pro'
            ]
        ]);
        
        // Placeholder for billing address
        $billingAddress = (object)[
            'name' => $user->name,
            'address_line1' => '123 Business Ave',
            'address_line2' => 'Suite 101',
            'city' => 'San Francisco',
            'state' => 'CA',
            'postal_code' => '94107',
            'country' => 'United States'
        ];
        
        // Current subscription plan
        $currentPlan = 'pro';
        
        return view('client.billing', compact('user', 'paymentMethods', 'transactions', 'billingAddress', 'currentPlan'));
    }
    
    /**
     * Show email verification page.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifyEmail()
    {
        $user = Auth::user();
        
        return view('client.email-verification', compact('user'));
    }
    
    /**
     * Resend verification email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        
        return back()->with('success', 'Verification link has been sent to your email address.');
    }

    /**
     * Get a list of countries for dropdowns.
     */
    private function getCountriesList()
    {
        return [
            'United States', 'United Kingdom', 'Canada', 'Australia', 
            'Germany', 'France', 'Spain', 'Italy', 'Netherlands',
            'Sweden', 'Norway', 'Denmark', 'Finland', 'Ireland',
            'Belgium', 'Switzerland', 'Austria', 'Portugal', 'Greece',
            'Poland', 'Czech Republic', 'Hungary', 'Romania', 'Bulgaria',
            'Croatia', 'Slovakia', 'Slovenia', 'Estonia', 'Latvia',
            'Lithuania', 'Luxembourg', 'Malta', 'Cyprus', 'Iceland',
            'India', 'China', 'Japan', 'South Korea', 'Singapore',
            'Malaysia', 'Indonesia', 'Thailand', 'Vietnam', 'Philippines',
            'Brazil', 'Mexico', 'Argentina', 'Chile', 'Colombia',
            'Peru', 'South Africa', 'Nigeria', 'Kenya', 'Egypt',
            'Morocco', 'Israel', 'United Arab Emirates', 'Saudi Arabia',
            'New Zealand', 'Russia', 'Ukraine', 'Turkey'
        ];
    }

    /**
     * Get a list of industries for dropdowns.
     */
    private function getIndustriesList()
    {
        return [
            'Technology', 'Software Development', 'Information Technology', 
            'E-commerce', 'Digital Marketing', 'Design', 'Healthcare', 
            'Finance', 'Education', 'Manufacturing', 'Retail', 
            'Transportation', 'Hospitality', 'Media', 'Entertainment', 
            'Real Estate', 'Construction', 'Agriculture', 'Energy', 
            'Environmental Services', 'Non-profit', 'Government', 
            'Legal Services', 'Consulting', 'Human Resources', 
            'Telecommunications', 'Automotive', 'Aerospace', 
            'Biotechnology', 'Pharmaceuticals', 'Food & Beverage'
        ];
    }

    /**
     * Display client's tasks.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function tasks(Request $request)
    {
        $user = auth()->user();
        
        // Prepare query with filters
        $query = Task::where('client_id', $user->id);
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        
        $allowedSortFields = ['created_at', 'title', 'due_date', 'priority', 'status'];
        if (!in_array($sortBy, $allowedSortFields)) {
            $sortBy = 'created_at';
        }
        
        $query->orderBy($sortBy, $sortDir);
        
        // Get tasks with relationships including submissions and messages
        $tasks = $query->with([
            'contract', 
            'contract.jobSeeker', 
            'jobSeeker', 
            'submissions', 
            'messages'
        ])->paginate(10);
        
        // Get status counts for filters and statistics
        $statusCounts = [
            'all' => Task::where('client_id', $user->id)->count(),
            'pending' => Task::where('client_id', $user->id)->where('status', 'pending')->count(),
            'in_progress' => Task::where('client_id', $user->id)->where('status', 'in_progress')->count(),
            'completed' => Task::where('client_id', $user->id)->where('status', 'completed')->count(),
        ];
        
        // Prepare task statistics for the dashboard
        $taskStats = [
            'total' => $statusCounts['all'],
            'pending' => $statusCounts['pending'],
            'in_progress' => $statusCounts['in_progress'],
            'completed' => $statusCounts['completed'],
            'cancelled' => Task::where('client_id', $user->id)->where('status', 'cancelled')->count(),
        ];
        
        // Get job seekers who have accepted applications for this client's job posts
        $jobSeekers = User::whereHas('applications', function($query) use ($user) {
            $query->where('status', 'accepted')
                  ->whereHas('jobPost', function($q) use ($user) {
                      $q->where('client_id', $user->id);
                  });
        })->get();
        
        return view('client.tasks', compact('tasks', 'statusCounts', 'taskStats', 'jobSeekers', 'user'));
    }
    
    /**
     * Create a new task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createTask(Request $request)
    {
        $request->validate([
            'job_seeker_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after_or_equal:today',
            'priority' => 'required|in:low,medium,high',
            'payment' => 'required|numeric|min:1',
            'contract_id' => 'nullable|exists:contracts,id',
            'attachments.*' => 'nullable|file|max:10240', // 10MB limit per file
        ]);
        
        $client = auth()->user();
        $jobSeeker = User::findOrFail($request->job_seeker_id);
        
        // Create the task
        $task = new Task();
        $task->client_id = $client->id;
        $task->job_seeker_id = $jobSeeker->id;
        
        // Set contract_id if provided
        if ($request->filled('contract_id') && $request->contract_id != 'null') {
            // Verify the contract belongs to this client and the job seeker
            $contract = \App\Models\Contract::where('id', $request->contract_id)
                ->where('client_id', $client->id)
                ->first();
                
            if ($contract) {
                $task->contract_id = $contract->id;
            } else {
                // If no valid contract is found, create a default one
                
                // First, find a job post that this job seeker has applied to and been accepted for
                $application = \App\Models\Application::where('user_id', $jobSeeker->id)
                    ->where('status', 'accepted')
                    ->whereHas('jobPost', function($q) use ($client) {
                        $q->where('client_id', $client->id);
                    })
                    ->with('jobPost')
                    ->first();
                    
                if (!$application) {
                    // If no application is found, create a dummy job post
                    $jobPost = new \App\Models\JobPost();
                    $jobPost->client_id = $client->id;
                    $jobPost->title = "Job for " . $request->title;
                    $jobPost->description = "Automatically created job for task: " . $request->title;
                    $jobPost->category = "Other";
                    $jobPost->skills = json_encode(["Other"]);
                    $jobPost->budget = $request->payment;
                    $jobPost->currency = "USD";
                    $jobPost->rate_type = "fixed";
                    $jobPost->job_type = "one-time";
                    $jobPost->experience_level = "intermediate";
                    $jobPost->location_type = "remote";
                    $jobPost->status = "active";
                    $jobPost->save();
                    
                    // Create an application for this job post
                    $application = new \App\Models\Application();
                    $application->job_post_id = $jobPost->id;
                    $application->user_id = $jobSeeker->id;
                    $application->cover_letter = "Automatically created application for task: " . $request->title;
                    $application->bid_amount = $request->payment;
                    $application->status = "accepted";
                    $application->save();
                    
                    $jobId = $jobPost->id;
                } else {
                    $jobId = $application->jobPost->id;
                }
                
                $contract = new \App\Models\Contract();
                $contract->job_id = $jobId;
                $contract->client_id = $client->id;
                $contract->job_seeker_id = $jobSeeker->id;
                $contract->title = "Contract for " . $request->title;
                $contract->description = "Automatically created contract for task: " . $request->title;
                $contract->amount = $request->payment;
                $contract->currency = "USD";
                $contract->status = 'pending';
                $contract->start_date = now();
                $contract->end_date = $request->due_date;
                $contract->payment_terms = "Fixed payment";
                $contract->payment_schedule = "One-time payment";
                $contract->save();
                
                $task->contract_id = $contract->id;
            }
        } else {
            // If no contract_id is provided, create a default one
            
            // First, find a job post that this job seeker has applied to and been accepted for
            $application = \App\Models\Application::where('user_id', $jobSeeker->id)
                ->where('status', 'accepted')
                ->whereHas('jobPost', function($q) use ($client) {
                    $q->where('client_id', $client->id);
                })
                ->with('jobPost')
                ->first();
                
            if (!$application) {
                // If no application is found, create a dummy job post
                $jobPost = new \App\Models\JobPost();
                $jobPost->client_id = $client->id;
                $jobPost->title = "Job for " . $request->title;
                $jobPost->description = "Automatically created job for task: " . $request->title;
                $jobPost->category = "Other";
                $jobPost->skills = json_encode(["Other"]);
                $jobPost->budget = $request->payment;
                $jobPost->currency = "USD";
                $jobPost->rate_type = "fixed";
                $jobPost->job_type = "one-time";
                $jobPost->experience_level = "intermediate";
                $jobPost->location_type = "remote";
                $jobPost->status = "active";
                $jobPost->save();
                
                // Create an application for this job post
                $application = new \App\Models\Application();
                $application->job_post_id = $jobPost->id;
                $application->user_id = $jobSeeker->id;
                $application->cover_letter = "Automatically created application for task: " . $request->title;
                $application->bid_amount = $request->payment;
                $application->status = "accepted";
                $application->save();
                
                $jobId = $jobPost->id;
            } else {
                $jobId = $application->jobPost->id;
            }
            
            $contract = new \App\Models\Contract();
            $contract->job_id = $jobId;
            $contract->client_id = $client->id;
            $contract->job_seeker_id = $jobSeeker->id;
            $contract->title = "Contract for " . $request->title;
            $contract->description = "Automatically created contract for task: " . $request->title;
            $contract->amount = $request->payment;
            $contract->currency = "USD";
            $contract->status = 'pending';
            $contract->start_date = now();
            $contract->end_date = $request->due_date;
            $contract->payment_terms = "Fixed payment";
            $contract->payment_schedule = "One-time payment";
            $contract->save();
            
            $task->contract_id = $contract->id;
        }
        
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->priority = $request->priority;
        $task->status = 'pending';
        $task->payment = $request->payment;
        $task->save();
        
        // Handle file attachments
        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('task_attachments/' . $task->id, 'public');
                
                $attachment = new \App\Models\TaskAttachment();
                $attachment->task_id = $task->id;
                $attachment->file_name = $file->getClientOriginalName();
                $attachment->file_path = $path;
                $attachment->file_size = $file->getSize();
                $attachment->save();
            }
        }
        
        // Send email notification to the job seeker
        try {
            \Mail::to($jobSeeker->email)->send(new \App\Mail\TaskAssignedMail($task, $client, $jobSeeker));
        } catch (\Exception $e) {
            \Log::error('Failed to send task assignment email: ' . $e->getMessage());
        }
        
        return redirect()->route('client.tasks')
            ->with('success', 'Task created successfully and notification sent to ' . $jobSeeker->name);
    }
}