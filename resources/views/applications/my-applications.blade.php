@extends('layouts.app')

@section('title', 'My Applications | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Applications</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ $applications->total() }} application(s) submitted
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
                                Job
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Client
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Your Bid
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
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    <a href="{{ route('jobs.show', $application->jobPost->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                        {{ Str::limit($application->jobPost->title, 40) }}
                                    </a>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ ucfirst($application->jobPost->job_type) }} · {{ $application->jobPost->location_type }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $application->jobPost->client->company_name ?? $application->jobPost->client->name }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $application->jobPost->client->industry ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $application->jobPost->currency }} {{ number_format($application->bid_amount, 2) }}
                                    @if($application->jobPost->rate_type === 'hourly')
                                    <span class="text-xs text-gray-500 dark:text-gray-400">/hr</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $application->estimated_duration }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $application->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $application->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $application->getStatusBadgeClass() }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('applications.show', $application->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">View</a>
                                
                                @if($application->status === 'pending')
                                <span class="text-gray-300 dark:text-gray-600 mx-2">|</span>
                                <form action="{{ route('applications.withdraw', $application->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Are you sure you want to withdraw this application?')"
                                        class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                        Withdraw
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500 dark:text-gray-400">
                                <p class="mb-2">You haven't applied to any jobs yet.</p>
                                <a href="{{ route('jobs.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    Browse jobs and start applying
                                </a>
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
                    return parseFloat(a.querySelector('td:nth-child(3) div:first-child').textContent.replace(/[^0-9.-]+/g, '')) - 
                           parseFloat(b.querySelector('td:nth-child(3) div:first-child').textContent.replace(/[^0-9.-]+/g, ''));
                } else if (selectedSort === 'bid-high') {
                    return parseFloat(b.querySelector('td:nth-child(3) div:first-child').textContent.replace(/[^0-9.-]+/g, '')) - 
                           parseFloat(a.querySelector('td:nth-child(3) div:first-child').textContent.replace(/[^0-9.-]+/g, ''));
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