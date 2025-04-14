@extends('layouts.app')

@section('title', 'Enterprise Solutions | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-purple-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Enterprise Suite</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Tailored solutions for large organizations needing advanced control, compliance, and dedicated support for their flexible workforce.</p>
        <a href="#" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Request a Demo (Coming Soon)</a>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Features for Your Enterprise</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Enhanced Security</h3>
                <p class="text-gray-600 dark:text-gray-400">Advanced security protocols and compliance features (e.g., SSO).</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Centralized Management</h3>
                <p class="text-gray-600 dark:text-gray-400">Manage users, projects, and billing from a single dashboard.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Dedicated Support</h3>
                <p class="text-gray-600 dark:text-gray-400">Priority support and a dedicated account manager.</p>
            </div>
        </div>
        <p class="mt-12 text-center text-gray-600 dark:text-gray-400">Enterprise solutions are currently under development.</p>
    </div>
</div>
@endsection 