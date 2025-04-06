<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
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
        // Check if user is authenticated and has client role
        if (Auth::check() && Auth::user()->user_type === 'client') {
            return $next($request);
        }

        // If request expects JSON response
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized. Client access required.'], 403);
        }

        // Redirect to home with error message
        return redirect()->route('home')->with('error', 'You do not have client privileges to access this page.');
    }
} 