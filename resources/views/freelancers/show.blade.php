@extends('layouts.app')

@section('title', "{$freelancer->name} - Freelancer Profile | Ajira Global")

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar / Profile Info -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="p-6 pb-0 text-center">
                    <div class="relative inline-block">
                        @if($freelancer->profile_picture)
                            <img src="{{ asset('storage/' . $freelancer->profile_picture) }}" alt="{{ $freelancer->name }}" class="h-32 w-32 rounded-full object-cover mx-auto">
                        @else
                            <div class="h-32 w-32 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center mx-auto">
                                <svg class="h-16 w-16 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                        
                        @if($freelancer->profile && $freelancer->profile->availability)
                            <span class="absolute bottom-0 right-0 h-5 w-5 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                        @endif
                    </div>
                    
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white mt-4">{{ $freelancer->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $freelancer->profession ?? 'Freelancer' }}</p>
                    
                    @if($freelancer->profile && $freelancer->profile->location)
                        <div class="flex items-center justify-center mt-2 text-gray-500 dark:text-gray-400 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $freelancer->profile->location }}</span>
                        </div>
                    @endif
                </div>
                
                <!-- Contact Button -->
                <div class="px-6 py-4 text-center">
                    <a href="#contact-form" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition duration-150 ease-in-out w-full">
                        Contact {{ $freelancer->name }}
                    </a>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">About</h3>
                    
                    <div class="space-y-4">
                        @if($freelancer->profile && $freelancer->profile->category)
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">{{ $freelancer->profile->category }}</span>
                            </div>
                        @endif
                        
                        @if($freelancer->experience)
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">
                                    @if($freelancer->experience == 'entry')
                                        Entry Level
                                    @elseif($freelancer->experience == 'intermediate')
                                        Intermediate
                                    @elseif($freelancer->experience == 'expert')
                                        Expert
                                    @else
                                        {{ $freelancer->experience }}
                                    @endif
                                </span>
                            </div>
                        @endif
                        
                        @if($freelancer->profile && $freelancer->profile->hourly_rate)
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500 mt-0.5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">
                                    ${{ $freelancer->profile->hourly_rate }} / hour
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Skills -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Skills</h3>
                    
                    <div class="flex flex-wrap gap-2">
                        @if($freelancer->skills && is_array($freelancer->skills) && count($freelancer->skills) > 0)
                            @foreach($freelancer->skills as $skill)
                                <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs px-2.5 py-1 rounded-full">
                                    {{ $skill }}
                                </span>
                            @endforeach
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">No skills listed</p>
                        @endif
                    </div>
                </div>
                
                <!-- Social Links -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Connect</h3>
                    
                    <div class="flex space-x-3">
                        @if($freelancer->github_link)
                            <a href="{{ $freelancer->github_link }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                                <span class="sr-only">GitHub</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                        
                        @if($freelancer->linkedin_link)
                            <a href="{{ $freelancer->linkedin_link }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        @endif
                        
                        @if($freelancer->personal_website)
                            <a href="{{ $freelancer->personal_website }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                                <span class="sr-only">Personal Website</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- About Me Section -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">About Me</h2>
                
                <div class="prose dark:prose-dark max-w-none text-gray-600 dark:text-gray-300">
                    @if($freelancer->bio || ($freelancer->profile && $freelancer->profile->bio))
                        <p>{{ $freelancer->bio ?? $freelancer->profile->bio }}</p>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">This freelancer has not added a bio yet.</p>
                    @endif
                </div>
            </div>
            
            <!-- Portfolio Section -->
            @if($freelancer->profile && $freelancer->profile->portfolio_items && is_array($freelancer->profile->portfolio_items) && count($freelancer->profile->portfolio_items) > 0)
                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Portfolio</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($freelancer->profile->portfolio_items as $item)
                            <div class="group relative bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                                @if(isset($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] ?? 'Portfolio item' }}" class="w-full h-48 object-cover">
                                @endif
                                
                                <div class="p-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $item['title'] ?? 'Untitled Project' }}</h3>
                                    
                                    @if(isset($item['description']))
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($item['description'], 100) }}</p>
                                    @endif
                                    
                                    @if(isset($item['url']))
                                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                                            View Project
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Contact Form Section -->
            <div id="contact-form" class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Contact {{ $freelancer->name }}</h2>
                
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="What is this regarding?" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                        <textarea id="message" name="message" rows="4" placeholder="Describe your project or job opportunity..." class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Similar Freelancers Section -->
    @if(isset($similarFreelancers) && $similarFreelancers->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Similar Freelancers</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarFreelancers as $similar)
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($similar->profile_picture)
                                        <img src="{{ asset('storage/' . $similar->profile_picture) }}" alt="{{ $similar->name }}" class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                        <a href="{{ route('freelancer.show', $similar->username ?? $similar->id) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ $similar->name }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $similar->profession ?? 'Freelancer' }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-2">
                                <a href="{{ route('freelancer.show', $similar->username ?? $similar->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection 