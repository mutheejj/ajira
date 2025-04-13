<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class JobSeekerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Please login first.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }

        $user = Auth::user();
        
        if (!$user->isJobSeeker()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized. This endpoint is for job seekers only.',
                    'user_type' => $user->user_type,
                    'is_job_seeker' => $user->isJobSeeker(),
                ], 403);
            }

            return redirect()->route('home')->with('error', 'You do not have permission to access this page. This section is for job seekers only. Your user type is: ' . $user->user_type);
        }

        return $next($request);
    }
} 