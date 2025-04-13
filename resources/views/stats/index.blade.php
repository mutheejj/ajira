@extends('layouts.app')

@section('title', 'Platform Statistics | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-center mb-10 text-gray-900 dark:text-white">Ajira Global Platform Statistics</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- User Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-t-4 border-blue-500">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-200 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Users</h2>
            </div>
            <div class="space-y-3 text-gray-600 dark:text-gray-300">
                <p class="flex justify-between"><span>Total Users:</span> <span class="font-bold text-lg">{{ number_format($stats['total_users']) }}</span></p>
                <p class="flex justify-between"><span>Clients:</span> <span class="font-bold text-lg">{{ number_format($stats['total_clients']) }}</span></p>
                <p class="flex justify-between"><span>Job Seekers:</span> <span class="font-bold text-lg">{{ number_format($stats['total_job_seekers']) }}</span></p>
            </div>
        </div>

        <!-- Job Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-t-4 border-green-500">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-200 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Jobs</h2>
            </div>
            <div class="space-y-3 text-gray-600 dark:text-gray-300">
                <p class="flex justify-between"><span>Total Jobs Posted:</span> <span class="font-bold text-lg">{{ number_format($stats['total_jobs']) }}</span></p>
                <p class="flex justify-between"><span>Active Jobs:</span> <span class="font-bold text-lg">{{ number_format($stats['active_jobs']) }}</span></p>
                <p class="flex justify-between"><span>Completed Jobs:</span> <span class="font-bold text-lg">{{ number_format($stats['completed_jobs']) }}</span></p>
            </div>
        </div>

        <!-- Application Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-t-4 border-yellow-500">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-200 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Applications</h2>
            </div>
            <div class="space-y-3 text-gray-600 dark:text-gray-300">
                <p class="flex justify-between"><span>Total Applications:</span> <span class="font-bold text-lg">{{ number_format($stats['total_applications']) }}</span></p>
            </div>
        </div>

        <!-- Contract Statistics (Optional) -->
        @if(isset($stats['total_contracts']))
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-t-4 border-purple-500">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-200 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Contracts</h2>
            </div>
            <div class="space-y-3 text-gray-600 dark:text-gray-300">
                <p class="flex justify-between"><span>Total Contracts:</span> <span class="font-bold text-lg">{{ number_format($stats['total_contracts']) }}</span></p>
                <!-- Add more contract stats if available -->
            </div>
        </div>
        @endif

        <!-- Earnings Statistics (Placeholder) -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-t-4 border-teal-500">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-teal-100 dark:bg-teal-900 text-teal-600 dark:text-teal-200 mr-4">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-200">Earnings (Placeholder)</h2>
            </div>
            <div class="space-y-3 text-gray-600 dark:text-gray-300">
                <p class="flex justify-between"><span>Total Value Transacted:</span> <span class="font-bold text-lg">{{ number_format($stats['total_earnings']) }}</span></p>
                <p class="text-sm italic">(Note: Earnings data is currently a placeholder)</p>
            </div>
        </div>

    </div>

</div>
@endsection 