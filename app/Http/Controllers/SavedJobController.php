<?php

namespace App\Http\Controllers;

use App\Models\SavedJob;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SavedJobController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('job-seeker');
    }

    /**
     * Display a listing of the saved jobs.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $savedJobs = SavedJob::with(['job', 'job.client'])
            ->where('job_seeker_id', Auth::id())
            ->latest('saved_date')
            ->paginate(10);

        return view('saved_jobs.index', compact('savedJobs'));
    }

    /**
     * Save a job for the authenticated user.
     *
     * @param  int  $jobId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($jobId)
    {
        $job = JobPost::findOrFail($jobId);

        // Check if job is already saved
        $existingSavedJob = SavedJob::where('job_seeker_id', Auth::id())
            ->where('job_id', $jobId)
            ->first();

        if ($existingSavedJob) {
            return redirect()->back()
                ->with('info', 'You have already saved this job.');
        }

        try {
            $savedJob = new SavedJob();
            $savedJob->job_seeker_id = Auth::id();
            $savedJob->job_id = $jobId;
            $savedJob->save();

            return redirect()->back()
                ->with('success', 'Job saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving job: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while saving the job.');
        }
    }

    /**
     * Remove the saved job from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $savedJob = SavedJob::findOrFail($id);

        // Make sure the authenticated user owns this saved job
        if ($savedJob->job_seeker_id !== Auth::id()) {
            return redirect()->route('saved-jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        try {
            $savedJob->delete();
            return redirect()->route('saved-jobs.index')
                ->with('success', 'Job removed from saved jobs.');
        } catch (\Exception $e) {
            Log::error('Error removing saved job: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while removing the saved job.');
        }
    }
} 