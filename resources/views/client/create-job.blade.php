@extends('layouts.app')

@section('title', 'Post a New Job | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Post a New Job</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Find the perfect talent for your project</p>
    </div>
    
    @if(session('success'))
    <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900 dark:text-green-200" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-900 dark:text-red-200" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job Title -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Title*</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="E.g., WordPress Developer Needed for E-commerce Site" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Job Description -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Description*</label>
                    <textarea id="description" name="description" rows="6" required placeholder="Provide a detailed description of the job requirements, responsibilities, and any specific skills needed..." class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tip: Be specific about deliverables, timeline, and required experience to attract the right candidates.</p>
                </div>
                
                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Category*</label>
                    <select id="category_id" name="category_id" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Job Type -->
                <div>
                    <label for="job_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Type*</label>
                    <select id="job_type" name="job_type" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="contract" {{ old('job_type') == 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="project" {{ old('job_type') == 'project' ? 'selected' : '' }}>One-time Project</option>
                        <option value="part-time" {{ old('job_type') == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="full-time" {{ old('job_type') == 'full-time' ? 'selected' : '' }}>Full-time</option>
                    </select>
                    @error('job_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Skills -->
                <div class="col-span-2">
                    <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Required Skills*</label>
                    <select id="skills" name="skills[]" multiple required class="select2 w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @foreach($skills as $skill)
                        <option value="{{ $skill->id }}" {{ in_array($skill->id, old('skills', [])) ? 'selected' : '' }}>{{ $skill->name }}</option>
                        @endforeach
                    </select>
                    @error('skills')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select up to 10 most relevant skills for this job. Press Enter to select multiple.</p>
                </div>
                
                <hr class="col-span-2 border-gray-200 dark:border-gray-700">
                
                <!-- Budget Section -->
                <div class="col-span-2">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Budget and Timeline</h2>
                </div>
                
                <!-- Rate Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Type*</label>
                    <div class="flex gap-4 mt-2">
                        <div class="flex items-center">
                            <input type="radio" id="fixed" name="rate_type" value="fixed" {{ old('rate_type') == 'fixed' || !old('rate_type') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="fixed" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Fixed Price</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="hourly" name="rate_type" value="hourly" {{ old('rate_type') == 'hourly' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="hourly" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Hourly Rate</label>
                        </div>
                    </div>
                    @error('rate_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Budget -->
                <div class="flex items-center space-x-4">
                    <div class="w-1/4">
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Currency*</label>
                        <select id="currency" name="currency" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="USD" {{ old('currency') == 'USD' || !old('currency') ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget Amount*</label>
                        <input type="number" id="budget" name="budget" value="{{ old('budget') }}" required min="1" step="0.01" placeholder="Enter amount" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('budget')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Duration -->
                <div class="col-span-2 md:col-span-1">
                    <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estimated Duration</label>
                    <select id="duration" name="duration" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Select duration</option>
                        <option value="less_than_1_week" {{ old('duration') == 'less_than_1_week' ? 'selected' : '' }}>Less than 1 week</option>
                        <option value="1_to_2_weeks" {{ old('duration') == '1_to_2_weeks' ? 'selected' : '' }}>1 to 2 weeks</option>
                        <option value="2_to_4_weeks" {{ old('duration') == '2_to_4_weeks' ? 'selected' : '' }}>2 to 4 weeks</option>
                        <option value="1_to_3_months" {{ old('duration') == '1_to_3_months' ? 'selected' : '' }}>1 to 3 months</option>
                        <option value="3_to_6_months" {{ old('duration') == '3_to_6_months' ? 'selected' : '' }}>3 to 6 months</option>
                        <option value="more_than_6_months" {{ old('duration') == 'more_than_6_months' ? 'selected' : '' }}>More than 6 months</option>
                    </select>
                    @error('duration')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Experience Level -->
                <div class="col-span-2 md:col-span-1">
                    <label for="experience_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience Level Required*</label>
                    <select id="experience_level" name="experience_level" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="entry" {{ old('experience_level') == 'entry' ? 'selected' : '' }}>Entry Level</option>
                        <option value="intermediate" {{ old('experience_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="expert" {{ old('experience_level') == 'expert' ? 'selected' : '' }}>Expert</option>
                    </select>
                    @error('experience_level')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <hr class="col-span-2 border-gray-200 dark:border-gray-700">
                
                <!-- Location Section -->
                <div class="col-span-2">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Location and Visibility</h2>
                </div>
                
                <!-- Location Type -->
                <div>
                    <label for="location_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location Type*</label>
                    <select id="location_type" name="location_type" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="remote" {{ old('location_type') == 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="onsite" {{ old('location_type') == 'onsite' ? 'selected' : '' }}>On-site</option>
                        <option value="hybrid" {{ old('location_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('location_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Location -->
                <div class="location-field" style="{{ old('location_type') == 'remote' ? 'display:none' : '' }}">
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location Address</label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="City, State, Country" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @error('location')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Status -->
                <div class="col-span-2">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Status*</label>
                    <select id="status" name="status" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Publish Immediately)</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft (Save for Later)</option>
                    </select>
                    @error('status')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Attachment -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Attachments (Optional)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex justify-center text-sm text-gray-600 dark:text-gray-400">
                                <label for="attachment" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="attachment" name="attachment" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PDF, DOC, DOCX, PPT, PPTX up to 10MB
                            </p>
                            <p id="attachment-name" class="text-sm text-gray-600 dark:text-gray-400 mt-2"></p>
                        </div>
                    </div>
                    @error('attachment')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-8 flex justify-end">
                <a href="{{ route('client.jobs') }}" class="mr-4 inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Post Job
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle location field based on location type
        const locationTypeSelect = document.getElementById('location_type');
        const locationField = document.querySelector('.location-field');
        
        locationTypeSelect.addEventListener('change', function() {
            if (this.value === 'remote') {
                locationField.style.display = 'none';
            } else {
                locationField.style.display = 'block';
            }
        });
        
        // Display file name when selected
        const attachmentInput = document.getElementById('attachment');
        const attachmentName = document.getElementById('attachment-name');
        
        attachmentInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                attachmentName.textContent = 'Selected file: ' + this.files[0].name;
            } else {
                attachmentName.textContent = '';
            }
        });
        
        // Initialize Select2 for skills multi-select if available
        if (typeof($.fn.select2) !== 'undefined') {
            $('.select2').select2({
                theme: 'classic',
                placeholder: 'Select skills required for this job',
                maximumSelectionLength: 10
            });
        }
    });
</script>
@endsection 