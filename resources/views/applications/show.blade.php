@extends('layouts.app')

@section('title', 'Application Details | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
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
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $application->jobPost->title }}
                        </h1>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">
                            <span class="font-medium">Applied on:</span> {{ $application->created_at->format('M d, Y') }}
                        </p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $application->getStatusBadgeClass() }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                            {{ $application->jobPost->currency }} {{ number_format($application->bid_amount, 2) }}
                            @if($application->jobPost->rate_type === 'hourly')
                            /hr
                            @endif
                        </span>
                    </div>
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
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Attachment</p>
                            <div class="mt-1">
                                <a href="{{ route('applications.download', $application->id) }}" 
                                    class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Download Attachment
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
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 flex justify-end">
                    <!-- For Job Seekers (applicants) -->
                    @if(Auth::id() === $application->user_id && $application->status === 'pending')
                    <form action="{{ route('applications.withdraw', $application->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" onclick="return confirm('Are you sure you want to withdraw this application?')"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Withdraw Application
                        </button>
                    </form>
                    @endif
                    
                    <!-- For Clients -->
                    @if(Auth::id() === $application->jobPost->client_id && $application->status === 'pending')
                    <div class="space-x-3">
                        <button type="button" data-modal-toggle="reject-modal"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            Reject
                        </button>
                        <button type="button" data-modal-toggle="accept-modal"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
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