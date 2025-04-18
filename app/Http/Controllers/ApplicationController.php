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
            'cover_letter' => 'required|string|min:100|max:5000',
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