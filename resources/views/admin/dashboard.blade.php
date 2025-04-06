@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Users Stats -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</p>
                        <div class="mt-1 flex items-baseline text-sm text-gray-500 dark:text-gray-400">
                            <span class="mr-2">{{ $stats['total_clients'] }} Clients</span>
                            <span>{{ $stats['total_job_seekers'] }} Job Seekers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Jobs Stats -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Jobs</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_jobs'] }}</p>
                        <div class="mt-1 flex items-baseline text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $stats['active_jobs'] }} Active Jobs</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Applications Stats -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Applications</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_applications'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Users</h3>
                <a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View All</a>
            </div>
            <div class="px-6 py-4 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recent_users as $user)
                <div class="py-3 flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($user->user_type == 'admin') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                            @elseif($user->user_type == 'client') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @endif">
                            {{ ucfirst($user->user_type) }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="py-3 text-center text-gray-500 dark:text-gray-400">
                    No recent users found.
                </div>
                @endforelse
            </div>
        </div>
        
        <!-- Recent Jobs -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent Jobs</h3>
                <a href="{{ route('admin.jobs') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View All</a>
            </div>
            <div class="px-6 py-4 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recent_jobs as $job)
                <div class="py-3">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $job->title }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                by {{ $job->user->name }}
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($job->status == 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($job->status == 'closed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @elseif($job->status == 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                {{ ucfirst($job->status) }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $job->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="mt-2 flex justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $job->category->name ?? 'Uncategorized' }} • ${{ $job->budget }}
                        </div>
                        <a href="{{ route('admin.jobs.show', $job->id) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">View</a>
                    </div>
                </div>
                @empty
                <div class="py-3 text-center text-gray-500 dark:text-gray-400">
                    No recent jobs found.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection 