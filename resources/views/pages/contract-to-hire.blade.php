@extends('layouts.app')

@section('title', 'Contract-to-Hire | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-teal-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Contract-to-Hire</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Evaluate talent on a contract basis before committing to a full-time role. Reduce hiring risks and ensure the perfect fit.</p>
        <a href="#" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Find Talent (Coming Soon)</a>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Try Before You Buy</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Reduced Risk</h3>
                <p class="text-gray-600 dark:text-gray-400">Assess skills and cultural fit through real-world project work before extending a full-time offer.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Faster Hiring</h3>
                <p class="text-gray-600 dark:text-gray-400">Quickly bring in talent for urgent needs while evaluating them for long-term potential.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Increased Confidence</h3>
                <p class="text-gray-600 dark:text-gray-400">Make informed hiring decisions based on observed performance and fit.</p>
            </div>
        </div>
        <p class="mt-12 text-center text-gray-600 dark:text-gray-400">Contract-to-Hire options are coming soon.</p>
    </div>
</div>
@endsection 