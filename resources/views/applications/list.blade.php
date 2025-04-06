@extends('layouts.app')

@section('title', 'Applications for ' . $jobPost->title . ' | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="{{ route('jobs.show', $jobPost->id) }}" 
                    class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Job
                </a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Applications for "{{ $jobPost->title }}"</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ $applications->total() }} application(s) received
                </p>
            </div>
            
            <div class="flex space-x-2">
                <select id="status-filter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="accepted">Accepted</option>
                    <option value="rejected">Rejected</option>
                    <option value="withdrawn">Withdrawn</option>
                </select>
                
                <select id="sort-by" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="bid-low">Bid: Low to High</option>
                    <option value="bid-high">Bid: High to Low</option>
                </select>
            </div>
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
        
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Applicant
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Bid
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Estimated Duration
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date Applied
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($applications as $application)
                        <tr class="application-row" data-status="{{ $application->status }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ asset('images/avatar.png') }}" alt="{{ $application->user->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $application->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $application->user->profession ?? 'Freelancer' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $jobPost->currency }} {{ number_format($application->bid_amount, 2) }}
                                    @if($jobPost->rate_type === 'hourly')
                                    <span class="text-xs text-gray-500 dark:text-gray-400">/hr</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    @if($jobPost->budget > 0)
                                        @if($application->bid_amount > $jobPost->budget)
                                            <span class="text-red-500 dark:text-red-400">+{{ number_format(($application->bid_amount - $jobPost->budget) / $jobPost->budget * 100, 0) }}%</span>
                                        @elseif($application->bid_amount < $jobPost->budget)
                                            <span class="text-green-500 dark:text-green-400">-{{ number_format(($jobPost->budget - $application->bid_amount) / $jobPost->budget * 100, 0) }}%</span>
                                        @else
                                            <span>Exact budget</span>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $application->estimated_duration }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $application->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $application->created_at->format('h:i A') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $application->getStatusBadgeClass() }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('applications.show', $application->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mr-3">View</a>
                                
                                @if($application->status === 'pending')
                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                <button type="button" 
                                    data-modal-toggle="accept-modal-{{ $application->id }}" 
                                    class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 mx-3">
                                    Accept
                                </button>
                                
                                <span class="text-gray-300 dark:text-gray-600">|</span>
                                <button type="button" 
                                    data-modal-toggle="reject-modal-{{ $application->id }}" 
                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 ml-3">
                                    Reject
                                </button>
                                @endif
                            </td>
                        </tr>
                        
                        <!-- Accept Modal for each application -->
                        <div id="accept-modal-{{ $application->id }}" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Accept Application
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="accept-modal-{{ $application->id }}">
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
                                                You are about to accept this application from <strong>{{ $application->user->name }}</strong>.
                                            </p>
                                            <p class="text-gray-700 dark:text-gray-300">
                                                The agreed amount is <strong>{{ $jobPost->currency }} {{ number_format($application->bid_amount, 2) }}{{ $jobPost->rate_type === 'hourly' ? '/hr' : '' }}</strong>.
                                            </p>
                                        </div>
                                        <div class="mb-4">
                                            <label for="feedback-{{ $application->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message to Freelancer (Optional)</label>
                                            <textarea id="feedback-{{ $application->id }}" name="feedback" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Add a message for the freelancer..."></textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="button" data-modal-hide="accept-modal-{{ $application->id }}" class="me-3 px-3 py-2 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600">
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
                        
                        <!-- Reject Modal for each application -->
                        <div id="reject-modal-{{ $application->id }}" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            Reject Application
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="reject-modal-{{ $application->id }}">
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
                                            <label for="reject-feedback-{{ $application->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Feedback (Optional)</label>
                                            <textarea id="reject-feedback-{{ $application->id }}" name="feedback" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Provide feedback to the applicant..."></textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="button" data-modal-hide="reject-modal-{{ $application->id }}" class="me-3 px-3 py-2 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600">
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
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500 dark:text-gray-400">
                                No applications found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($applications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $applications->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status filter functionality
        const statusFilter = document.getElementById('status-filter');
        const applicationRows = document.querySelectorAll('.application-row');
        
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            
            applicationRows.forEach(row => {
                const rowStatus = row.dataset.status;
                
                if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
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
        
        // Sort functionality
        const sortBy = document.getElementById('sort-by');
        const applicationList = document.querySelector('tbody');
        const applicationRowsArray = Array.from(applicationRows);
        
        sortBy.addEventListener('change', function() {
            const selectedSort = this.value;
            
            applicationRowsArray.sort((a, b) => {
                if (selectedSort === 'newest') {
                    return new Date(b.querySelector('td:nth-child(4) div:first-child').textContent) - 
                           new Date(a.querySelector('td:nth-child(4) div:first-child').textContent);
                } else if (selectedSort === 'oldest') {
                    return new Date(a.querySelector('td:nth-child(4) div:first-child').textContent) - 
                           new Date(b.querySelector('td:nth-child(4) div:first-child').textContent);
                } else if (selectedSort === 'bid-low') {
                    return parseFloat(a.querySelector('td:nth-child(2) div:first-child').textContent.replace(/[^0-9.-]+/g, '')) - 
                           parseFloat(b.querySelector('td:nth-child(2) div:first-child').textContent.replace(/[^0-9.-]+/g, ''));
                } else if (selectedSort === 'bid-high') {
                    return parseFloat(b.querySelector('td:nth-child(2) div:first-child').textContent.replace(/[^0-9.-]+/g, '')) - 
                           parseFloat(a.querySelector('td:nth-child(2) div:first-child').textContent.replace(/[^0-9.-]+/g, ''));
                }
                return 0;
            });
            
            // Remove all rows
            applicationRows.forEach(row => row.remove());
            
            // Append sorted rows
            applicationRowsArray.forEach(row => {
                applicationList.appendChild(row);
            });
        });
    });
</script>
@endsection 