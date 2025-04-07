@extends('layouts.app')

@section('title', 'Task Workspace | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Task Details Sidebar -->
            <div class="w-full md:w-80 bg-gray-50 dark:bg-gray-750 p-6 border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-700">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $task['title'] }}</h1>
                    <div class="flex items-center mb-3">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mr-2">Client:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $task['client'] }}</span>
                    </div>
                    <div class="flex items-center mb-3">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mr-2">Status:</span>
                        @if($task['status'] === 'in-progress')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">In Progress</span>
                        @elseif($task['status'] === 'pending')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                        @elseif($task['status'] === 'completed')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Completed</span>
                        @endif
                    </div>
                    <div class="flex items-center mb-3">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mr-2">Priority:</span>
                        @if($task['priority'] === 'high')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">High</span>
                        @elseif($task['priority'] === 'medium')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">Medium</span>
                        @elseif($task['priority'] === 'low')
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Low</span>
                        @endif
                    </div>
                    <div class="flex items-center mb-5">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 mr-2">Due Date:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $task['due_date'] }}</span>
                    </div>
                    
                    <div class="mb-5">
                        <div class="flex justify-between mb-1">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Progress</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $task['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $task['progress'] }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Attachments</h2>
                    <div class="space-y-3">
                        @foreach($task['attachments'] as $attachment)
                            <div class="flex items-center p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                <div class="mr-3 text-gray-400">
                                    @if($attachment['type'] === 'application/pdf')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    @elseif($attachment['type'] === 'application/zip')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $attachment['name'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $attachment['size'] }} • {{ \Carbon\Carbon::parse($attachment['uploaded_at'])->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <button type="button" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div>
                    <a href="{{ route('jobseeker.tasks') }}" class="flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Back to Tasks
                    </a>
                </div>
            </div>
            
            <!-- Main Workspace Area -->
            <div class="flex-1 p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Task Description</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-5">{{ $task['description'] }}</p>
                    
                    <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-2">Requirements</h3>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700 dark:text-gray-300">
                        @foreach($task['requirements'] as $requirement)
                            <li>{{ $requirement }}</li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Submit Work</h2>
                    <form action="{{ route('jobseeker.submit-work', $task['id']) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label for="work_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Work Description</label>
                            <textarea id="work_description" name="work_description" rows="4" class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Describe the work you've completed..."></textarea>
                        </div>
                        
                        <div>
                            <label for="hours_worked" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hours Worked</label>
                            <input type="number" id="hours_worked" name="hours_worked" step="0.5" min="0.5" class="border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="0.0">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Enter the number of hours you spent on this task.</p>
                        </div>
                        
                        <div>
                            <label for="work_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Work Files (Optional)</label>
                            <div class="mt-1 flex items-center">
                                <label class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Choose file
                                    <input id="work_file" name="work_file" type="file" class="sr-only">
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload completed work files, screenshots, or other deliverables.</p>
                        </div>
                        
                        <div class="flex items-center justify-between pt-4">
                            <div class="flex items-center">
                                <input id="mark_complete" name="mark_complete" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="mark_complete" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Mark this task as complete</label>
                            </div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Submit Work
                            </button>
                        </div>
                    </form>
                </div>
                
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Messages</h2>
                    <div class="space-y-4 mb-6">
                        @foreach($task['messages'] as $message)
                            <div class="flex {{ $message['sender_type'] === 'job-seeker' ? 'justify-end' : 'justify-start' }}">
                                <div class="{{ $message['sender_type'] === 'job-seeker' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200' }} rounded-lg px-4 py-3 max-w-md">
                                    <div class="font-medium {{ $message['sender_type'] === 'job-seeker' ? 'text-blue-800 dark:text-blue-200' : 'text-gray-900 dark:text-white' }}">{{ $message['sender'] }}</div>
                                    <div class="text-sm mt-1">{{ $message['message'] }}</div>
                                    <div class="text-xs {{ $message['sender_type'] === 'job-seeker' ? 'text-blue-600 dark:text-blue-300' : 'text-gray-500 dark:text-gray-400' }} mt-1">{{ \Carbon\Carbon::parse($message['timestamp'])->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <div class="flex-1">
                            <textarea placeholder="Type your message..." class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" rows="3"></textarea>
                        </div>
                        <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 