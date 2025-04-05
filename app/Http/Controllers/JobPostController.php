<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the job posts.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = JobPost::with('client')
            ->where('status', 'active')
            ->latest();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($request->has('category') && $request->get('category') !== 'All Categories') {
            $query->where('category', $request->get('category'));
        }

        // Apply experience level filter
        if ($request->has('experience_level') && $request->get('experience_level') !== 'All Levels') {
            $query->where('experience_level', strtolower($request->get('experience_level')));
        }

        // Apply project type filter
        if ($request->has('project_type') && $request->get('project_type') !== 'All Types') {
            $projectType = str_replace(' ', '_', strtolower($request->get('project_type')));
            $query->where('project_type', $projectType);
        }

        // Apply budget range filter
        if ($request->has('min_budget') && $request->has('max_budget')) {
            $query->whereBetween('budget', [$request->get('min_budget'), $request->get('max_budget')]);
        }

        $jobs = $query->paginate(10);

        // Get list of categories for filter dropdown
        $categories = JobPost::select('category')
            ->where('status', 'active')
            ->distinct()
            ->pluck('category')
            ->toArray();

        return view('jobs.index', compact('jobs', 'categories'));
    }

    /**
     * Show the form for creating a new job post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (!Auth::user()->isClient()) {
            return redirect()->route('jobs.index')
                ->with('error', 'Only clients can create job posts.');
        }

        return view('jobs.create');
    }

    /**
     * Store a newly created job post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isClient()) {
            return redirect()->route('jobs.index')
                ->with('error', 'Only clients can create job posts.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'skills' => 'required|array|min:1',
            'experience_level' => 'required|in:entry,intermediate,expert',
            'project_type' => 'required|in:full_time,part_time,contract,freelance',
            'budget' => 'required|numeric|min:0',
            'currency' => 'required|in:KSH,USD',
            'duration' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'remote_work' => 'boolean',
            'status' => 'required|in:active,draft',
        ]);

        try {
            $jobPost = new JobPost($validated);
            $jobPost->client_id = Auth::id();
            $jobPost->save();

            return redirect()->route('jobs.show', $jobPost)
                ->with('success', 'Job post created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating job post: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while creating the job post.');
        }
    }

    /**
     * Display the specified job post.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\View\View
     */
    public function show(JobPost $jobPost)
    {
        // If the job is not active, only allow the client who created it to view it
        if ($jobPost->status !== 'active' && 
            (!Auth::check() || Auth::id() !== $jobPost->client_id)) {
            abort(404);
        }

        return view('jobs.show', compact('jobPost'));
    }

    /**
     * Show the form for editing the specified job post.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\View\View
     */
    public function edit(JobPost $jobPost)
    {
        if (Auth::id() !== $jobPost->client_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        return view('jobs.edit', compact('jobPost'));
    }

    /**
     * Update the specified job post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, JobPost $jobPost)
    {
        if (Auth::id() !== $jobPost->client_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'skills' => 'required|array|min:1',
            'experience_level' => 'required|in:entry,intermediate,expert',
            'project_type' => 'required|in:full_time,part_time,contract,freelance',
            'budget' => 'required|numeric|min:0',
            'currency' => 'required|in:KSH,USD',
            'duration' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
            'remote_work' => 'boolean',
            'status' => 'required|in:active,closed,draft',
        ]);

        try {
            $jobPost->update($validated);
            return redirect()->route('jobs.show', $jobPost)
                ->with('success', 'Job post updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating job post: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'An error occurred while updating the job post.');
        }
    }

    /**
     * Remove the specified job post from storage.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(JobPost $jobPost)
    {
        if (Auth::id() !== $jobPost->client_id) {
            return redirect()->route('jobs.index')
                ->with('error', 'Unauthorized action.');
        }

        try {
            $jobPost->delete();
            return redirect()->route('jobs.index')
                ->with('success', 'Job post deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting job post: ' . $e->getMessage());
            return back()
                ->with('error', 'An error occurred while deleting the job post.');
        }
    }

    /**
     * Display a listing of the client's job posts.
     *
     * @return \Illuminate\View\View
     */
    public function clientJobs()
    {
        if (!Auth::user()->isClient()) {
            return redirect()->route('jobs.index')
                ->with('error', 'Only clients can access this page.');
        }

        $jobs = JobPost::where('client_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('jobs.client_jobs', compact('jobs'));
    }
} 