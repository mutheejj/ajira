<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the job applications for the authenticated job seeker.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::user()->isJobSeeker()) {
            return redirect()->route('jobs.index')
                ->with('error', 'Only job seekers can access this page.');
        }

        $applications = JobApplication::with(['job', 'job.client'])
            ->where('job_seeker_id', Auth::id())
            ->latest('applied_date')
            ->paginate(10);
            
        // Calculate statistics
        $statistics = [
            'total' => JobApplication::where('job_seeker_id', Auth::id())->count(),
            'in_progress' => JobApplication::where('job_seeker_id', Auth::id())
                ->whereIn('status', ['pending', 'reviewing', 'interviewed'])
                ->count(),
            'accepted' => JobApplication::where('job_seeker_id', Auth::id())
                ->where('status', 'accepted')
                ->count(),
            'rejected' => JobApplication::where('job_seeker_id', Auth::id())
                ->where('status', 'rejected')
                ->count(),
        ];

        return view('applications.index', compact('applications', 'statistics'));
    }

    /**
     * Display a listing of the job applications for a specific job post.
     *
     * @param  int  $jobId
     * @return \Illuminate\View\View
     */
    public function applicationsForJob($jobId)
    {
        $job = JobPost::findOrFail($jobId);

        if (Auth::id() !== $job->client_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        $applications = JobApplication::with('jobSeeker')
            ->where('job_id', $jobId)
            ->latest('applied_date')
            ->paginate(10);

        return view('applications.job_applications', compact('applications', 'job'));
    }

    /**
     * Show the form for creating a new job application.
     *
     * @param  int  $jobId
     * @return \Illuminate\View\View
     */
    public function create($jobId)
    {
        if (!Auth::user()->isJobSeeker()) {
            return redirect()->route('jobs.index')
                ->with('error', 'Only job seekers can apply for jobs.');
        }

        $job = JobPost::where('status', 'active')->findOrFail($jobId);

        // Check if user has already applied
        $existingApplication = JobApplication::where('job_seeker_id', Auth::id())
            ->where('job_id', $jobId)
            ->first();

        if ($existingApplication) {
            return redirect()->route('applications.show', $existingApplication->id)
                ->with('info', 'You have already applied for this job.');
        }

        return view('applications.create', compact('job'));
    }

    /**
     * Store a newly created job application in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $jobId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $jobId)
    {
        if (!Auth::user()->isJobSeeker()) {
            return redirect()->route('jobs.index')
                ->with('error', 'Only job seekers can apply for jobs.');
        }

        $job = JobPost::where('status', 'active')->findOrFail($jobId);

        // Check if user has already applied
        $existingApplication = JobApplication::where('job_seeker_id', Auth::id())
            ->where('job_id', $jobId)
            ->first();

        if ($existingApplication) {
            return redirect()->route('applications.show', $existingApplication->id)
                ->with('info', 'You have already applied for this job.');
        }

        $validated = $request->validate([
            'cover_letter' => 'required|string',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        try {
            $application = new JobApplication();
            $application->job_seeker_id = Auth::id();
            $application->job_id = $jobId;
            $application->cover_letter = $validated['cover_letter'];
            $application->status = 'pending';
            
            // Default steps for the application process
            $application->steps = [
                'Application Submitted',
                'Resume Review',
                'Interview',
                'Decision'
            ];

            // Handle resume upload
            if ($request->hasFile('resume')) {
                $path = $request->file('resume')->store('applications/resumes', 'public');
                $application->resume = $path;
            }

            $application->save();

            return redirect()->route('applications.show', $application->id)
                ->with('success', 'Job application submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Error submitting job application: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while submitting your application.');
        }
    }

    /**
     * Display the specified job application.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $application = JobApplication::with(['job', 'job.client', 'jobSeeker'])
            ->findOrFail($id);

        // Check if the user is authorized to view this application
        if (Auth::id() !== $application->job_seeker_id && 
            Auth::id() !== $application->job->client_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        return view('applications.show', compact('application'));
    }

    /**
     * Update the status of a job application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);

        // Only the job client can update the status
        if (Auth::id() !== $application->job->client_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,interviewed,rejected,accepted',
        ]);

        try {
            $oldStatus = $application->status;
            $application->updateStatus($validated['status']);
            
            // If application is being accepted, create a contract and task
            if ($validated['status'] === 'accepted' && $oldStatus !== 'accepted') {
                // Create a new contract
                $contract = new \App\Models\Contract();
                $contract->client_id = $application->job->client_id;
                $contract->job_seeker_id = $application->job_seeker_id;
                $contract->job_id = $application->job_id;
                $contract->title = $application->job->title;
                $contract->description = $application->job->description;
                $contract->amount = $application->job->budget;
                $contract->currency = 'USD'; // Default currency
                $contract->status = 'in_progress';
                $contract->start_date = now();
                $contract->end_date = now()->addDays(30); // Default 30 days
                $contract->save();
                
                // Create a task for the job seeker
                $task = new \App\Models\Task();
                $task->contract_id = $contract->id;
                $task->title = $application->job->title;
                $task->description = $application->job->description;
                $task->status = 'in_progress';
                $task->priority = 'medium';
                $task->due_date = $contract->end_date;
                $task->progress = 0;
                $task->save();
                
                // Create an initial welcome message
                $message = new \App\Models\Message();
                $message->sender_id = $application->job->client_id;
                $message->receiver_id = $application->job_seeker_id;
                $message->task_id = $task->id;
                $message->content = "Welcome to the project! I'm excited to work with you on this task. Feel free to ask any questions.";
                $message->save();
                
                // Update job post status
                $jobPost = $application->job;
                $jobPost->status = 'assigned';
                $jobPost->save();
            }
            
            return redirect()->route('applications.show', $application->id)
                ->with('success', 'Application status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating application status: ' . $e->getMessage());
            return back()
                ->with('error', 'An error occurred while updating the application status.');
        }
    }

    /**
     * Advance the application to the next step.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function advanceStep($id)
    {
        $application = JobApplication::findOrFail($id);

        // Only the job client can advance the step
        if (Auth::id() !== $application->job->client_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        try {
            $application->advanceStep();
            return redirect()->route('applications.show', $application->id)
                ->with('success', 'Application advanced to the next step.');
        } catch (\Exception $e) {
            Log::error('Error advancing application step: ' . $e->getMessage());
            return back()
                ->with('error', 'An error occurred while advancing the application step.');
        }
    }

    /**
     * Withdraw a job application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdraw($id)
    {
        $application = JobApplication::findOrFail($id);

        // Only the job seeker who applied can withdraw the application
        if (Auth::id() !== $application->job_seeker_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        // Only allow withdrawal if the application is still pending
        if ($application->status !== 'pending') {
            return back()
                ->with('error', 'Cannot withdraw application at the current stage.');
        }

        try {
            $application->delete();
            return redirect()->route('applications.index')
                ->with('success', 'Application withdrawn successfully.');
        } catch (\Exception $e) {
            Log::error('Error withdrawing application: ' . $e->getMessage());
            return back()
                ->with('error', 'An error occurred while withdrawing your application.');
        }
    }
} 