@extends('layouts.app')

@section('title', 'Client Dashboard | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Welcome back, {{ $user->name }}</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Active Jobs -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-500 dark:text-blue-300 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Active Jobs</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active_jobs'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        of {{ $stats['total_jobs'] }} total
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Pending Applications -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-500 dark:text-yellow-300 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Pending Applications</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_applications'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Review applications</a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Active Contracts -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-500 dark:text-green-300 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Active Contracts</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['active_contracts'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Manage contracts</a>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Conversion Rate -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-500 dark:text-purple-300 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Conversion Rate</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['conversion_rate'] }}%</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Applications to hires
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Post a Job -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-bold mb-2">Post a New Job</h3>
            <p class="text-blue-100 mb-4">Create a new job posting to find the perfect freelancer for your project.</p>
            <a href="{{ route('client.create-job') }}" class="inline-block bg-white text-blue-600 font-medium px-4 py-2 rounded-md hover:bg-blue-50 transition-colors">
                Post a Job
            </a>
        </div>
        
        <!-- Browse Talent -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-bold mb-2">Browse Talent</h3>
            <p class="text-purple-100 mb-4">Discover top-rated freelancers based on skills, ratings, and experience.</p>
            <a href="#" class="inline-block bg-white text-purple-600 font-medium px-4 py-2 rounded-md hover:bg-purple-50 transition-colors">
                Find Talent
            </a>
        </div>
        
        <!-- Manage Jobs -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-bold mb-2">Manage Your Jobs</h3>
            <p class="text-green-100 mb-4">View, edit, and track your active job postings and applications.</p>
            <a href="{{ route('client.jobs') }}" class="inline-block bg-white text-green-600 font-medium px-4 py-2 rounded-md hover:bg-green-50 transition-colors">
                Manage Jobs
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Applications -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Applications</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Applicant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Job
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Bid
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentApplications as $application)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($application->user->profile_photo)
                                                <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $application->user->profile_photo) }}" alt="{{ $application->user->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                    <span class="text-blue-600 dark:text-blue-300 font-medium text-lg">{{ substr($application->user->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $application->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $application->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ Str::limit($application->jobPost->title, 30) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $application->jobPost->currency }} {{ number_format($application->bid_amount, 2) }}
                                        @if($application->jobPost->rate_type === 'hourly')
                                        <span class="text-xs text-gray-500 dark:text-gray-400">/hr</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($application->status === 'pending')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Pending
                                        </span>
                                    @elseif($application->status === 'accepted')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Accepted
                                        </span>
                                    @elseif($application->status === 'rejected')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('applications.show', $application->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No applications received yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                        View all applications →
                    </a>
                </div>
            </div>
            
            <!-- Recent Jobs -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Your Recent Jobs</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Job Title
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Budget
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Posted
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Applications
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($jobPosts as $job)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($job->title, 40) }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($job->job_type) }} · {{ ucfirst($job->location_type) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $job->currency }} {{ number_format($job->budget, 2) }}
                                        @if($job->rate_type === 'hourly')
                                        <span class="text-xs text-gray-500 dark:text-gray-400">/hr</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $job->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $job->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $applicationCount = App\Models\Application::where('job_post_id', $job->id)->count();
                                    @endphp
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $applicationCount }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('jobs.show', $job->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3">View</a>
                                    <a href="{{ route('applications.list', $job->id) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300">Applications</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No jobs posted yet. <a href="{{ route('client.create-job') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Post your first job</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                    <a href="{{ route('client.jobs') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                        View all jobs →
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Spending Analytics -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Spending Analytics</h2>
                </div>
                <div class="p-6">
                    @if(count($stats['monthly_spending']) > 0)
                        <canvas id="spendingChart" height="250"></canvas>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">No spending data available yet.</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                Data will appear once you've hired freelancers.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Top Freelancers -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Top Freelancers</h2>
                </div>
                <div class="p-6">
                    @forelse($topFreelancers as $freelancer)
                    <div class="flex items-center py-3 {{ !$loop->last ? 'border-b border-gray-200 dark:border-gray-700' : '' }}">
                        <div class="flex-shrink-0 h-10 w-10">
                            @if($freelancer->profile_photo)
                                <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $freelancer->profile_photo) }}" alt="{{ $freelancer->name }}">
                            @else
                                <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                    <span class="text-blue-600 dark:text-blue-300 font-medium text-lg">{{ substr($freelancer->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="ml-4 flex-1">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $freelancer->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $freelancer->profession ?? 'Freelancer' }}
                            </div>
                        </div>
                        <div class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                            {{ $freelancer->applications_count }} application{{ $freelancer->applications_count != 1 ? 's' : '' }}
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">No freelancers have applied yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Feature Highlight -->
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-bold mb-2">Upgrade to Pro</h3>
                <p class="text-indigo-100 mb-4">Get access to premium features and enhance your hiring experience.</p>
                <ul class="text-indigo-100 mb-4 space-y-2">
                    <li class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Unlimited job postings
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Featured job listings
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Advanced freelancer matching
                    </li>
                </ul>
                <a href="{{ route('client.billing') }}" class="inline-block bg-white text-indigo-600 font-medium px-4 py-2 rounded-md hover:bg-indigo-50 transition-colors">
                    View Plans
                </a>
            </div>
        </div>
    </div>
</div>

@if(count($stats['monthly_spending']) > 0)
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Spending Chart
    const spendingCtx = document.getElementById('spendingChart').getContext('2d');
    const spendingChart = new Chart(spendingCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(@json($stats['monthly_spending'])),
            datasets: [{
                label: 'Monthly Spending',
                data: Object.values(@json($stats['monthly_spending'])),
                backgroundColor: 'rgba(79, 70, 229, 0.8)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(160, 174, 192, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
@endif

@endsection 