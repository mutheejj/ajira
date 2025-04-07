@extends('layouts.app')

@section('title', 'Application Details | Ajira Global')

@section('styles')
<style>
    /* Custom styling for status timeline */
    .status-timeline {
        position: relative;
    }
    .status-timeline::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 15px;
        height: calc(100% - 40px);
        width: 2px;
        background-color: #e5e7eb;
    }
    .dark .status-timeline::before {
        background-color: #4b5563;
    }
    .status-step {
        position: relative;
        z-index: 1;
    }
    .status-step.active .status-icon {
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }
    .status-step.completed .status-icon {
        background-color: #10b981;
        border-color: #10b981;
        color: white;
    }
    .status-step.rejected .status-icon {
        background-color: #ef4444;
        border-color: #ef4444;
        color: white;
    }
    .status-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dark .status-icon {
        background-color: #1f2937;
        border-color: #4b5563;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <a href="{{ Auth::user()->id === $application->user_id ? route('applications.my') : route('applications.list', $application->job_post_id) }}" 
                class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to {{ Auth::user()->id === $application->user_id ? 'My Applications' : 'Applications' }}
            </a>
        </div>
        
        <!-- Application Header -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
            <div class="border-b border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $application->jobPost->title }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mb-1 text-sm">
                            <span class="font-medium">Applied:</span> {{ $application->created_at->format('M d, Y g:i A') }} ({{ $application->created_at->diffForHumans() }})
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 mb-1 text-sm flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="font-medium">Budget:</span> {{ $application->jobPost->currency }} {{ number_format($application->jobPost->budget, 2) }} 
                            @if($application->jobPost->rate_type === 'hourly')
                            /hr
                            @endif
                        </p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $application->getStatusBadgeClass() }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 md:mt-0 bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg">
                        <h3 class="text-gray-700 dark:text-gray-300 text-sm mb-1">Your Proposal</h3>
                        <div class="text-lg font-bold text-blue-600 dark:text-blue-400">
                            {{ $application->jobPost->currency }} {{ number_format($application->bid_amount, 2) }}
                            @if($application->jobPost->rate_type === 'hourly')
                            <span class="text-sm font-normal">/hr</span>
                            @endif
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ $application->estimated_duration }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Application Status Timeline -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Application Status</h2>
                <div class="status-timeline pl-10">
                    <div class="status-step completed mb-6">
                        <div class="status-icon absolute -left-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">Application Submitted</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $application->created_at->format('F j, Y g:i A') }}</p>
                    </div>
                    
                    <div class="status-step {{ in_array($application->status, ['accepted', 'rejected']) ? ($application->status === 'accepted' ? 'completed' : 'rejected') : 'active' }} mb-6">
                        <div class="status-icon absolute -left-10">
                            @if($application->status === 'accepted')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            @elseif($application->status === 'rejected')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            @elseif($application->status === 'withdrawn')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            @endif
                        </div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">
                            @if($application->status === 'accepted')
                            Application Accepted
                            @elseif($application->status === 'rejected')
                            Application Rejected
                            @elseif($application->status === 'withdrawn')
                            Application Withdrawn
                            @else
                            Under Review
                            @endif
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            @if($application->status !== 'pending')
                            {{ $application->updated_at->format('F j, Y g:i A') }}
                            @else
                            Client is reviewing your application
                            @endif
                        </p>
                    </div>
                    
                    @if($application->status === 'accepted')
                    <div class="status-step active">
                        <div class="status-icon absolute -left-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-medium text-gray-900 dark:text-white">Project Kickoff</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ready to start working</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Application Details -->
            <div class="p-6 space-y-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Cover Letter</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $application->cover_letter }}</p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Application Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Estimated Duration</p>
                            <p class="text-gray-900 dark:text-white mt-1">{{ $application->estimated_duration }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Application ID</p>
                            <p class="text-gray-900 dark:text-white mt-1">#{{ $application->id }}</p>
                        </div>
                        
                        @if($application->attachment)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Attachments</h2>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 flex items-center">
                                <div class="bg-blue-100 dark:bg-blue-900 rounded-lg p-3 mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Attachment</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ str_replace('application_attachments/', '', $application->attachment) }}</p>
                                </div>
                                <a href="{{ route('applications.download', $application->id) }}" 
                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        @if($application->feedback)
                        <div class="md:col-span-2 border-t border-gray-200 dark:border-gray-700 pt-4 mt-2">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Client Feedback</p>
                            <p class="text-gray-900 dark:text-white mt-1 whitespace-pre-line">{{ $application->feedback }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Applicant Information (visible to client only) -->
                @if(Auth::id() === $application->jobPost->client_id || Auth::user()->user_type === 'admin')
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Applicant Information</h2>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="{{ asset('images/avatar.png') }}" alt="{{ $application->user->name }}">
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $application->user->name }}
                            </div>
                            <div class="text-gray-600 dark:text-gray-400">
                                {{ $application->user->email }}
                            </div>
                            <div class="text-gray-600 dark:text-gray-400 mt-1">
                                {{ $application->user->profession ?? 'Freelancer' }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Client Information (visible to applicant only) -->
                @if(Auth::id() === $application->user_id)
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Client Information</h2>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <img class="h-12 w-12 rounded-full" src="{{ asset('images/company.png') }}" alt="{{ $application->jobPost->client->name }}">
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $application->jobPost->client->company_name ?? $application->jobPost->client->name }}
                            </div>
                            <div class="text-gray-600 dark:text-gray-400">
                                {{ $application->jobPost->client->industry ?? 'Employer' }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 flex flex-col sm:flex-row justify-end gap-3">
                    @if(Auth::id() === $application->user_id)
                        <a href="{{ route('jobs.show', $application->jobPost->id) }}" 
                            class="w-full sm:w-auto px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-center rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            View Original Job Post
                        </a>
                        
                        @if($application->status === 'pending')
                        <form action="{{ route('applications.withdraw', $application->id) }}" method="POST" class="w-full sm:w-auto">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Are you sure you want to withdraw this application?')"
                                class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                Withdraw Application
                            </button>
                        </form>
                        @endif
                    @endif
                    
                    <!-- For Clients -->
                    @if(Auth::id() === $application->jobPost->client_id && $application->status === 'pending')
                    <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-3">
                        <button type="button" data-modal-toggle="reject-modal"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Reject
                        </button>
                        <button type="button" data-modal-toggle="accept-modal"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            Accept Application
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Reject Application
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="reject-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ route('applications.update-status', $application->id) }}" method="POST" class="p-4 md:p-5">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                <div class="mb-4">
                    <label for="feedback" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Feedback (Optional)</label>
                    <textarea id="feedback" name="feedback" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Provide feedback to the applicant..."></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-hide="reject-modal" class="me-3 px-3 py-2 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none dark:bg-red-600 dark:hover:bg-red-700">
                        Reject Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Accept Modal -->
<div id="accept-modal" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Accept Application
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="accept-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ route('applications.update-status', $application->id) }}" method="POST" class="p-4 md:p-5">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="accepted">
                <div class="mb-4">
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        You are about to accept this application from <strong>{{ $application->user->name }}</strong> for the job <strong>{{ $application->jobPost->title }}</strong>.
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        The agreed amount is <strong>{{ $application->jobPost->currency }} {{ number_format($application->bid_amount, 2) }}{{ $application->jobPost->rate_type === 'hourly' ? '/hr' : '' }}</strong>.
                    </p>
                </div>
                <div class="mb-4">
                    <label for="feedback" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message to Freelancer (Optional)</label>
                    <textarea id="feedback" name="feedback" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Add a message for the freelancer..."></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-hide="accept-modal" class="me-3 px-3 py-2 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none dark:bg-green-600 dark:hover:bg-green-700">
                        Accept & Continue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Simple modal functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Modal toggle buttons
        const modalToggles = document.querySelectorAll('[data-modal-toggle]');
        modalToggles.forEach(button => {
            const modalId = button.getAttribute('data-modal-toggle');
            const modal = document.getElementById(modalId);
            
            button.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });
        
        // Modal hide buttons
        const modalHides = document.querySelectorAll('[data-modal-hide]');
        modalHides.forEach(button => {
            const modalId = button.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            
            button.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });
        });
    });
</script>
@endsection 