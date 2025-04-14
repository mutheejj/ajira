@extends('layouts.app')

@section('title', 'Project Catalog | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-green-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Browse Pre-Defined Projects</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Get started quickly with fixed-price projects offered by talented freelancers. Clear scope, defined deliverables.</p>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Example Project Card 1 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                <img src="https://via.placeholder.com/400x250/34D399/FFFFFF?text=Logo+Design" alt="Project Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Professional Logo Design Package</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Get a unique and memorable logo with 3 concepts and revisions.</p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-300 mb-4">
                        <span>Starting at</span>
                        <span class="ml-1 font-bold text-green-600 dark:text-green-400">$250</span>
                    </div>
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View Details</a>
                </div>
            </div>
            <!-- Example Project Card 2 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                <img src="https://via.placeholder.com/400x250/60A5FA/FFFFFF?text=WordPress+Site" alt="Project Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Basic WordPress Website Setup</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">5-page responsive website with basic SEO and contact form.</p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-300 mb-4">
                        <span>Starting at</span>
                        <span class="ml-1 font-bold text-green-600 dark:text-green-400">$500</span>
                    </div>
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View Details</a>
                </div>
            </div>
            <!-- Example Project Card 3 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                <img src="https://via.placeholder.com/400x250/FBBF24/FFFFFF?text=Social+Media" alt="Project Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Social Media Content Pack (Monthly)</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">12 custom graphics and captions for your social channels.</p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-300 mb-4">
                        <span>Starting at</span>
                        <span class="ml-1 font-bold text-green-600 dark:text-green-400">$300/mo</span>
                    </div>
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View Details</a>
                </div>
            </div>
            <!-- Add more project cards as needed -->
            <!-- Example Project Card 4 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                <img src="https://via.placeholder.com/400x250/EC4899/FFFFFF?text=Content+Writing" alt="Project Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Blog Post Writing (5 Pack)</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Five SEO-optimized blog posts (500 words each) on topics of your choice.</p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-300 mb-4">
                        <span>Starting at</span>
                        <span class="ml-1 font-bold text-green-600 dark:text-green-400">$400</span>
                    </div>
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View Details</a>
                </div>
            </div>
            <!-- Example Project Card 5 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                <img src="https://via.placeholder.com/400x250/8B5CF6/FFFFFF?text=Video+Editing" alt="Project Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Basic Video Editing Service</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Editing for up to 5 minutes of raw footage, including cuts, transitions, and basic color correction.</p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-300 mb-4">
                        <span>Starting at</span>
                        <span class="ml-1 font-bold text-green-600 dark:text-green-400">$150</span>
                    </div>
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View Details</a>
                </div>
            </div>
            <!-- Example Project Card 6 -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                <img src="https://via.placeholder.com/400x250/F59E0B/FFFFFF?text=Data+Entry" alt="Project Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Data Entry Assistance (10 Hours)</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">10 hours of accurate data entry, web research, or file conversion tasks.</p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-300 mb-4">
                        <span>Starting at</span>
                        <span class="ml-1 font-bold text-green-600 dark:text-green-400">$100</span>
                    </div>
                    <a href="#" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">View Details</a>
                </div>
            </div>
        </div>
        <p class="mt-12 text-center text-gray-600 dark:text-gray-400">Project Catalog feature coming soon!</p>
    </div>
</div>
@endsection 