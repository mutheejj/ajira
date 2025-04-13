@extends('layouts.app')

@section('title', 'Job Seeker Dashboard | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Job Seeker</p>
                </div>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('jobseeker.dashboard') }}" class="flex items-center px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-md font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('applications.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0019.414 6L15 1.586A2 2 0 0013.586 1H10a2 2 0 00-2 2zm7 2l3 3v1h-4V4h1zm-2 12H5V4h5v3a2 2 0 002 2h3v7z" clip-rule="evenodd" />
                    </svg>
                    My Applications
                </a>
                <a href="{{ route('saved-jobs.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                    </svg>
                    Saved Jobs
                </a>
                <a href="{{ route('jobs.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Find Jobs
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                    </svg>
                    Profile Settings
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Welcome Back, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Browse job opportunities and connect with potential employers from around the world.
                </p>
                
                <div class="mt-2">
                    <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        Find Jobs
                    </a>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6M5 5h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Applications</h2>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $applicationStats['total'] }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $applicationStats['in_progress'] }} in progress</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Active Tasks</h2>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $tasks->count() }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $tasks->where('status', 'in-progress')->count() }} in progress</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Earnings</h2>
                            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($earnings['total'], 2) }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">${{ number_format($earnings['pending'], 2) }} pending</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Recent Activity</h2>
                
                @if($workLogs->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No recent activity</p>
                @else
                    <div class="space-y-4">
                        @foreach($workLogs as $log)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="p-2 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $log->task->title }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        @if(isset($log->task) && isset($log->task->contract) && isset($log->task->contract->job) && isset($log->task->contract->job->client))
                                            {{ $log->task->contract->job->client->name }}
                                        @else
                                            Unknown Client
                                        @endif
                                        • {{ $log->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            
            <!-- Active Tasks -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Active Tasks</h2>
                
                @if($tasks->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No active tasks</p>
                @else
                    <div class="space-y-4">
                        @foreach($tasks->take(5) as $task)
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $task['title'] }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $task['client'] }}</p>
                                </div>
                                <div class="flex items-center">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($task['status'] === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($task['status'] === 'in-progress') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 @endif">
                                        {{ ucfirst($task['status']) }}
                                    </span>
                                    <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                        Due {{ \Carbon\Carbon::parse($task['due_date'])->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($tasks->count() > 5)
                        <div class="mt-4">
                            <a href="{{ route('jobseeker.tasks') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500">
                                View all tasks →
                            </a>
                        </div>
                    @endif
                @endif
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Applications</h2>
                    
                    <div class="space-y-4">
                        @forelse($recentApplications as $application)
                            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-medium text-gray-900 dark:text-white">
                                            <a href="{{ route('jobs.show', $application->jobPost->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $application->jobPost->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $application->jobPost->client->name ?? 'Unknown Client' }}
                                        </p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($application->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($application->status === 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($application->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                        @elseif($application->status === 'withdrawn') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @else bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 @endif">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Applied {{ $application->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No recent applications found.</p>
                        @endforelse
                    </div>
                    
                    <div class="mt-4 text-right">
                        <a href="{{ route('applications.my') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            View all applications →
                        </a>
                    </div>
                </div>
                
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recommended Jobs</h2>
                    
                    <div class="space-y-4">
                        @forelse($recommendedJobs as $job)
                            <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <h3 class="font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('jobs.show', $job->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ $job->title }}
                                    </a>
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $job->client->name ?? 'Unknown Client' }}
                                </p>
                                <div class="flex items-center mt-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $job->location_type == 'remote' ? 'Remote' : $job->location ?? 'Not specified' }}
                                    </span>
                                    <span class="mx-2 text-gray-400 dark:text-gray-500">•</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-300 font-medium">
                                        {{ $job->currency }} {{ number_format($job->budget, 0) }}
                                        @if($job->rate_type == 'hourly') /hr @endif
                                    </span>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('jobs.show', $job->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        View Job →
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No recommended jobs found right now.</p>
                        @endforelse
                    </div>
                    
                    <div class="mt-4 text-right">
                        <a href="{{ route('jobs.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                            Find more jobs →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 