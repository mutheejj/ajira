@extends('layouts.app')

@section('title', 'Browse Jobs | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar / Filters -->
        <div class="w-full md:w-64 shrink-0">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 sticky top-20">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filters</h2>
                
                <form action="{{ route('jobs.index') }}" method="GET">
                    <!-- Search -->
                    <div class="mb-4">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm" placeholder="Keywords...">
                    </div>
                    
                    <!-- Categories -->
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select id="category" name="category" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="All Categories">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Experience level -->
                    <div class="mb-4">
                        <label for="experience_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience Level</label>
                        <select id="experience_level" name="experience_level" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="All Levels">All Levels</option>
                            <option value="Entry" {{ request('experience_level') == 'Entry' ? 'selected' : '' }}>Entry Level</option>
                            <option value="Intermediate" {{ request('experience_level') == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="Expert" {{ request('experience_level') == 'Expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                    </div>
                    
                    <!-- Project Type -->
                    <div class="mb-4">
                        <label for="project_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Type</label>
                        <select id="project_type" name="project_type" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="All Types">All Types</option>
                            <option value="One Time" {{ request('project_type') == 'One Time' ? 'selected' : '' }}>One Time</option>
                            <option value="Ongoing" {{ request('project_type') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                        </select>
                    </div>
                    
                    <!-- Application Deadline Status -->
                    <div class="mb-4">
                        <label for="deadline_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deadline Status</label>
                        <select id="deadline_status" name="deadline_status" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">All Jobs</option>
                            <option value="open" {{ request('deadline_status') == 'open' ? 'selected' : '' }}>Open Applications</option>
                            <option value="closed" {{ request('deadline_status') == 'closed' ? 'selected' : '' }}>Closed Applications</option>
                        </select>
                    </div>
                    
                    <!-- Budget Range -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget Range</label>
                        <div class="flex items-center gap-2">
                            <input type="number" id="min_budget" name="min_budget" value="{{ request('min_budget') }}" min="0" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm" placeholder="Min">
                            <span class="text-gray-500 dark:text-gray-400">-</span>
                            <input type="number" id="max_budget" name="max_budget" value="{{ request('max_budget') }}" min="0" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm" placeholder="Max">
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Apply Filters
                    </button>
                    
                    @if(request()->anyFilled(['search', 'category', 'experience_level', 'project_type', 'min_budget', 'max_budget']))
                        <a href="{{ route('jobs.index') }}" class="mt-2 inline-block w-full text-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                            Clear all filters
                        </a>
                    @endif
                </form>
            </div>
        </div>
        
        <!-- Main Content / Job Listings -->
        <div class="flex-1">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Available Jobs</h1>
                    
                    <div class="flex items-center mt-2 md:mt-0">
                        <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Sort by:</span>
                        <select id="sort" class="rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="budget_high">Budget: High to Low</option>
                            <option value="budget_low">Budget: Low to High</option>
                            <option value="deadline_soon">Deadline: Soonest First</option>
                            <option value="deadline_later">Deadline: Latest First</option>
                        </select>
                    </div>
                </div>
                
                <!-- Results count -->
                <p class="text-gray-600 dark:text-gray-400">
                    Showing {{ $jobs->firstItem() ?? 0 }} - {{ $jobs->lastItem() ?? 0 }} of {{ $jobs->total() }} jobs
                </p>
                
                <!-- Jobs List -->
                @if($jobs->count() > 0)
                    <div class="space-y-4">
                        @foreach($jobs as $job)
                            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('jobs.show', $job) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                                    {{ $job->title }}
                                                </a>
                                            </h3>
                                            <div class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                <span>{{ $job->client->name }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{ $job->category }}</span>
                                                <span class="mx-2">•</span>
                                                <span>{{ ucfirst($job->location_type) }}</span>
                                                @if($job->location && $job->location_type !== 'remote')
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $job->location }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-block font-medium text-blue-600 dark:text-blue-400">
                                                {{ $job->currency }} {{ number_format($job->budget) }}
                                            </span>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ ucfirst($job->rate_type) }} Rate
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit($job->description, 200) }}
                                        </p>
                                    </div>
                                    
                                    @if($job->application_deadline)
                                    <div class="mt-3">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 {{ now() > $job->application_deadline ? 'text-red-500' : 'text-green-500' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="text-xs {{ now() > $job->application_deadline ? 'text-red-500 font-bold' : 'text-gray-500 dark:text-gray-400' }}">
                                                Application {{ now() > $job->application_deadline ? 'closed on' : 'deadline:' }} 
                                                {{ $job->application_deadline->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach(json_decode($job->skills) as $skill)
                                            <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs px-2 py-1 rounded-full">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between items-center">
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Posted {{ $job->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            @auth
                                                @if(auth()->user()->isJobSeeker())
                                                    <a href="{{ route('applications.create', $job->id) }}" class="inline-flex items-center px-3 py-1 border border-blue-700 text-sm leading-5 font-medium rounded-md text-blue-700 dark:text-blue-400 bg-white dark:bg-gray-700 hover:text-white hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                                        Apply Now
                                                    </a>
                                                    
                                                    <form action="{{ route('saved-jobs.store', $job->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 text-sm leading-5 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 transition ease-in-out duration-150">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                            </svg>
                                                            Save
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1 border border-blue-700 text-sm leading-5 font-medium rounded-md text-blue-700 dark:text-blue-400 bg-white dark:bg-gray-700 hover:text-white hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                                    Login to Apply
                                                </a>
                                            @endauth
                                            
                                            <a href="{{ route('jobs.show', $job) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 dark:border-gray-600 text-sm leading-5 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 transition ease-in-out duration-150">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $jobs->withQueryString()->links() }}
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-10 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No jobs found</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">Try adjusting your search or filters to find what you're looking for.</p>
                        <div class="mt-6">
                            <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View All Jobs
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle sort selection
        const sortSelect = document.getElementById('sort');
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location);
            
            switch(this.value) {
                case 'newest':
                    url.searchParams.set('sort_by', 'created_at');
                    url.searchParams.set('sort_dir', 'desc');
                    break;
                case 'oldest':
                    url.searchParams.set('sort_by', 'created_at');
                    url.searchParams.set('sort_dir', 'asc');
                    break;
                case 'budget_high':
                    url.searchParams.set('sort_by', 'budget');
                    url.searchParams.set('sort_dir', 'desc');
                    break;
                case 'budget_low':
                    url.searchParams.set('sort_by', 'budget');
                    url.searchParams.set('sort_dir', 'asc');
                    break;
                case 'deadline_soon':
                    url.searchParams.set('sort_by', 'deadline');
                    url.searchParams.set('sort_dir', 'asc');
                    break;
                case 'deadline_later':
                    url.searchParams.set('sort_by', 'deadline');
                    url.searchParams.set('sort_dir', 'desc');
                    break;
            }
            
            window.location = url.toString();
        });
        
        // Set the current sort option
        const sortBy = '{{ request('sort_by', 'created_at') }}';
        const sortDir = '{{ request('sort_dir', 'desc') }}';
        
        if (sortBy === 'created_at' && sortDir === 'desc') {
            sortSelect.value = 'newest';
        } else if (sortBy === 'created_at' && sortDir === 'asc') {
            sortSelect.value = 'oldest';
        } else if (sortBy === 'budget' && sortDir === 'desc') {
            sortSelect.value = 'budget_high';
        } else if (sortBy === 'budget' && sortDir === 'asc') {
            sortSelect.value = 'budget_low';
        } else if (sortBy === 'deadline' && sortDir === 'asc') {
            sortSelect.value = 'deadline_soon';
        } else if (sortBy === 'deadline' && sortDir === 'desc') {
            sortSelect.value = 'deadline_later';
        }
    });
</script>
@endpush
@endsection 