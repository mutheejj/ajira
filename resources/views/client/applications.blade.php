@extends('layouts.app')

@section('title', 'Job Applications | Ajira Global')

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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Client</p>
                </div>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('client.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('client.jobs') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                        <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                    </svg>
                    My Jobs
                </a>
                <a href="{{ route('client.applications') }}" class="flex items-center px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-md font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0019.414 6L15 1.586A2 2 0 0013.586 1H10a2 2 0 00-2 2zm7 2l3 3v1h-4V4h1zm-2 12H5V4h5v3a2 2 0 002 2h3v7z" clip-rule="evenodd" />
                    </svg>
                    Applications
                </a>
                <a href="{{ route('client.active-contracts') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1.323l-3.954 1.582A1 1 0 004 6.832v10.336a1 1 0 001.424.933l3.79-2.016a1 1 0 01.943 0l3.792 2.016a1 1 0 001.424-.933V6.832a1 1 0 00-1.046-.933L10 3.323V3a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Active Contracts
                </a>
                <a href="{{ route('client.payments') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    Payments
                </a>
                <a href="{{ route('wallet.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                    Wallet
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
            <!-- Job Filter Dropdown -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Job Applications</h1>
                    <div class="mt-4 md:mt-0">
                        <select id="job-filter" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="all">All Jobs</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job->id }}">{{ $job->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <!-- Application Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-750 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-200 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Applications</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statistics['total'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-750 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-200 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Review</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statistics['pending'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-750 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-200 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Shortlisted</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statistics['shortlisted'] }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white dark:bg-gray-750 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-200 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rejected</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $statistics['rejected'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Applications Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-sm">
                            <tr>
                                <th class="py-3 px-4 text-left font-medium">Applicant</th>
                                <th class="py-3 px-4 text-left font-medium">Job Position</th>
                                <th class="py-3 px-4 text-left font-medium">Applied On</th>
                                <th class="py-3 px-4 text-left font-medium">Status</th>
                                <th class="py-3 px-4 text-left font-medium">Match Score</th>
                                <th class="py-3 px-4 text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($applications as $application)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-700 dark:text-gray-300 font-medium">
                                            {{ substr($application->jobSeeker->name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $application->jobSeeker->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $application->jobSeeker->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $application->job->title }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $application->job->location }}</div>
                                </td>
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-300">
                                    {{ $application->applied_date->format('M d, Y') }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($application->status === 'pending')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                    @elseif($application->status === 'in-review')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">In Review</span>
                                    @elseif($application->status === 'shortlisted')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Shortlisted</span>
                                    @elseif($application->status === 'accepted')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Accepted</span>
                                    @elseif($application->status === 'rejected')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Rejected</span>
                                    @elseif($application->status === 'withdrawn')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Withdrawn</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center">
                                        <div class="relative w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full">
                                            <div class="absolute top-0 left-0 h-2 rounded-full {{ $application->match_score >= 80 ? 'bg-green-500' : ($application->match_score >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $application->match_score }}%;"></div>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">{{ $application->match_score }}%</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('applications.show', $application->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="View application">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        
                                        @if($application->status === 'pending' || $application->status === 'in-review')
                                            <button type="button" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300" title="Shortlist applicant" data-application-id="{{ $application->id }}" data-action="shortlist">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            
                                            <button type="button" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Reject applicant" data-application-id="{{ $application->id }}" data-action="reject">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @elseif($application->status === 'shortlisted')
                                            <button type="button" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Schedule interview" data-application-id="{{ $application->id }}" data-action="interview">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-medium mb-1">No applications yet</p>
                                        <p class="text-sm">When someone applies to your job, they will appear here.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $applications->links() }}
                </div>
            </div>
            
            <!-- Suggested Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Suggested Actions</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg p-4">
                        <h3 class="font-medium text-blue-800 dark:text-blue-300 mb-2">Pending Applications</h3>
                        @if($statistics['pending'] > 0)
                            <p class="text-blue-600 dark:text-blue-400 mb-3">You have {{ $statistics['pending'] }} pending applications that need your review.</p>
                            <a href="#" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                Review applications
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <p class="text-blue-600 dark:text-blue-400">Great job! You've reviewed all applications.</p>
                        @endif
                    </div>
                    
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-100 dark:border-purple-800 rounded-lg p-4">
                        <h3 class="font-medium text-purple-800 dark:text-purple-300 mb-2">Schedule Interviews</h3>
                        @if($statistics['shortlisted'] > 0)
                            <p class="text-purple-600 dark:text-purple-400 mb-3">You have {{ $statistics['shortlisted'] }} shortlisted candidates ready for interviews.</p>
                            <a href="#" class="inline-flex items-center text-sm font-medium text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
                                Schedule interviews
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <p class="text-purple-600 dark:text-purple-400">You don't have any candidates shortlisted for interviews yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter applications by job
        const jobFilter = document.getElementById('job-filter');
        if (jobFilter) {
            jobFilter.addEventListener('change', function() {
                const jobId = this.value;
                if (jobId === 'all') {
                    window.location.href = "{{ route('client.applications') }}";
                } else {
                    window.location.href = "{{ route('client.applications') }}?job_id=" + jobId;
                }
            });
        }
        
        // Handle application status actions
        const actionButtons = document.querySelectorAll('[data-action]');
        actionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-application-id');
                const action = this.getAttribute('data-action');
                
                // In a real implementation, you would make an AJAX request here
                console.log(`Performing ${action} on application ${applicationId}`);
                
                // This is just a placeholder for demonstration purposes
                alert(`${action.charAt(0).toUpperCase() + action.slice(1)} action will be performed on application #${applicationId}`);
            });
        });
    });
</script>
@endsection 