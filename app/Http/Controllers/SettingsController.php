<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
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
     * Display the user settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('settings.index', compact('user'));
    }
    
    /**
     * Update the user's settings.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
            'notifications' => 'array',
            'theme_preference' => 'string|in:light,dark,system',
        ]);
        
        // Check current password if user is trying to change password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password is incorrect.',
                ]);
            }
        }
        
        // Update basic information
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        // Update notification preferences
        $user->notification_preferences = $request->notifications ?? [];
        
        // Update theme preference
        $user->theme_preference = $request->theme_preference;
        
        $user->save();
        
        return back()->with('success', 'Settings updated successfully!');
    }
} 