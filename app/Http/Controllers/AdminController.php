<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JobPost;
use App\Models\JobApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get counts for dashboard statistics
        $stats = [
            'total_users' => User::count(),
            'total_clients' => User::where('user_type', 'client')->count(),
            'total_job_seekers' => User::where('user_type', 'job-seeker')->count(),
            'total_jobs' => JobPost::count(),
            'active_jobs' => JobPost::where('status', 'active')->count(),
            'total_applications' => JobApplication::count(),
        ];
        
        // Recent users
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        
        // Recent jobs
        $recentJobs = JobPost::with('client')->orderBy('created_at', 'desc')->take(5)->get();
        
        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentJobs'));
    }
    
    /**
     * Show list of all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        $query = User::query();
        
        // Filter by user type
        if ($request->has('user_type') && $request->user_type != 'all') {
            $query->where('user_type', $request->user_type);
        }
        
        // Filter by verification status
        if ($request->has('verified')) {
            if ($request->verified == '1') {
                $query->whereNotNull('email_verified_at');
            } else if ($request->verified == '0') {
                $query->whereNull('email_verified_at');
            }
        }
        
        // Search by name or email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show form to create a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUser()
    {
        return view('admin.users.create');
    }
    
    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUser(Request $request)
    {
        // Validate user data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => 'required|in:admin,client,job-seeker',
        ]);
        
        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
            'email_verified_at' => $request->has('verified') ? now() : null,
        ]);
        
        return redirect()->route('admin.users')
            ->with('success', 'User created successfully.');
    }
    
    /**
     * Show user details and edit form.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        
        return view('admin.users.edit', compact('user'));
    }
    
    /**
     * Update user details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validate user data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'user_type' => 'required|in:admin,client,job-seeker',
        ]);
        
        // Update user
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->user_type = $validated['user_type'];
        
        // Update verification status if changed
        if ($request->has('verified')) {
            $user->email_verified_at = $request->verified ? now() : null;
        }
        
        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully.');
    }
    
    /**
     * Delete a user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully.');
    }
    
    /**
     * Show list of all jobs.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobs(Request $request)
    {
        $query = JobPost::with('client');
        
        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        // Search by title or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $jobs = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get categories for filter
        $categories = JobPost::distinct('category')->pluck('category');
        
        // Get stats for display
        $stats = [
            'total_jobs' => JobPost::count(),
            'active_jobs' => JobPost::where('status', 'active')->count(),
            'total_applications' => \App\Models\Application::count(),
        ];
        
        return view('admin.jobs.index', compact('jobs', 'categories', 'stats'));
    }
    
    /**
     * Show job details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showJob($id)
    {
        $job = JobPost::with(['client', 'applications.user'])->findOrFail($id);
        
        return view('admin.jobs.show', compact('job'));
    }
    
    /**
     * Update job status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateJobStatus(Request $request, $id)
    {
        $job = JobPost::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:active,closed,draft',
        ]);
        
        $job->status = $request->status;
        $job->save();
        
        return redirect()->route('admin.jobs.show', $job->id)
            ->with('success', 'Job status updated successfully.');
    }
    
    /**
     * Delete a job.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteJob($id)
    {
        $job = JobPost::findOrFail($id);
        $job->delete();
        
        return redirect()->route('admin.jobs')
            ->with('success', 'Job deleted successfully.');
    }
    
    /**
     * Show system settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        // Get mail configuration
        $mailConfig = [
            'MAIL_MAILER' => config('mail.default'),
            'MAIL_HOST' => config('mail.mailers.smtp.host'),
            'MAIL_PORT' => config('mail.mailers.smtp.port'),
            'MAIL_USERNAME' => config('mail.mailers.smtp.username'),
            'MAIL_ENCRYPTION' => config('mail.mailers.smtp.encryption'),
            'MAIL_FROM_ADDRESS' => config('mail.from.address'),
            'MAIL_FROM_NAME' => config('mail.from.name'),
        ];
        
        return view('admin.settings', compact('mailConfig'));
    }
    
    /**
     * Update system settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSettings(Request $request)
    {
        // This would normally update .env file or settings table
        // For demo purposes, we'll just return success message
        
        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }
}
