@extends('layouts.app')

@section('title', 'Apply for ' . $jobPost->title . ' | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="bg-blue-600 dark:bg-blue-700 px-6 py-4">
            <h1 class="text-xl font-bold text-white">Apply for Job</h1>
        </div>
        
        <div class="p-6">
            <div class="mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $jobPost->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                            <span class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                {{ $jobPost->location_type }} 
                                @if($jobPost->location)
                                - {{ $jobPost->location }}
                                @endif
                            </span>
                        </p>
                    </div>
                    <div>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full text-sm font-medium">
                            {{ ucfirst($jobPost->job_type) }}
                        </span>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="prose dark:prose-invert max-w-none mb-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit($jobPost->description, 200) }}
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach(json_decode($jobPost->skills) as $skill)
                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs rounded-full">
                            {{ $skill }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('applications.store', $jobPost->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="cover_letter" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cover Letter</label>
                    <div class="mt-1">
                        <textarea id="cover_letter" name="cover_letter" rows="6" required
                            class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('cover_letter') border-red-500 @enderror"
                            placeholder="Introduce yourself and explain why you're a good fit for this job. Be specific about your skills and experience relevant to this project.">{{ old('cover_letter') }}</textarea>
                    </div>
                    @error('cover_letter')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Write a personalized message to the client explaining why you're perfect for this job.</p>
                </div>
                
                <div>
                    <label for="bid_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Your Bid</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">
                                {{ $jobPost->currency }}
                            </span>
                        </div>
                        <input type="number" name="bid_amount" id="bid_amount" 
                            min="{{ $jobPost->budget * 0.5 }}" max="{{ $jobPost->budget * 2 }}" 
                            value="{{ old('bid_amount', $jobPost->budget) }}" step="0.01" required
                            class="block w-full pl-12 pr-12 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('bid_amount') border-red-500 @enderror">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            @if($jobPost->rate_type === 'hourly')
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">/hr</span>
                            @endif
                        </div>
                    </div>
                    @error('bid_amount')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="estimated_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estimated Duration</label>
                    <select id="estimated_duration" name="estimated_duration" required
                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('estimated_duration') border-red-500 @enderror">
                        <option value="">Select Estimated Duration</option>
                        <option value="Less than 1 week" {{ old('estimated_duration') == 'Less than 1 week' ? 'selected' : '' }}>Less than 1 week</option>
                        <option value="1-2 weeks" {{ old('estimated_duration') == '1-2 weeks' ? 'selected' : '' }}>1-2 weeks</option>
                        <option value="2-4 weeks" {{ old('estimated_duration') == '2-4 weeks' ? 'selected' : '' }}>2-4 weeks</option>
                        <option value="1-3 months" {{ old('estimated_duration') == '1-3 months' ? 'selected' : '' }}>1-3 months</option>
                        <option value="3-6 months" {{ old('estimated_duration') == '3-6 months' ? 'selected' : '' }}>3-6 months</option>
                        <option value="More than 6 months" {{ old('estimated_duration') == 'More than 6 months' ? 'selected' : '' }}>More than 6 months</option>
                    </select>
                    @error('estimated_duration')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Attachment (Optional)</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="attachment" name="attachment" 
                            class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <label for="attachment" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer transition-colors">
                            Choose File
                        </label>
                        <span id="file-name" class="ml-3 text-sm text-gray-500 dark:text-gray-400">No file chosen</span>
                    </div>
                    @error('attachment')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload a relevant portfolio sample, proposal document, or resume (Max: 5MB).</p>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-5">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('jobs.show', $jobPost->id) }}" 
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Submit Application
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('attachment');
        const fileNameSpan = document.getElementById('file-name');
        
        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameSpan.textContent = this.files[0].name;
            } else {
                fileNameSpan.textContent = 'No file chosen';
            }
        });
    });
</script>
@endsection 