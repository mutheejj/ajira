<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index()
    {
        $featuredJobs = JobPost::with('client')
            ->where('status', 'active')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('featuredJobs'));
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
            return redirect()->route('job-seeker.dashboard');
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
    public function jobSeekerDashboard()
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