@extends('layouts.app')

@section('title', 'My Jobs | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <!-- Header -->
        <div class="p-4 md:p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">Your Job Postings</h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">Manage your posted jobs and view applications</p>
            </div>
            
            <!-- Add Post Job Button to trigger the modal -->
            <button id="openJobModal" class="mt-4 md:mt-0 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm flex items-center transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Post a New Job
            </button>
        </div>

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Job Postings</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Manage and track all your job postings</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('client.create-job') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Post a New Job
            </a>
        </div>
    </div>
    
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
    
    <!-- Filters & Search -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg mb-6 p-4">
        <form action="{{ route('client.jobs') }}" method="GET" class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
            <!-- Status Filter -->
            <div class="flex-1">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select id="status" name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">All Statuses ({{ $statusCounts['all'] }})</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active ({{ $statusCounts['active'] }})</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed ({{ $statusCounts['completed'] }})</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft ({{ $statusCounts['draft'] }})</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed ({{ $statusCounts['closed'] }})</option>
                </select>
            </div>
            
            <!-- Search -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Search job title..." class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />
            </div>
            
            <!-- Sort By -->
            <div class="w-full md:w-48">
                <label for="sort_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort By</label>
                <select id="sort_by" name="sort_by" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="created_at" {{ request('sort_by') == 'created_at' || !request('sort_by') ? 'selected' : '' }}>Date Posted</option>
                    <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="budget" {{ request('sort_by') == 'budget' ? 'selected' : '' }}>Budget</option>
                </select>
            </div>
            
            <!-- Sort Direction -->
            <div class="w-full md:w-48">
                <label for="sort_dir" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order</label>
                <select id="sort_dir" name="sort_dir" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="desc" {{ request('sort_dir') == 'desc' || !request('sort_dir') ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ request('sort_dir') == 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>
            
            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>
    
    <!-- Jobs Table -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        @if(count($jobs) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Job</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Budget</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Posted</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Applications</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($jobs as $job)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $job->title }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <span class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ ucfirst($job->job_type) }}
                                </span>
                                <span class="inline-flex items-center ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $job->location_type }}
                                </span>
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
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $job->applications_count }}</div>
                                <div class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                                    @if($job->accepted_applications_count > 0)
                                    ({{ $job->accepted_applications_count }} hired)
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($job->status === 'active')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                Active
                            </span>
                            @elseif($job->status === 'completed')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                Completed
                            </span>
                            @elseif($job->status === 'draft')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                Draft
                            </span>
                            @elseif($job->status === 'closed')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                Closed
                            </span>
                            @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ ucfirst($job->status) }}
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('jobs.show', $job->id) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300" title="View Job">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                
                                <a href="{{ route('applications.list', $job->id) }}" class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300" title="View Applications">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                
                                <a href="{{ route('client.jobs.edit', $job->id) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300" title="Edit Job">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                
                                <button type="button" onclick="toggleJobStatusModal('{{ $job->id }}')" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300" title="Change Status">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                
                                <button type="button" onclick="confirmDeleteJob('{{ $job->id }}')" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" title="Delete Job">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
        @else
        <div class="p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <p class="text-gray-600 dark:text-gray-400 mb-4">No job postings found.</p>
            @if(request('status') || request('search'))
            <p class="text-gray-500 dark:text-gray-500 mb-4">Try adjusting your search filters.</p>
            <a href="{{ route('client.jobs') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Clear all filters</a>
            @else
            <a href="{{ route('client.create-job') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Post Your First Job
            </a>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Job Post Modal -->
<div id="jobPostModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="modalOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
        
        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Post a New Job
                </h3>
                <button id="closeJobModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 max-h-[80vh] overflow-y-auto">
                <form id="jobPostForm" action="{{ route('client.store-job') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Job Title -->
                        <div class="col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Title*</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="E.g., WordPress Developer Needed for E-commerce Site" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('title')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Job Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Description*</label>
                            <textarea id="description" name="description" rows="4" required placeholder="Provide a detailed description of the job requirements, responsibilities, and any specific skills needed..." class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Category*</label>
                            <select id="category" name="category" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select a category</option>
                                <option value="Web Development">Web Development</option>
                                <option value="Mobile Development">Mobile Development</option>
                                <option value="UI/UX Design">UI/UX Design</option>
                                <option value="Graphic Design">Graphic Design</option>
                                <option value="Content Writing">Content Writing</option>
                                <option value="Digital Marketing">Digital Marketing</option>
                                <option value="SEO">SEO</option>
                                <option value="Social Media Management">Social Media Management</option>
                                <option value="Video Editing">Video Editing</option>
                                <option value="Animation">Animation</option>
                                <option value="Data Entry">Data Entry</option>
                                <option value="Virtual Assistant">Virtual Assistant</option>
                                <option value="Customer Service">Customer Service</option>
                                <option value="Accounting">Accounting</option>
                                <option value="Project Management">Project Management</option>
                                <option value="Legal">Legal</option>
                                <option value="Engineering">Engineering</option>
                                <option value="Translation">Translation</option>
                                <option value="Data Science">Data Science</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('category')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Job Type -->
                        <div>
                            <label for="job_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Type*</label>
                            <select id="job_type" name="job_type" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="one-time" {{ old('job_type') == 'one-time' ? 'selected' : '' }}>One-time Project</option>
                                <option value="ongoing" {{ old('job_type') == 'ongoing' ? 'selected' : '' }}>Ongoing Work</option>
                            </select>
                            @error('job_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Skills -->
                        <div class="col-span-2">
                            <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Required Skills*</label>
                            <select id="skills" name="skills[]" multiple required class="select2 w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="HTML">HTML</option>
                                <option value="CSS">CSS</option>
                                <option value="JavaScript">JavaScript</option>
                                <option value="React">React</option>
                                <option value="Vue.js">Vue.js</option>
                                <option value="Angular">Angular</option>
                                <option value="Node.js">Node.js</option>
                                <option value="Python">Python</option>
                                <option value="Django">Django</option>
                                <option value="Flask">Flask</option>
                                <option value="PHP">PHP</option>
                                <option value="Laravel">Laravel</option>
                                <option value="WordPress">WordPress</option>
                                <option value="Shopify">Shopify</option>
                                <option value="Ruby">Ruby</option>
                                <option value="Ruby on Rails">Ruby on Rails</option>
                                <option value="Java">Java</option>
                                <option value="Spring">Spring</option>
                                <option value="C#">C#</option>
                                <option value=".NET">.NET</option>
                                <option value="Swift">Swift</option>
                                <option value="Kotlin">Kotlin</option>
                                <option value="Flutter">Flutter</option>
                                <option value="React Native">React Native</option>
                                <option value="iOS">iOS</option>
                                <option value="Android">Android</option>
                                <option value="SQL">SQL</option>
                                <option value="MongoDB">MongoDB</option>
                                <option value="MySQL">MySQL</option>
                                <option value="PostgreSQL">PostgreSQL</option>
                                <option value="AWS">AWS</option>
                                <option value="Docker">Docker</option>
                                <option value="Kubernetes">Kubernetes</option>
                                <option value="Git">Git</option>
                                <option value="Figma">Figma</option>
                                <option value="Adobe XD">Adobe XD</option>
                                <option value="Photoshop">Photoshop</option>
                                <option value="Illustrator">Illustrator</option>
                                <option value="SEO">SEO</option>
                                <option value="Content Writing">Content Writing</option>
                                <option value="Copywriting">Copywriting</option>
                                <option value="Technical Writing">Technical Writing</option>
                                <option value="Data Analysis">Data Analysis</option>
                                <option value="Machine Learning">Machine Learning</option>
                                <option value="AI">AI</option>
                            </select>
                            @error('skills')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <hr class="col-span-2 border-gray-200 dark:border-gray-700">
                        
                        <!-- Budget Section -->
                        <div class="col-span-2">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Budget and Timeline</h2>
                        </div>
                        
                        <!-- Rate Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Type*</label>
                            <div class="flex gap-4 mt-1">
                                <div class="flex items-center">
                                    <input type="radio" id="fixed" name="rate_type" value="fixed" {{ old('rate_type') == 'fixed' || !old('rate_type') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="fixed" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Fixed Price</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="hourly" name="rate_type" value="hourly" {{ old('rate_type') == 'hourly' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <label for="hourly" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Hourly Rate</label>
                                </div>
                            </div>
                            @error('rate_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Budget -->
                        <div class="flex items-center space-x-2">
                            <div class="w-1/3">
                                <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Currency*</label>
                                <select id="currency" name="currency" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="USD" {{ old('currency') == 'USD' || !old('currency') ? 'selected' : '' }}>USD</option>
                                    <option value="KES" {{ old('currency') == 'KES' ? 'selected' : '' }}>KES</option>
                                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget Amount*</label>
                                <input type="number" id="budget" name="budget" value="{{ old('budget') }}" required min="1" step="0.01" placeholder="Enter amount" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('budget')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Experience Level -->
                        <div>
                            <label for="experience_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience Level Required*</label>
                            <select id="experience_level" name="experience_level" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="entry" {{ old('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="intermediate" {{ old('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="expert" {{ old('experience_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                            @error('experience_level')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Location Type -->
                        <div>
                            <label for="location_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location Type*</label>
                            <select id="location_type" name="location_type" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="remote" {{ old('location_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                                <option value="on-site" {{ old('location_type') == 'on-site' ? 'selected' : '' }}>On-site</option>
                                <option value="hybrid" {{ old('location_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                            @error('location_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Location for on-site/hybrid -->
                        <div id="locationField" class="location-field" style="{{ old('location_type') == 'remote' ? 'display:none' : '' }}">
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location Address</label>
                            <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="City, State, Country" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('location')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Status*</label>
                            <select id="status" name="status" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Publish Immediately)</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Save for Later)</option>
                            </select>
                            @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                
                    <!-- Modal footer -->
                    <div class="flex items-center justify-end space-x-2 mt-6">
                        <button type="button" id="cancelJobPost" class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition-colors duration-150">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors duration-150">
                            Post Job
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Status Change Modal -->
<div id="job-status-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="job-status-form" method="POST">
                @csrf
                @method('PATCH')
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Update Job Status
                            </h3>
                            <div class="mt-4">
                                <label for="job-status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select id="job-status" name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="active">Active</option>
                                    <option value="completed">Completed</option>
                                    <option value="draft">Draft</option>
                                    <option value="closed">Closed</option>
                                </select>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Changing the status will affect how this job appears to freelancers.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Update Status
                    </button>
                    <button type="button" onclick="toggleJobStatusModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-job-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="delete-job-form" method="POST">
                @csrf
                @method('DELETE')
                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Delete Job Posting
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Are you sure you want to delete this job posting? This action cannot be undone, and all associated applications will be deleted as well.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button type="button" onclick="confirmDeleteJob()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Job Status Modal
    function toggleJobStatusModal(jobId = null) {
        const modal = document.getElementById('job-status-modal');
        
        if (jobId) {
            // Show modal
            modal.classList.remove('hidden');
            const form = document.getElementById('job-status-form');
            form.action = `/jobs/${jobId}/update-status`;
        } else {
            // Hide modal
            modal.classList.add('hidden');
        }
    }
    
    // Delete Job Modal
    function confirmDeleteJob(jobId = null) {
        const modal = document.getElementById('delete-job-modal');
        
        if (jobId) {
            // Show modal
            modal.classList.remove('hidden');
            const form = document.getElementById('delete-job-form');
            form.action = `/jobs/${jobId}`;
        } else {
            // Hide modal
            modal.classList.add('hidden');
        }
    }
    
    // Auto-submit form when filter changes
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const sortBySelect = document.getElementById('sort_by');
        const sortDirSelect = document.getElementById('sort_dir');
        
        // Only auto-submit if the user explicitly changes the value
        statusSelect.addEventListener('change', function() {
            document.querySelector('form').submit();
        });
        
        sortBySelect.addEventListener('change', function() {
            document.querySelector('form').submit();
        });
        
        sortDirSelect.addEventListener('change', function() {
            document.querySelector('form').submit();
        });
    });

    // Job Post Modal Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('jobPostModal');
        const openModalBtn = document.getElementById('openJobModal');
        const closeModalBtn = document.getElementById('closeJobModal');
        const cancelBtn = document.getElementById('cancelJobPost');
        const overlay = document.getElementById('modalOverlay');
        const locationTypeSelect = document.getElementById('location_type');
        const locationField = document.getElementById('locationField');
        
        // Open modal
        openModalBtn?.addEventListener('click', function() {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
        
        // Close modal
        const closeModal = function() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };
        
        closeModalBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);
        overlay?.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeModal();
            }
        });
        
        // Toggle location field visibility based on location type
        locationTypeSelect?.addEventListener('change', function() {
            if (this.value === 'remote') {
                locationField.style.display = 'none';
            } else {
                locationField.style.display = 'block';
            }
        });
        
        // Show modal if there are any form errors
        @if($errors->any())
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        @endif
        
        // Initialize select2
        try {
            $('#skills').select2({
                placeholder: 'Select required skills',
                allowClear: true,
                tags: true,
                dropdownParent: $('#jobPostModal')
            });
        } catch (e) {
            console.error('Error initializing Select2:', e);
        }
    });
</script>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Fix for Select2 in modals */
    .select2-container {
        z-index: 9999;
    }
    .select2-dropdown {
        z-index: 9999;
    }
    /* Custom styling for Select2 */
    .select2-container--default .select2-selection--multiple {
        border-color: rgb(209, 213, 219);
        border-radius: 0.375rem;
    }
    .dark .select2-container--default .select2-selection--multiple {
        background-color: rgb(55, 65, 81);
        border-color: rgb(75, 85, 99);
    }
    .dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: rgb(75, 85, 99);
        color: white;
        border-color: rgb(107, 114, 128);
    }
    .dark .select2-dropdown {
        background-color: rgb(55, 65, 81);
        color: white;
    }
    .dark .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: rgb(75, 85, 99);
    }
    .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: rgb(79, 70, 229);
    }
</style>
@endsection 