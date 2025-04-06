@extends('layouts.admin')

@section('title', 'Job Details')

@section('content')
<div class="container mx-auto px-6">
    <div class="mb-6">
        <a href="{{ route('admin.jobs') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Back to Jobs
        </a>
    </div>

    <!-- Job Details Card -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $job->title }}</h1>
            <div>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                    @if($job->status == 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($job->status == 'closed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @elseif($job->status == 'draft') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                    {{ ucfirst($job->status) }}
                </span>
            </div>
        </div>

        <div class="p-6">
            <!-- Client Information -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Client Information</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                            {{ substr($job->client->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <div class="text-md font-medium text-gray-900 dark:text-white">{{ $job->client->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $job->client->email }}</div>
                            @if($job->client->company_name)
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $job->client->company_name }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Category</h3>
                    <p class="text-md text-gray-900 dark:text-white">{{ $job->category }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Budget</h3>
                    <p class="text-md text-gray-900 dark:text-white">
                        {{ $job->currency == 'USD' ? '$' : 'KSH ' }}{{ number_format($job->budget, 2) }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Experience Level</h3>
                    <p class="text-md text-gray-900 dark:text-white">{{ ucfirst($job->experience_level) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Project Type</h3>
                    <p class="text-md text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $job->project_type)) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Duration</h3>
                    <p class="text-md text-gray-900 dark:text-white">{{ $job->duration }} days</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Location</h3>
                    <p class="text-md text-gray-900 dark:text-white">
                        @if($job->remote_work)
                            Remote
                        @else
                            {{ $job->location ?? 'Not specified' }}
                        @endif
                    </p>
                </div>
            </div>

            <!-- Job Description -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Description</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="prose prose-indigo dark:prose-invert max-w-none">
                        {{ $job->description }}
                    </div>
                </div>
            </div>

            <!-- Job Requirements -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Requirements</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <div class="prose prose-indigo dark:prose-invert max-w-none">
                        {{ $job->requirements }}
                    </div>
                </div>
            </div>

            <!-- Skills -->
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Skills</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($job->skills) as $skill)
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 rounded-full text-sm">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Job Actions -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 flex flex-wrap gap-4 justify-end">
                <form action="{{ route('admin.jobs.update-status', $job->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="{{ $job->status == 'active' ? 'closed' : 'active' }}">
                    <button type="submit" class="px-4 py-2 rounded-md 
                        @if($job->status == 'active') 
                            bg-red-600 hover:bg-red-700 text-white 
                        @else 
                            bg-green-600 hover:bg-green-700 text-white 
                        @endif">
                        {{ $job->status == 'active' ? 'Close Job' : 'Activate Job' }}
                    </button>
                </form>
                
                <form action="{{ route('admin.jobs.delete', $job->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md" onclick="return confirm('Are you sure you want to delete this job? This action cannot be undone.')">
                        Delete Job
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Applications Section -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Applications ({{ $job->applications->count() }})</h2>
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($job->applications as $application)
                <div class="p-6">
                    <div class="flex flex-wrap md:flex-nowrap items-start justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                {{ substr($application->user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-md font-medium text-gray-900 dark:text-white">{{ $application->user->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $application->user->email }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Applied: {{ $application->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($application->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @elseif($application->status == 'accepted') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($application->status == 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 @endif">
                                {{ ucfirst($application->status) }}
                            </span>
                            
                            <div class="mt-2 flex gap-2">
                                @if($application->status == 'pending')
                                    <form action="{{ route('applications.update-status', $application->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="accepted">
                                        <button type="submit" class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs">
                                            Accept
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('applications.update-status', $application->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">
                                            Reject
                                        </button>
                                    </form>
                                @endif
                                
                                @if($application->attachment)
                                    <a href="{{ route('applications.download', $application->id) }}" class="px-2 py-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded text-xs">
                                        Download CV
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if($application->cover_letter)
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Cover Letter</h3>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $application->cover_letter }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                    No applications received yet.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection 