@extends('layouts.app')

@section('title', 'Active Tasks | Ajira Global')

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
                <a href="{{ route('jobseeker.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
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
                <a href="{{ route('jobseeker.tasks') }}" class="flex items-center px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-md font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                    Active Tasks
                </a>
                <a href="{{ route('jobseeker.worklog') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    Work Log
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
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Active Tasks</h1>
                    <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
                        <select class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">All Tasks</option>
                            <option value="in-progress">In Progress</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                
                <!-- Job Applications Section -->
                @if(isset($applications) && $applications->count() > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Job Applications</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-sm">
                                <tr>
                                    <th class="py-3 px-4 text-left font-medium">Job Title</th>
                                    <th class="py-3 px-4 text-left font-medium">Client</th>
                                    <th class="py-3 px-4 text-left font-medium">Status</th>
                                    <th class="py-3 px-4 text-left font-medium">Applied Date</th>
                                    <th class="py-3 px-4 text-left font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($applications as $application)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            @if(is_object($application) && isset($application->job) && isset($application->job->title))
                                                {{ $application->job->title }}
                                            @elseif(is_array($application) && isset($application['job']) && isset($application['job']->title))
                                                {{ $application['job']->title }}
                                            @else
                                                Unknown Job
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            @if(is_object($application) && isset($application->job) && isset($application->job->description))
                                                {{ Str::limit($application->job->description ?? 'No description available', 60) }}
                                            @elseif(is_array($application) && isset($application['job']) && isset($application['job']->description))
                                                {{ Str::limit($application['job']->description ?? 'No description available', 60) }}
                                            @else
                                                No description available
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                    <span class="text-blue-600 dark:text-blue-300 font-medium text-sm">
                                                        @php
                                                            $clientName = null;
                                                            if(is_object($application) && isset($application->job) && isset($application->job->client) && isset($application->job->client->name)) {
                                                                $clientName = $application->job->client->name;
                                                            } elseif(is_array($application) && isset($application['job']) && isset($application['job']->client) && isset($application['job']->client->name)) {
                                                                $clientName = $application['job']->client->name;
                                                            }
                                                        @endphp
                                                        {{ $clientName ? substr($clientName, 0, 1) : '?' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    @if(is_object($application) && isset($application->job) && isset($application->job->client) && isset($application->job->client->name))
                                                        {{ $application->job->client->name }}
                                                    @elseif(is_array($application) && isset($application['job']) && isset($application['job']->client) && isset($application['job']->client->name))
                                                        {{ $application['job']->client->name }}
                                                    @else
                                                        Unknown Client
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        @php
                                            $status = is_object($application) ? ($application->status ?? null) : ($application['status'] ?? null);
                                        @endphp
                                        @if($status)
                                            @if($status === 'pending')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                            @elseif($status === 'reviewing')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Reviewing</span>
                                            @elseif($status === 'interviewed')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Interviewed</span>
                                            @elseif($status === 'accepted')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Accepted</span>
                                            @elseif($status === 'rejected')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Rejected</span>
                                            @elseif($status === 'withdrawn')
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Withdrawn</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">{{ ucfirst($status) }}</span>
                                            @endif
                                        @else
                                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-600 dark:text-gray-300">
                                        @php
                                            $created = null;
                                            if(is_object($application) && isset($application->created_at)) {
                                                $created = $application->created_at;
                                            } elseif(is_array($application) && isset($application['created_at'])) {
                                                $created = $application['created_at'];
                                            } elseif(is_object($application) && isset($application->applied_date)) {
                                                $created = $application->applied_date;
                                            } elseif(is_array($application) && isset($application['applied_date'])) {
                                                $created = $application['applied_date'];
                                            }
                                        @endphp
                                        @if($created)
                                            {{ \Carbon\Carbon::parse($created)->format('M d, Y') }}
                                        @else
                                            Unknown date
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex space-x-2">
                                            @php
                                                $jobId = null;
                                                if(is_object($application) && isset($application->job) && isset($application->job->id)) {
                                                    $jobId = $application->job->id;
                                                } elseif(is_array($application) && isset($application['job']) && isset($application['job']->id)) {
                                                    $jobId = $application['job']->id;
                                                } elseif(is_object($application) && isset($application->job_id)) {
                                                    $jobId = $application->job_id;
                                                } elseif(is_array($application) && isset($application['job_id'])) {
                                                    $jobId = $application['job_id'];
                                                }
                                                
                                                $applicationId = null;
                                                if(is_object($application) && isset($application->id)) {
                                                    $applicationId = $application->id;
                                                } elseif(is_array($application) && isset($application['id'])) {
                                                    $applicationId = $application['id'];
                                                }
                                                
                                                $applicationStatus = null;
                                                if(is_object($application) && isset($application->status)) {
                                                    $applicationStatus = $application->status;
                                                } elseif(is_array($application) && isset($application['status'])) {
                                                    $applicationStatus = $application['status'];
                                                }
                                            @endphp
                                            
                                            @if($jobId)
                                                <a href="{{ route('jobs.show', $jobId) }}" class="text-blue-600 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800 px-3 py-1 rounded-md text-sm font-medium">
                                                    View Job
                                                </a>
                                            @endif
                                            
                                            @if($applicationId && $applicationStatus === 'pending')
                                                <form action="{{ route('applications.withdraw', $applicationId) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-red-600 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:text-red-200 dark:hover:bg-red-800 px-3 py-1 rounded-md text-sm font-medium">Withdraw</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                
                <!-- Tasks Section -->
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Current Tasks</h2>
                @if(($tasks ?? collect())->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-sm">
                            <tr>
                                <th class="py-3 px-4 text-left font-medium">Task</th>
                                <th class="py-3 px-4 text-left font-medium">Client</th>
                                <th class="py-3 px-4 text-left font-medium">Status</th>
                                <th class="py-3 px-4 text-left font-medium">Due Date</th>
                                <th class="py-3 px-4 text-left font-medium">Progress</th>
                                <th class="py-3 px-4 text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($tasks as $task)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $task['title'] }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($task['description'] ?? 'No description available', 60) }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            @if(isset($task['client_photo']))
                                                <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . $task['client_photo']) }}" alt="{{ $task['client'] }}">
                                            @else
                                                <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                    <span class="text-blue-600 dark:text-blue-300 font-medium text-sm">{{ substr($task['client'], 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $task['client'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    @if($task['status'] === 'in-progress')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">In Progress</span>
                                    @elseif($task['status'] === 'pending')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                    @elseif($task['status'] === 'completed')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Completed</span>
                                    @elseif($task['status'] === 'overdue')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Overdue</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-300">
                                    <div>{{ \Carbon\Carbon::parse($task['due_date'])->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        @php
                                            $daysRemaining = \Carbon\Carbon::parse($task['due_date'])->diffInDays(now());
                                            $isPast = \Carbon\Carbon::parse($task['due_date'])->isPast();
                                        @endphp
                                        
                                        @if($isPast)
                                            <span class="text-red-500 dark:text-red-400">Overdue by {{ $daysRemaining }} days</span>
                                        @else
                                            {{ $daysRemaining }} days remaining
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $task['progress'] }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $task['progress'] }}% complete</div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        @if(is_string($task['id']) && strpos($task['id'], 'pending_') === 0)
                                            <span class="text-gray-600 dark:text-gray-400 text-sm italic">
                                                Tasks will be assigned soon
                                            </span>
                                        @else
                                            <a href="{{ route('jobseeker.workspace', $task['id']) }}" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-sm font-medium">
                                                Work on Task
                                            </a>
                                            <a href="{{ route('messages.task', $task['id']) }}" class="text-blue-600 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:text-blue-200 dark:hover:bg-blue-800 px-3 py-1 rounded-md text-sm font-medium">
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                                    </svg>
                                                    Messages
                                                </span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No Tasks Found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">You don't have any active tasks at the moment. Tasks appear here once your job applications are accepted and tasks are assigned to you.</p>
                </div>
                @endif
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Task Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Task Summary</h2>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">Total Tasks</h3>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ ($tasks ?? collect())->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">In Progress</h3>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ ($tasks ?? collect())->where('status', 'in-progress')->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">Completed</h3>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ ($tasks ?? collect())->where('status', 'completed')->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Upcoming Deadlines</h3>
                    <div class="space-y-3">
                        @php
                            $upcomingTasks = isset($tasks) ? collect($tasks)->filter(function($task) {
                                return \Carbon\Carbon::parse($task['due_date'])->diffInDays(now()) <= 7 && !(\Carbon\Carbon::parse($task['due_date'])->isPast());
                            })->sortBy(function($task) {
                                return \Carbon\Carbon::parse($task['due_date']);
                            })->take(3) : collect([]);
                        @endphp
                        
                        @forelse($upcomingTasks as $task)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $task['title'] }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $task['client'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Due: {{ \Carbon\Carbon::parse($task['due_date'])->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        @php
                                            $daysRemaining = \Carbon\Carbon::parse($task['due_date'])->diffInDays(now());
                                        @endphp
                                        {{ $daysRemaining }} days remaining
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No upcoming deadlines in the next 7 days.</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Recent Messages -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Recent Messages</h2>
                    
                    @if(isset($recentMessages) && count($recentMessages) > 0)
                    <div class="space-y-4">
                        @foreach($recentMessages as $message)
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if(isset($message['sender_photo']))
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $message['sender_photo']) }}" alt="{{ $message['sender'] }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                <span class="text-blue-600 dark:text-blue-300 font-medium text-lg">{{ substr($message['sender'], 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $message['sender'] }}</h4>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $message['job_title'] }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($message['timestamp'])->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                {{ Str::limit($message['content'], 100) }}
                            </p>
                            <div class="mt-2">
                                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View Conversation</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">View All Messages</a>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">No messages yet</p>
                        <p class="text-gray-500 dark:text-gray-500">Messages from clients will appear here.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 