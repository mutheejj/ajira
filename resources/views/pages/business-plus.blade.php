@extends('layouts.app')

@section('title', 'Business Plus | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-indigo-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Business Plus</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Upgrade your hiring experience with advanced tools, team collaboration features, and insights for growing businesses.</p>
        <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Learn More (Coming Soon)</a>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Unlock Premium Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Team Collaboration</h3>
                <p class="text-gray-600 dark:text-gray-400">Invite team members, share candidate pools, and manage hiring together.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Advanced Reporting</h3>
                <p class="text-gray-600 dark:text-gray-400">Gain insights into hiring trends, spending, and team performance.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.364 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.364-1.118L2.98 9.11c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Premium Support</h3>
                <p class="text-gray-600 dark:text-gray-400">Get faster response times and prioritized support assistance.</p>
            </div>
        </div>
        <p class="mt-12 text-center text-gray-600 dark:text-gray-400">Business Plus features are coming soon.</p>
    </div>
</div>
@endsection 