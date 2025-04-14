@extends('layouts.app')

@section('title', 'Hire an Agency | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-blue-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Hire Top Agencies</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Access specialized teams for large-scale projects and ongoing needs. Find vetted agencies with proven track records.</p>
        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Explore Agencies (Coming Soon)</a>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Why Hire an Agency on Ajira?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Expert Teams</h3>
                <p class="text-gray-600 dark:text-gray-400">Access dedicated teams with specialized skills for complex projects.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Verified Quality</h3>
                <p class="text-gray-600 dark:text-gray-400">Work with pre-vetted agencies known for reliability and results.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Scalable Solutions</h3>
                <p class="text-gray-600 dark:text-gray-400">Easily scale your projects up or down based on your business needs.</p>
            </div>
        </div>
        <p class="mt-12 text-center text-gray-600 dark:text-gray-400">Agency hiring features are currently under development.</p>
    </div>
</div>
@endsection 