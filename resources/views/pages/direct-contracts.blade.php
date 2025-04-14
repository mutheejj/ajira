@extends('layouts.app')

@section('title', 'Direct Contracts | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-cyan-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Direct Contracts</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Engage directly with freelancers or agencies you already know. Simplify contracts and payments while leveraging Ajira's platform.</p>
        <a href="#" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Create Contract (Coming Soon)</a>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Work Directly, Pay Securely</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-2M8 5V3m4 4V3m4 4V3M4 11h16M9 16h6"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Simplified Contracts</h3>
                <p class="text-gray-600 dark:text-gray-400">Easily create and manage contracts with your chosen talent, all in one place.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0c1.657 0 3-.895 3-2s-1.343-2-3-2-3-.895-3-2 1.343-2 3-2m-1.999 1H10m4 0h.001M12 19a7 7 0 100-14 7 7 0 000 14z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Secure Escrow Payments</h3>
                <p class="text-gray-600 dark:text-gray-400">Utilize Ajira's secure payment system and escrow protection for peace of mind.</p>
            </div>
            <div>
                <svg class="w-12 h-12 mx-auto mb-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Clear Communication</h3>
                <p class="text-gray-600 dark:text-gray-400">Keep all project communication and files organized within the platform.</p>
            </div>
        </div>
        <p class="mt-12 text-center text-gray-600 dark:text-gray-400">Direct Contracts features are under development.</p>
    </div>
</div>
@endsection 