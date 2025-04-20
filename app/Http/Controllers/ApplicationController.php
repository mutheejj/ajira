<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\ApplicationSubmittedMail;
use App\Mail\ApplicationStatusChangedMail;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
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
     * Show the application form for a specific job.
     *
     * @param  int  $jobId
     * @return \Illuminate\Http\Response
     */
    public function create($jobId)
    {
        $jobPost = JobPost::findOrFail($jobId);
        
        // Check if job application deadline has passed
        if ($jobPost->application_deadline && now() > $jobPost->application_deadline) {
            return redirect()->route('jobs.show', $jobId)
                ->with('error', 'The application deadline for this job has passed.');
        }
        
        // Check if user is already applied for this job
        $alreadyApplied = Application::where('job_post_id', $jobId)
            ->where('user_id', Auth::id())
            ->exists();
            
        if ($alreadyApplied) {
            return redirect()->route('jobs.show', $jobId)
                ->with('error', 'You have already applied for this job.');
        }
        
        // Check if user is the job poster
        if ($jobPost->client_id == Auth::id()) {
            return redirect()->route('jobs.show', $jobId)
                ->with('error', 'You cannot apply for your own job posting.');
        }
        
        return view('applications.create', compact('jobPost'));
    }

    /**
     * Store a newly created application in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $jobId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $jobId)
    {
        $jobPost = JobPost::findOrFail($jobId);
        
        // Check if job application deadline has passed
        if ($jobPost->application_deadline && now() > $jobPost->application_deadline) {
            return redirect()->route('jobs.show', $jobId)
                ->with('error', 'The application deadline for this job has passed.');
        }
        
        // Validate request
        $request->validate([
            'cover_letter' => 'required|string|min:10|max:5000',
            'bid_amount' => 'required|numeric|min:' . ($jobPost->budget * 0.5) . '|max:' . ($jobPost->budget * 2),
            'estimated_duration' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB max
        ]);
        
        // Handle attachment upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('application_attachments', 'public');
        }
        
        // Create application
        $application = new Application();
        $application->job_post_id = $jobId;
        $application->user_id = Auth::id();
        $application->cover_letter = $request->cover_letter;
        $application->bid_amount = $request->bid_amount;
        $application->estimated_duration = $request->estimated_duration;
        $application->attachment = $attachmentPath;
        $application->status = 'pending';
        $application->save();
        
        // Send email notification to client
        try {
            Mail::to($jobPost->client->email)->send(new ApplicationSubmittedMail($application));
        } catch (\Exception $e) {
            // Log email error but continue with the process
            \Log::error('Failed to send application notification email: ' . $e->getMessage());
        }
        
        return view('applications.success', compact('application', 'jobPost'));
    }
    
    /**
     * Display the details of an application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $application = Application::with(['jobPost', 'user'])->findOrFail($id);
        
        // Check if user is authorized to view this application
        $user = Auth::user();
        if ($user->id !== $application->user_id && 
            $user->id !== $application->jobPost->client_id && 
            $user->user_type !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to view this application.');
        }
        
        return view('applications.show', compact('application'));
    }
    
    /**
     * Update the status of an application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        
        // Check if user is authorized to update this application
        if (Auth::id() !== $application->jobPost->client_id && Auth::user()->user_type !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to update this application.');
        }
        
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,withdrawn',
            'feedback' => 'nullable|string|max:1000',
        ]);
        
        $oldStatus = $application->status;
        $application->status = $request->status;
        
        if ($request->has('feedback')) {
            $application->feedback = $request->feedback;
        }
        
        $application->save();
        
        // Create a contract if application is accepted
        if ($request->status === 'accepted' && $oldStatus !== 'accepted') {
            // Create a new contract
            $contract = new \App\Models\Contract();
            $contract->client_id = $application->jobPost->client_id;
            $contract->job_seeker_id = $application->user_id;
            $contract->job_id = $application->job_post_id;
            $contract->amount = $application->bid_amount;
            $contract->title = $application->jobPost->title;
            $contract->description = $application->jobPost->description;
            $contract->currency = 'USD';
            $contract->start_date = now();
            
            // Calculate end date based on estimated duration
            $durationParts = explode(' ', $application->estimated_duration);
            $durationValue = (int) $durationParts[0];
            $durationType = strtolower($durationParts[1]);
            
            if (strpos($durationType, 'day') !== false) {
                $contract->end_date = now()->addDays($durationValue);
            } elseif (strpos($durationType, 'week') !== false) {
                $contract->end_date = now()->addWeeks($durationValue);
            } elseif (strpos($durationType, 'month') !== false) {
                $contract->end_date = now()->addMonths($durationValue);
            } else {
                // Default to 30 days if duration type is unknown
                $contract->end_date = now()->addDays(30);
            }
            
            $contract->status = 'active';
            $contract->save();
            
            // Create a task for the job seeker
            $task = new \App\Models\Task();
            $task->contract_id = $contract->id;
            $task->title = $application->jobPost->title;
            $task->description = $application->jobPost->description;
            $task->status = 'in_progress'; // Using the correct status from Task::STATUS_CHOICES
            $task->priority = 'medium';
            $task->due_date = $contract->end_date;
            $task->progress = 0;
            $task->save();
            
            // Create an initial welcome message
            $message = new \App\Models\Message();
            $message->sender_id = $application->jobPost->client_id;
            $message->receiver_id = $application->user_id;
            $message->task_id = $task->id;
            $message->content = "Welcome to the project! I'm excited to work with you on this task. Feel free to ask any questions.";
            $message->save();
            
            // Update job post status
            $jobPost = $application->jobPost;
            $jobPost->status = 'assigned';
            $jobPost->save();
            
            // Send notification to the freelancer about contract creation
            try {
                // You can send an email notification here
                Mail::to($application->user->email)->send(new \App\Mail\ContractCreatedMail($contract));
            } catch (\Exception $e) {
                // Log email error but continue with the process
                \Log::error('Failed to send contract creation email: ' . $e->getMessage());
            }
        }
        
        // Send status change email to the applicant
        try {
            Mail::to($application->user->email)->send(new ApplicationStatusChangedMail($application, $oldStatus));
        } catch (\Exception $e) {
            // Log email error but continue with the process
            \Log::error('Failed to send application status change email: ' . $e->getMessage());
        }
        
        return redirect()->route('applications.show', $id)
            ->with('success', 'Application status updated successfully.');
    }
    
    /**
     * Withdraw an application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function withdraw($id)
    {
        $application = Application::findOrFail($id);
        
        // Check if user is authorized to withdraw this application
        if (Auth::id() !== $application->user_id) {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to withdraw this application.');
        }
        
        // Check if application can be withdrawn
        if ($application->status !== 'pending') {
            return redirect()->route('applications.show', $id)
                ->with('error', 'You can only withdraw pending applications.');
        }
        
        $oldStatus = $application->status;
        $application->status = 'withdrawn';
        $application->save();
        
        // Send status change email to the applicant
        try {
            Mail::to($application->user->email)->send(new ApplicationStatusChangedMail($application, $oldStatus));
        } catch (\Exception $e) {
            // Log email error but continue with the process
            \Log::error('Failed to send application withdrawal email: ' . $e->getMessage());
        }
        
        return redirect()->route('applications.my')
            ->with('success', 'Your application has been withdrawn successfully.');
    }
    
    /**
     * List all applications for a job.
     *
     * @param  int  $jobId
     * @return \Illuminate\Http\Response
     */
    public function listByJob($jobId)
    {
        $jobPost = JobPost::with('client')->findOrFail($jobId);
        
        // Check if user is authorized to view applications for this job
        if (Auth::id() !== $jobPost->client_id && Auth::user()->user_type !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to view applications for this job.');
        }
        
        $applications = Application::with('user')
            ->where('job_post_id', $jobId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('applications.list', compact('jobPost', 'applications'));
    }
    
    /**
     * List all applications for the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function myApplications()
    {
        $applications = Application::with(['jobPost', 'jobPost.client'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('applications.my-applications', compact('applications'));
    }
    
    /**
     * Download application attachment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function downloadAttachment($id)
    {
        $application = Application::findOrFail($id);
        
        // Check if user is authorized to download this attachment
        $user = Auth::user();
        if ($user->id !== $application->user_id && 
            $user->id !== $application->jobPost->client_id && 
            $user->user_type !== 'admin') {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to download this attachment.');
        }
        
        if (!$application->attachment) {
            return redirect()->back()->with('error', 'No attachment found for this application.');
        }
        
        return Storage::disk('public')->download($application->attachment);
    }

    /**
     * Display a success page after application submission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function success($id)
    {
        $application = Application::with(['jobPost', 'user'])->findOrFail($id);
        
        // Check if user is authorized to view this success page
        if (Auth::id() !== $application->user_id) {
            return redirect()->route('dashboard')
                ->with('error', 'You are not authorized to view this page.');
        }
        
        $jobPost = $application->jobPost;
        
        return view('applications.success', compact('application', 'jobPost'));
    }
} 