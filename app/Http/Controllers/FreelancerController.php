<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Skill;

class FreelancerController extends Controller
{
    /**
     * Display a listing of freelancers.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get freelancers with their profiles and skills
        $query = User::whereHas('roles', function ($q) {
            $q->where('name', 'job_seeker');
        })->with(['profile', 'skills']);
        
        // Filter by skill if provided
        if ($request->has('skill')) {
            $skill = $request->skill;
            $query->whereHas('skills', function ($q) use ($skill) {
                $q->where('name', 'like', "%{$skill}%");
            });
        }
        
        // Filter by category if provided
        if ($request->has('category')) {
            $category = $request->category;
            $query->whereHas('profile', function ($q) use ($category) {
                $q->where('category', 'like', "%{$category}%");
            });
        }
        
        // Sort results
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);
        
        // Paginate results
        $freelancers = $query->paginate(12);
        
        // Get all available skills for filtering
        $skills = Skill::orderBy('name')->get();
        
        // Get all available categories for filtering
        $categories = Profile::distinct()->pluck('category');
        
        return view('freelancers.index', compact('freelancers', 'skills', 'categories'));
    }
    
    /**
     * Display a specific freelancer.
     *
     * @param  string  $username
     * @return \Illuminate\View\View
     */
    public function show($username)
    {
        $freelancer = User::where('username', $username)
            ->whereHas('roles', function ($q) {
                $q->where('name', 'job_seeker');
            })
            ->with(['profile', 'skills', 'education', 'experience', 'portfolioItems', 'reviews'])
            ->firstOrFail();
        
        // Get similar freelancers based on skills
        $similarFreelancers = User::whereHas('roles', function ($q) {
            $q->where('name', 'job_seeker');
        })
        ->whereHas('skills', function ($q) use ($freelancer) {
            $q->whereIn('id', $freelancer->skills->pluck('id'));
        })
        ->where('id', '!=', $freelancer->id)
        ->with(['profile', 'skills'])
        ->take(4)
        ->get();
        
        return view('freelancers.show', compact('freelancer', 'similarFreelancers'));
    }
} 