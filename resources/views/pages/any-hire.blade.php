@extends('layouts.app')

@section('title', 'Any Hire | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-pink-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Any Hire</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Found talent outside Ajira? Easily onboard, manage, and pay them compliantly through our platform.</p>
        <a href="#" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Start Onboarding (Coming Soon)</a>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Bring Your Talent Here</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Simplified Onboarding</h3>
                <p class="text-gray-600 dark:text-gray-400">Streamline the process of bringing your existing talent onto the Ajira platform.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5h2m-2 2h2m-4-2h2m-2 2h2"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Consolidated Payments</h3>
                <p class="text-gray-600 dark:text-gray-400">Manage all your talent payments, whether sourced on Ajira or off, in one place.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Compliance Assurance</h3>
                <p class="text-gray-600 dark:text-gray-400">Ensure proper classification and compliant payments for all your freelancers.</p>
            </div>
        </div>
        <p class="mt-12 text-center text-gray-600 dark:text-gray-400">Any Hire features are currently under development.</p>
    </div>
</div>
@endsection 