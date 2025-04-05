<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
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
     * Show the form for editing the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        
        if ($user->isClient()) {
            return view('profile.client.edit', compact('user'));
        } else {
            return view('profile.job_seeker.edit', compact('user'));
        }
    }

    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Common validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_picture' => ['nullable', 'image', 'max:5120'], // 5MB max
        ];
        
        // Add user type specific validation rules
        if ($user->isClient()) {
            $rules = array_merge($rules, [
                'company_name' => ['required', 'string', 'max:255'],
                'industry' => ['required', 'string', 'max:255'],
                'company_size' => ['required', 'string', 'max:100'],
                'website' => ['nullable', 'url', 'max:255'],
                'description' => ['nullable', 'string'],
            ]);
        } else {
            $rules = array_merge($rules, [
                'profession' => ['nullable', 'string', 'max:255'],
                'experience' => ['nullable', 'string', 'max:255'],
                'skills' => ['nullable', 'array'],
                'skills.*' => ['string', 'max:100'],
                'bio' => ['nullable', 'string'],
                'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB max
                'portfolio' => ['nullable', 'file', 'max:10240'], // 10MB max
                'github_link' => ['nullable', 'url', 'max:255'],
                'linkedin_link' => ['nullable', 'url', 'max:255'],
                'personal_website' => ['nullable', 'url', 'max:255'],
                'portfolio_description' => ['nullable', 'string'],
            ]);
        }
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Update user data
        $userData = $request->only(['name', 'email']);
        
        // Handle password update
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'The current password is incorrect.'])
                    ->withInput();
            }
            
            $userData['password'] = Hash::make($request->new_password);
        }
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $userData['profile_picture'] = $path;
        }
        
        // Handle user type specific updates
        if ($user->isClient()) {
            $userData = array_merge($userData, $request->only([
                'company_name',
                'industry',
                'company_size',
                'website',
                'description',
            ]));
        } else {
            $userData = array_merge($userData, $request->only([
                'profession',
                'experience',
                'bio',
                'github_link',
                'linkedin_link',
                'personal_website',
                'portfolio_description',
            ]));
            
            // Handle skills as JSON
            if ($request->has('skills')) {
                $userData['skills'] = $request->skills;
            }
            
            // Handle resume upload
            if ($request->hasFile('resume')) {
                if ($user->resume) {
                    Storage::disk('public')->delete($user->resume);
                }
                
                $path = $request->file('resume')->store('resumes', 'public');
                $userData['resume'] = $path;
            }
            
            // Handle portfolio upload
            if ($request->hasFile('portfolio')) {
                if ($user->portfolio) {
                    Storage::disk('public')->delete($user->portfolio);
                }
                
                $path = $request->file('portfolio')->store('portfolios', 'public');
                $userData['portfolio'] = $path;
            }
        }
        
        $user->update($userData);
        
        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
} 