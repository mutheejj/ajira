@extends('layouts.app')

@section('title', 'Work Log | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Job Seeker</p>
                </div>
            </div>
            
            <nav class="space-y-1">
                <a href="{{ route('jobseeker.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('applications.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0019.414 6L15 1.586A2 2 0 0013.586 1H10a2 2 0 00-2 2zm7 2l3 3v1h-4V4h1zm-2 12H5V4h5v3a2 2 0 002 2h3v7z" clip-rule="evenodd" />
                    </svg>
                    My Applications
                </a>
                <a href="{{ route('saved-jobs.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                    </svg>
                    Saved Jobs
                </a>
                <a href="{{ route('jobs.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Find Jobs
                </a>
                <a href="{{ route('jobseeker.tasks') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                    Active Tasks
                </a>
                <a href="{{ route('jobseeker.worklog') }}" class="flex items-center px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-md font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    Work Log
                </a>
                <a href="{{ route('wallet.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                    Wallet
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                    </svg>
                    Profile Settings
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Work Log</h1>
                    <div class="mt-4 md:mt-0">
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="add-work-entry-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Work Entry
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">Total Hours</h3>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalHours }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">Avg Hours/Day</h3>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $averageHoursPerDay }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200">Projects</h3>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ $workLogs->pluck('task')->unique()->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Work Entries</h2>
                    <div class="mt-4 md:mt-0 flex flex-col sm:flex-row gap-3">
                        <div class="relative">
                            <select class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-md px-3 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="all">All Projects</option>
                                @foreach($workLogs->pluck('task')->unique() as $project)
                                    <option value="{{ $project }}">{{ $project }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="relative">
                            <input type="date" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-sm">
                            <tr>
                                <th class="py-3 px-4 text-left font-medium">Date</th>
                                <th class="py-3 px-4 text-left font-medium">Task</th>
                                <th class="py-3 px-4 text-left font-medium">Client</th>
                                <th class="py-3 px-4 text-left font-medium">Hours</th>
                                <th class="py-3 px-4 text-left font-medium">Description</th>
                                <th class="py-3 px-4 text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($workLogs as $log)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-300">{{ $log['date'] }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $log['task'] }}</div>
                                </td>
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-300">{{ $log['client'] }}</td>
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-300">{{ $log['hours'] }}</td>
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                    {{ $log['description'] }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if(count($workLogs) === 0)
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">No work entries found.</p>
                    <p class="text-gray-500 dark:text-gray-500">Start tracking your work time by adding your first entry.</p>
                </div>
                @endif
                
                <div class="mt-6 flex justify-end">
                    <button type="button" class="px-5 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Export Time Report
                    </button>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Weekly Hours Overview</h2>
                
                <div class="w-full h-64 mb-6">
                    <!-- Chart placeholder - in a real app, you'd implement a chart here using Chart.js or similar -->
                    <div class="w-full h-full flex items-center justify-center bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex flex-col items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="mt-2 text-gray-500 dark:text-gray-400">Chart would display weekly hours worked here</p>
                        </div>
                    </div>
                </div>
                
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Work Distribution</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-2">By Project</h4>
                        <div class="space-y-2">
                            @php
                                $projects = [];
                                $totalHoursForProjects = $workLogs->sum('hours');
                                
                                foreach($workLogs->pluck('task')->unique() as $project) {
                                    $projectHours = $workLogs->where('task', $project)->sum('hours');
                                    $percentage = $totalHoursForProjects > 0 ? round(($projectHours / $totalHoursForProjects) * 100) : 0;
                                    $projects[] = [
                                        'name' => $project,
                                        'hours' => $projectHours,
                                        'percentage' => $percentage
                                    ];
                                }
                            @endphp
                            
                            @foreach($projects as $project)
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $project['name'] }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $project['hours'] }} hrs ({{ $project['percentage'] }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $project['percentage'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 dark:text-gray-200 mb-2">By Client</h4>
                        <div class="space-y-2">
                            @php
                                $clients = [];
                                $totalHoursForClients = $workLogs->sum('hours');
                                
                                foreach($workLogs->pluck('client')->unique() as $client) {
                                    $clientHours = $workLogs->where('client', $client)->sum('hours');
                                    $percentage = $totalHoursForClients > 0 ? round(($clientHours / $totalHoursForClients) * 100) : 0;
                                    $clients[] = [
                                        'name' => $client,
                                        'hours' => $clientHours,
                                        'percentage' => $percentage
                                    ];
                                }
                            @endphp
                            
                            @foreach($clients as $client)
                                <div>
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $client['name'] }}</span>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $client['hours'] }} hrs ({{ $client['percentage'] }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $client['percentage'] }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Work Entry Modal (hidden by default) -->
<div id="add-work-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-lg max-w-md w-full p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add Work Entry</h3>
            
            <form>
                <div class="mb-4">
                    <label for="task" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project/Task</label>
                    <select id="task" name="task" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-200">
                        <option value="">Select a project</option>
                        @foreach($workLogs->pluck('task')->unique() as $task)
                            <option value="{{ $task }}">{{ $task }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-200">
                </div>
                
                <div class="mb-4">
                    <label for="hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hours Worked</label>
                    <input type="number" id="hours" name="hours" step="0.5" min="0.5" max="24" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-200">
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700 dark:text-gray-200" placeholder="Describe the work you did..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" onclick="closeModal()">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Save Entry
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addEntryButton = document.querySelector('button:contains("Add Work Entry")');
        const modal = document.getElementById('add-work-modal');
        
        // Workaround for the :contains selector since it's not standard
        document.querySelectorAll('button').forEach(button => {
            if (button.textContent.includes('Add Work Entry')) {
                button.addEventListener('click', openModal);
            }
        });
        
        function openModal() {
            modal.classList.remove('hidden');
        }
        
        window.closeModal = function() {
            modal.classList.add('hidden');
        }
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>
@endsection 