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
                    
                    <!-- Deadline Reminder -->
                    @php
                        $dueDate = \Carbon\Carbon::parse($task['due_date']);
                        $daysRemaining = $dueDate->diffInDays(now());
                        $isPast = $dueDate->isPast();
                    @endphp
                    
                    <div class="{{ $isPast ? 'bg-red-50 dark:bg-red-900 border-red-400' : ($daysRemaining <= 2 ? 'bg-yellow-50 dark:bg-yellow-900 border-yellow-400' : 'bg-blue-50 dark:bg-blue-900 border-blue-400') }} border-l-4 p-4 mb-5 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                @if($isPast)
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                @elseif($daysRemaining <= 2)
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                @else
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium {{ $isPast ? 'text-red-800 dark:text-red-200' : ($daysRemaining <= 2 ? 'text-yellow-800 dark:text-yellow-200' : 'text-blue-800 dark:text-blue-200') }}">
                                    @if($isPast)
                                        Deadline Passed!
                                    @elseif($daysRemaining == 0)
                                        Deadline is today!
                                    @elseif($daysRemaining == 1)
                                        Deadline is tomorrow!
                                    @else
                                        Deadline Reminder
                                    @endif
                                </h3>
                                <div class="mt-2 text-sm {{ $isPast ? 'text-red-700 dark:text-red-300' : ($daysRemaining <= 2 ? 'text-yellow-700 dark:text-yellow-300' : 'text-blue-700 dark:text-blue-300') }}">
                                    @if($isPast)
                                        <p>This task was due on {{ $dueDate->format('M d, Y') }} ({{ $daysRemaining }} days ago). Please complete your submission as soon as possible.</p>
                                    @else
                                        <p>This task is due on {{ $dueDate->format('M d, Y') }} ({{ $daysRemaining }} days remaining).</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
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
                        
                        <!-- Submission Type Selector -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">How would you like to submit your work?</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-md cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <input type="radio" name="submission_type" value="file" class="mr-2" checked>
                                    <div>
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">File Upload</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Upload documents, images, or other files</div>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-md cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <input type="radio" name="submission_type" value="zip" class="mr-2">
                                    <div>
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">ZIP Archive</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Upload a compressed ZIP file</div>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-md cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <input type="radio" name="submission_type" value="link" class="mr-2">
                                    <div>
                                        <div class="text-sm font-medium text-gray-700 dark:text-gray-300">External Link</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Provide a URL to your work</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- File Upload Section (default) -->
                        <div id="file-upload-section">
                            <label for="work_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Files</label>
                            <div class="mt-1 flex items-center">
                                <label class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Choose files
                                    <input id="work_file" name="work_file[]" type="file" class="sr-only" multiple>
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload completed work files, screenshots, or other deliverables.</p>
                        </div>
                        
                        <!-- ZIP Upload Section (hidden by default) -->
                        <div id="zip-upload-section" class="hidden">
                            <label for="zip_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload ZIP Archive</label>
                            <div class="mt-1 flex items-center">
                                <label class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    Choose ZIP file
                                    <input id="zip_file" name="zip_file" type="file" class="sr-only" accept=".zip,.rar,.7z">
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload a compressed ZIP file containing all your work files.</p>
                        </div>
                        
                        <!-- External Link Section (hidden by default) -->
                        <div id="link-section" class="hidden">
                            <label for="external_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">External Link</label>
                            <input type="url" id="external_link" name="external_link" class="w-full border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="https://example.com/your-work">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Provide a link to your completed work (GitHub, Dropbox, Google Drive, etc.)</p>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submissionTypes = document.querySelectorAll('input[name="submission_type"]');
        const fileSection = document.getElementById('file-upload-section');
        const zipSection = document.getElementById('zip-upload-section');
        const linkSection = document.getElementById('link-section');
        
        submissionTypes.forEach(type => {
            type.addEventListener('change', function() {
                // Hide all sections first
                fileSection.classList.add('hidden');
                zipSection.classList.add('hidden');
                linkSection.classList.add('hidden');
                
                // Show the appropriate section
                if (this.value === 'file') {
                    fileSection.classList.remove('hidden');
                } else if (this.value === 'zip') {
                    zipSection.classList.remove('hidden');
                } else if (this.value === 'link') {
                    linkSection.classList.remove('hidden');
                }
            });
        });
    });
</script>
@endsection