@extends('layouts.app')

@section('title', 'How to Hire | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-blue-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">How to Hire on Ajira</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">A comprehensive guide to finding and hiring the perfect talent for your projects.</p>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Getting Started</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">Begin your hiring journey by creating a detailed job post that attracts the right candidates. Be specific about your requirements and expectations.</p>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-gray-600 dark:text-gray-300">Create a clear job description</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-gray-600 dark:text-gray-300">Set your budget and timeline</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-gray-600 dark:text-gray-300">Define required skills and experience</span>
                    </li>
                </ul>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-lg">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Quick Tips</h3>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-600 dark:text-gray-300">Be specific about project scope and deliverables</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-600 dark:text-gray-300">Include examples of similar projects if possible</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-gray-600 dark:text-gray-300">Specify communication preferences and time zone requirements</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Find Talent</h3>
                <p class="text-gray-600 dark:text-gray-400">Browse through our extensive pool of skilled professionals and agencies.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Review Proposals</h3>
                <p class="text-gray-600 dark:text-gray-400">Evaluate candidate proposals and portfolios to find the best match.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Hire & Collaborate</h3>
                <p class="text-gray-600 dark:text-gray-400">Start working with your chosen talent and manage the project efficiently.</p>
            </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8 mb-16">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Best Practices</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">For Clients</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 dark:text-gray-300">Provide clear project requirements and expectations</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 dark:text-gray-300">Set realistic timelines and milestones</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 dark:text-gray-300">Maintain regular communication</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">For Freelancers</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 dark:text-gray-300">Submit detailed and relevant proposals</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 dark:text-gray-300">Showcase your best work in your portfolio</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-1 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-gray-600 dark:text-gray-300">Be responsive and professional</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Ready to Start Hiring?</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-8">Join thousands of businesses that have found success on Ajira.</p>
            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Get Started</a>
        </div>
    </div>
</div>
@endsection 