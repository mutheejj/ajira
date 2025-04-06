@extends('layouts.app')

@section('title', 'Verify Email | Ajira Global')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 shadow-md rounded-lg p-8">
        <div class="text-center mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">Verify Your Email Address</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Before you can start using all features, we need to verify your email address.
            </p>
        </div>
        
        @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900 dark:text-green-200" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        
        @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-900 dark:text-red-200" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif
        
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 dark:text-blue-300">
                        A verification link has been sent to: <strong>{{ auth()->user()->email }}</strong>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <h3 class="text-md font-medium text-gray-900 dark:text-white">Limited Account Access</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Until you verify your email, you'll have limited access to the following features:
                </p>
                <ul class="mt-2 space-y-1 text-sm text-gray-500 dark:text-gray-400">
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Posting new jobs
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Messaging freelancers
                    </li>
                    <li class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        Hiring freelancers
                    </li>
                </ul>
            </div>
            
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Didn't receive the email? Check your spam folder or request a new link.
                </p>
                
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                        </svg>
                        Resend Verification Email
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Need help? Contact our <a href="{{ route('support') }}" class="text-blue-600 dark:text-blue-400 hover:underline">support team</a> for assistance.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 