@extends('layouts.app')

@section('title', 'Saved Jobs | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-64 shrink-0">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 sticky top-20">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Job Seeker Menu</h2>
                
                <nav class="space-y-1">
                    <a href="{{ route('jobseeker.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('jobs.index') }}" class="flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Find Jobs
                    </a>
                    
                    <a href="{{ route('applications.my') }}" class="flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        My Applications
                    </a>
                    
                    <a href="{{ route('saved-jobs.index') }}" class="flex items-center px-3 py-2 rounded-md bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        Saved Jobs
                    </a>
                    
                    <a href="{{ route('jobseeker.tasks') }}" class="flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        Active Tasks
                    </a>
                    
                    <a href="{{ route('jobseeker.worklog') }}" class="flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Work Log
                    </a>
                    
                    <a href="{{ route('wallet.index') }}" class="flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Wallet
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Saved Jobs</h1>
                    
                    <div class="flex items-center mt-2 md:mt-0">
                        <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Browse More Jobs
                        </a>
                    </div>
                </div>
                
                <!-- Results count -->
                <p class="text-gray-600 dark:text-gray-400">
                    You have {{ $savedJobs->total() }} saved jobs
                </p>
                
                <!-- Saved Jobs List -->
                @if($savedJobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($savedJobs as $savedJob)
                            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('jobs.show', $savedJob->job) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                                    {{ $savedJob->job->title }}
                                                </a>
                                            </h3>
                                            <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <span>{{ $savedJob->job->client->name }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{ $savedJob->job->category }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{ ucfirst($savedJob->job->location_type) }}</span>
                                                @if($savedJob->job->location && $savedJob->job->location_type !== 'remote')
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $savedJob->job->location }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-block font-medium text-blue-600 dark:text-blue-400">
                                                {{ $savedJob->job->currency }} {{ number_format($savedJob->job->budget) }}
                                            </span>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ ucfirst($savedJob->job->rate_type) }} Rate
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit($savedJob->job->description, 200) }}
                                        </p>
                                    </div>
                                    
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach(json_decode($savedJob->job->skills) as $skill)
                                            <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs px-2 py-1 rounded-full">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between items-center">
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Saved {{ $savedJob->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <a href="{{ route('applications.create', $savedJob->job->id) }}" class="inline-flex items-center px-3 py-1 border border-blue-700 text-sm leading-5 font-medium rounded-md text-blue-700 dark:text-blue-400 bg-white dark:bg-gray-700 hover:text-white hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                                Apply Now
                                            </a>
                                            
                                            <form action="{{ route('saved-jobs.destroy', $savedJob->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 text-sm leading-5 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:text-red-500 hover:border-red-300 dark:hover:border-red-700 dark:hover:text-red-400 focus:outline-none focus:border-red-300 focus:shadow-outline-red active:bg-gray-50 transition ease-in-out duration-150">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Remove
                                                </button>
                                            </form>
                                            
                                            <a href="{{ route('jobs.show', $savedJob->job) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 text-sm leading-5 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 transition ease-in-out duration-150">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $savedJobs->links() }}
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-10 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No saved jobs found</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">You haven't saved any jobs yet. Browse jobs and save the ones you're interested in.</p>
                        <div class="mt-6">
                            <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Browse Jobs
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 