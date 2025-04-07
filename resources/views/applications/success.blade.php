@extends('layouts.app')

@section('title', 'Application Submitted Successfully | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="p-8 text-center">
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Application Submitted Successfully!</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Your application for <span class="font-semibold">{{ $jobPost->title }}</span> has been submitted to the client.
                You'll receive notifications when there are updates to your application status.
            </p>
            
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6 text-left">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Application Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Job:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $jobPost->title }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Client:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $jobPost->client->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Your Bid:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $jobPost->currency }} {{ number_format($application->bid_amount, 2) }}
                            @if($jobPost->rate_type === 'hourly')
                            <span class="text-sm font-normal">/hr</span>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Estimated Duration:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $application->estimated_duration }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Submitted On:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $application->created_at->format('M d, Y g:i A') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="space-y-4">
                <p class="text-gray-600 dark:text-gray-400">
                    What's next? The client will review your application and might reach out with questions or a job offer.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4 mt-2">
                    <a href="{{ route('applications.my') }}" 
                        class="inline-flex items-center justify-center px-5 py-2 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        View My Applications
                    </a>
                    <a href="{{ route('jobs.index') }}" 
                        class="inline-flex items-center justify-center px-5 py-2 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Browse More Jobs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 