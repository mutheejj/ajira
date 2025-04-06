@extends('layouts.app')

@section('title', 'Find Freelancers | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar / Filters -->
        <div class="w-full md:w-64 shrink-0">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 sticky top-20">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filters</h2>
                
                <form action="{{ route('freelancer.index') }}" method="GET">
                    <!-- Search -->
                    <div class="mb-4">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm" placeholder="Keywords...">
                    </div>
                    
                    <!-- Categories -->
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select id="category" name="category" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Skills -->
                    <div class="mb-4">
                        <label for="skill" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Skills</label>
                        <select id="skill" name="skill" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="">All Skills</option>
                            @foreach($skills as $skill)
                                <option value="{{ $skill->name }}" {{ request('skill') == $skill->name ? 'selected' : '' }}>{{ $skill->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        Apply Filters
                    </button>
                    
                    @if(request()->anyFilled(['search', 'category', 'skill']))
                        <a href="{{ route('freelancer.index') }}" class="mt-2 inline-block w-full text-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                            Clear all filters
                        </a>
                    @endif
                </form>
            </div>
        </div>
        
        <!-- Main Content / Freelancer Listings -->
        <div class="flex-1">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Available Freelancers</h1>
                    
                    <div class="flex items-center mt-2 md:mt-0">
                        <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Sort by:</span>
                        <select id="sort" name="sort" class="rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white text-sm">
                            <option value="created_at_desc" {{ request('sort_by') == 'created_at' && request('sort_order') == 'desc' ? 'selected' : '' }}>Newest</option>
                            <option value="created_at_asc" {{ request('sort_by') == 'created_at' && request('sort_order') == 'asc' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </div>
                </div>
                
                <!-- Results count -->
                <p class="text-gray-600 dark:text-gray-400">
                    Showing {{ $freelancers->firstItem() ?? 0 }} - {{ $freelancers->lastItem() ?? 0 }} of {{ $freelancers->total() }} freelancers
                </p>
                
                <!-- Freelancers List -->
                @if($freelancers->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($freelancers as $freelancer)
                            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($freelancer->profile_picture)
                                                <img src="{{ asset('storage/' . $freelancer->profile_picture) }}" alt="{{ $freelancer->name }}" class="h-16 w-16 rounded-full object-cover">
                                            @else
                                                <div class="h-16 w-16 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                    <svg class="h-10 w-10 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                <a href="{{ route('freelancer.show', $freelancer->username ?? $freelancer->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                                    {{ $freelancer->name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $freelancer->profession ?? 'Freelancer' }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($freelancer->profile && $freelancer->profile->category)
                                        <div class="mt-3">
                                            <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-medium px-2.5 py-0.5 rounded">
                                                {{ $freelancer->profile->category }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-3">
                                        <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-2">
                                            {{ $freelancer->bio ?? Str::limit($freelancer->profile->bio ?? 'No bio available', 100) }}
                                        </p>
                                    </div>
                                    
                                    @if($freelancer->skills && is_array($freelancer->skills) && count($freelancer->skills) > 0)
                                        <div class="mt-3 flex flex-wrap gap-1">
                                            @foreach(array_slice($freelancer->skills, 0, 3) as $skill)
                                                <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs px-2 py-1 rounded-full">
                                                    {{ $skill }}
                                                </span>
                                            @endforeach
                                            @if(count($freelancer->skills) > 3)
                                                <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs px-2 py-1 rounded-full">
                                                    +{{ count($freelancer->skills) - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <div class="mt-4">
                                        <a href="{{ route('freelancer.show', $freelancer->username ?? $freelancer->id) }}" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $freelancers->withQueryString()->links() }}
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-10 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No freelancers found</h3>
                        <p class="mt-1 text-gray-500 dark:text-gray-400">Try adjusting your search or filters to find what you're looking for.</p>
                        <div class="mt-6">
                            <a href="{{ route('freelancer.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View All Freelancers
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
            
            const [sortBy, sortOrder] = this.value.split('_');
            url.searchParams.set('sort_by', sortBy);
            url.searchParams.set('sort_order', sortOrder);
            
            window.location = url.toString();
        });
    });
</script>
@endpush
@endsection 