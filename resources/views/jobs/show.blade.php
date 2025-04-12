@extends('layouts.app')

@section('title', $jobPost->title . ' | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Success/Error Messages -->
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
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="md:col-span-2">
                <!-- Job Header -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $jobPost->title }}</h1>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $jobPost->location_type }}
                                        @if($jobPost->location)
                                        - {{ $jobPost->location }}
                                        @endif
                                    </span>
                                    <span class="inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        Posted {{ $jobPost->created_at->diffForHumans() }}
                                    </span>
                                    <span class="inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z" />
                                        </svg>
                                        {{ ucfirst($jobPost->experience_level) }} level
                                    </span>
                                    <span class="inline-flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                        </svg>
                                        {{ ucfirst($jobPost->job_type) }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <span class="inline-block text-xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ $jobPost->currency }} {{ number_format($jobPost->budget, 2) }}
                                    @if($jobPost->rate_type === 'hourly')
                                    <span class="text-sm font-normal">/hr</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-2 my-4">
                            @foreach(json_decode($jobPost->skills) as $skill)
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs rounded-full">
                                {{ $skill }}
                            </span>
                            @endforeach
                        </div>
                        
                        <div class="flex justify-between items-center mt-6">
                            <!-- Apply Button - Always Visible -->
                            <a href="{{ route('applications.create', $jobPost->id) }}" 
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Apply Now
                            </a>
                            
                            <!-- Save Job / Share Buttons -->
                            <div class="flex space-x-2">
                                @auth
                                    @if(Auth::user()->user_type === 'job_seeker')
                                        <button id="save-job-btn" data-job-id="{{ $jobPost->id }}" 
                                            class="p-2 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                                            </svg>
                                        </button>
                                    @endif
                                @endauth
                                
                                <button id="share-job-btn" 
                                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Job Description -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Job Description</h2>
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $jobPost->description }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Skills Required -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Skills Required</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach(json_decode($jobPost->skills) as $skill)
                            <span class="px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm font-medium rounded-full">
                                {{ $skill }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Job Activity -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Job Activity</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Applications</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $jobPost->applications_count ?? '0' }}
                                </p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-1">Views</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-white">
                                    {{ $jobPost->views_count ?? '0' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div>
                <!-- Client Information -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">About the Client</h2>
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 h-12 w-12 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $jobPost->client->company_name ?? $jobPost->client->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $jobPost->client->industry ?? 'Employer' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">
                                    Payment verified
                                </span>
                            </div>
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">
                                    Member since {{ $jobPost->client->created_at->format('M Y') }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">
                                    {{ $jobPost->client->country ?? 'Location not specified' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Similar Jobs -->
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Similar Jobs</h2>
                        
                        @if(isset($similarJobs) && count($similarJobs) > 0)
                            <div class="space-y-4">
                                @foreach($similarJobs as $similarJob)
                                <a href="{{ route('jobs.show', $similarJob->id) }}" class="block p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <h3 class="font-medium text-gray-900 dark:text-white mb-1">{{ Str::limit($similarJob->title, 50) }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        {{ ucfirst($similarJob->job_type) }} · {{ $similarJob->currency }} {{ number_format($similarJob->budget, 2) }}{{ $similarJob->rate_type === 'hourly' ? '/hr' : '' }}
                                    </p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice(json_decode($similarJob->skills), 0, 3) as $skill)
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs rounded-full">
                                            {{ $skill }}
                                        </span>
                                        @endforeach
                                        @if(count(json_decode($similarJob->skills)) > 3)
                                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs rounded-full">
                                            +{{ count(json_decode($similarJob->skills)) - 3 }} more
                                        </span>
                                        @endif
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">No similar jobs found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Save Job to favorites functionality
        const saveJobBtn = document.getElementById('save-job-btn');
        if (saveJobBtn) {
            saveJobBtn.addEventListener('click', function() {
                const jobId = this.getAttribute('data-job-id');
                
                // Send AJAX request to save job
                fetch(`/jobs/${jobId}/save`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Toggle saved state
                        this.classList.toggle('text-blue-600');
                        this.classList.toggle('dark:text-blue-400');
                        
                        // Show toast notification
                        alert(data.message);
                    } else {
                        alert(data.message || 'Error saving job.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving the job.');
                });
            });
        }
        
        // Share Job functionality
        const shareJobBtn = document.getElementById('share-job-btn');
        if (shareJobBtn) {
            shareJobBtn.addEventListener('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: '{{ $jobPost->title }}',
                        text: 'Check out this job on Ajira Global',
                        url: window.location.href
                    })
                    .catch(error => console.error('Error sharing:', error));
                } else {
                    // Fallback - copy to clipboard
                    const tempInput = document.createElement('input');
                    tempInput.value = window.location.href;
                    document.body.appendChild(tempInput);
                    tempInput.select();
                    document.execCommand('copy');
                    document.body.removeChild(tempInput);
                    
                    alert('Link copied to clipboard!');
                }
            });
        }
    });
</script>
@endsection 