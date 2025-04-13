@extends('layouts.app')

@section('title', 'Ajira Global - Find & Hire Top Talent')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Find Global Talent or Your Next Job Opportunity</h1>
                <p class="text-xl mb-8">Connect with top professionals worldwide or discover your next career move on Ajira Global.</p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-white text-blue-600 font-semibold hover:bg-gray-100 transition-colors">
                        Get Started
                    </a>
                    <a href="{{ route('how-it-works') }}" class="px-6 py-3 rounded-lg border border-white text-white font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                        How It Works
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative Element -->
        <div class="hidden lg:block absolute right-0 bottom-0 w-1/3 h-full">
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute inset-0 h-full w-full text-white opacity-10">
                <polygon points="0,0 100,0 100,100" fill="currentColor"></polygon>
            </svg>
        </div>
    </section>

    <!-- Category Filters Section -->
    <section class="py-8 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Find Work in These Categories</h2>
                
                <!-- Filter Form -->
                <form action="{{ route('home') }}" method="GET" id="filter-form">
                    <!-- Category filters as buttons -->
                    <div class="flex flex-wrap gap-3 mb-4">
                        <button type="button" data-category="all" onclick="setCategory('all')" class="filter-btn category-btn px-4 py-2 rounded-full {{ !request('category') || request('category') == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white' }} hover:bg-blue-700 transition-colors">All Categories</button>
                        
                        @foreach($categoryStats as $categoryStat)
                        <button type="button" data-category="{{ strtolower(str_replace(' ', '-', $categoryStat['category'])) }}" onclick="setCategory('{{ strtolower(str_replace(' ', '-', $categoryStat['category'])) }}')" class="filter-btn category-btn px-4 py-2 rounded-full {{ request('category') == strtolower(str_replace(' ', '-', $categoryStat['category'])) ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white' }} hover:bg-blue-700 transition-colors">
                            {{ $categoryStat['category'] }}
                            <span class="ml-1 text-xs opacity-70">({{ $categoryStat['count'] }})</span>
                        </button>
                        @endforeach
                    </div>
                    
                    <!-- Hidden input for category -->
                    <input type="hidden" name="category" id="category-input" value="{{ request('category', 'all') }}">
                    
                    <!-- Secondary filters -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="experience-level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience Level</label>
                            <select id="experience-level" name="experience_level" onchange="document.getElementById('filter-form').submit()" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="all" {{ !request('experience_level') || request('experience_level') == 'all' ? 'selected' : '' }}>Any Experience</option>
                                <option value="entry" {{ request('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                                <option value="intermediate" {{ request('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="expert" {{ request('experience_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                        </div>
                        <div>
                            <label for="job-type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Type</label>
                            <select id="job-type" name="job_type" onchange="document.getElementById('filter-form').submit()" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="all" {{ !request('job_type') || request('job_type') == 'all' ? 'selected' : '' }}>All Job Types</option>
                                <option value="full_time" {{ request('job_type') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                <option value="part_time" {{ request('job_type') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                <option value="contract" {{ request('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                                <option value="freelance" {{ request('job_type') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            </select>
                        </div>
                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget</label>
                            <select id="budget" name="budget" onchange="document.getElementById('filter-form').submit()" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="all" {{ !request('budget') || request('budget') == 'all' ? 'selected' : '' }}>Any Budget</option>
                                <option value="under-100" {{ request('budget') == 'under-100' ? 'selected' : '' }}>Under $100</option>
                                <option value="100-500" {{ request('budget') == '100-500' ? 'selected' : '' }}>$100 - $500</option>
                                <option value="500-1000" {{ request('budget') == '500-1000' ? 'selected' : '' }}>$500 - $1,000</option>
                                <option value="1000-5000" {{ request('budget') == '1000-5000' ? 'selected' : '' }}>$1,000 - $5,000</option>
                                <option value="over-5000" {{ request('budget') == 'over-5000' ? 'selected' : '' }}>$5,000+</option>
                            </select>
                        </div>
                    </div>
                </form>
                
                <!-- Job Cards Grid -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($featuredJobs as $job)
                    <!-- Job Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $job->title }}</h3>
                            @if($job->created_at->diffInDays() < 2)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">New</span>
                            @elseif($job->created_at->diffInDays() < 7)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Recent</span>
                            @endif
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-4">
                            {{ Str::limit($job->description, 100) }}
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(array_slice((array)json_decode($job->skills), 0, 3) as $skill)
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">{{ $skill }}</span>
                            @endforeach
                            
                            @if(count((array)json_decode($job->skills)) > 3)
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">+{{ count((array)json_decode($job->skills)) - 3 }} more</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 dark:text-gray-400">
                                {{ $job->currency == 'USD' ? '$' : 'KSH ' }}{{ number_format($job->budget, 0) }}
                                {{ $job->project_type == 'hourly' ? '/hr' : '' }}
                            </span>
                            <span class="text-gray-600 dark:text-gray-400">Posted {{ $job->created_at->diffForHumans() }}</span>
                        </div>
                        
                        @if($job->application_deadline)
                        <div class="mt-2">
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
                        
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('jobs.show', $job->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                                View details <span aria-hidden="true">&rarr;</span>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No jobs found matching your criteria. Try adjusting your filters.</p>
                    </div>
                    @endforelse
                </div>
                
                <!-- View More Button -->
                <div class="mt-8 text-center">
                    <a href="{{ route('jobs.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        View All Jobs
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Categories Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Popular Job Categories</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($categoryStats as $index => $categoryStat)
                @if($index < 8)
                <!-- Category {{ $index + 1 }} -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-{{ ['blue', 'green', 'purple', 'yellow', 'red', 'indigo', 'pink', 'gray'][$index % 8] }}-100 dark:bg-{{ ['blue', 'green', 'purple', 'yellow', 'red', 'indigo', 'pink', 'gray'][$index % 8] }}-900 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-{{ ['blue', 'green', 'purple', 'yellow', 'red', 'indigo', 'pink', 'gray'][$index % 8] }}-600 dark:text-{{ ['blue', 'green', 'purple', 'yellow', 'red', 'indigo', 'pink', 'gray'][$index % 8] }}-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ ['M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4', 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z', 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4'][$index % 8] }}" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">{{ $categoryStat['category'] }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $categoryStat['count'] }} Jobs Available</p>
                    <a href="{{ route('jobs.index', ['category' => $categoryStat['category']]) }}" class="mt-4 inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Explore Jobs →
                    </a>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Clients Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Top Employers</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($activeClients as $client)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="mb-4 mx-auto w-16 h-16 relative">
                        @if($client->profile_picture)
                            <img src="{{ asset('storage/' . $client->profile_picture) }}" alt="{{ $client->name }}" class="rounded-full w-full h-full object-cover border-2 border-blue-500">
                        @else
                            <div class="w-full h-full rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold">
                                {{ substr($client->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="text-md font-semibold mb-1 text-gray-900 dark:text-white">{{ $client->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">
                        {{ $client->company_name ?? 'Employer' }}
                    </p>
                    <a href="{{ route('jobs.index', ['client' => $client->id]) }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                        View Jobs
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        // Function to set category and submit the form
        function setCategory(category) {
            // Update hidden input
            document.getElementById('category-input').value = category;
            
            // Reset all category buttons
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-200', 'dark:bg-gray-600', 'text-gray-800', 'dark:text-white');
            });
            
            // Highlight the selected category button
            const selectedBtn = document.querySelector(`.category-btn[data-category="${category}"]`);
            if (selectedBtn) {
                selectedBtn.classList.remove('bg-gray-200', 'dark:bg-gray-600', 'text-gray-800', 'dark:text-white');
                selectedBtn.classList.add('bg-blue-600', 'text-white');
            }
            
            // Submit the form
            document.getElementById('filter-form').submit();
        }

        // Initialize tooltips or other enhancements
        document.addEventListener('DOMContentLoaded', function() {
            // Add any additional JavaScript functionality here
        });
    </script>
@endsection