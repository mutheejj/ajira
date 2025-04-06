@extends('layouts.app')

@section('title', 'Post a New Job | Ajira Global')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Custom styling for Select2 */
    .select2-container--default .select2-selection--multiple {
        border-color: rgb(209, 213, 219);
        border-radius: 0.375rem;
    }
    .dark .select2-container--default .select2-selection--multiple {
        background-color: rgb(55, 65, 81);
        border-color: rgb(75, 85, 99);
    }
    .dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: rgb(75, 85, 99);
        color: white;
        border-color: rgb(107, 114, 128);
    }
    .dark .select2-dropdown {
        background-color: rgb(55, 65, 81);
        color: white;
    }
    .dark .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: rgb(75, 85, 99);
    }
    .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: rgb(79, 70, 229);
    }
</style>
@endsection

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
        <form action="{{ route('client.store-job') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Category*</label>
                    <select id="category" name="category" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Select a category</option>
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ old('category') == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        @else
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile Development">Mobile Development</option>
                            <option value="UI/UX Design">UI/UX Design</option>
                            <option value="Graphic Design">Graphic Design</option>
                            <option value="Content Writing">Content Writing</option>
                            <option value="Digital Marketing">Digital Marketing</option>
                            <option value="SEO">SEO</option>
                            <option value="Data Science">Data Science</option>
                            <option value="Project Management">Project Management</option>
                            <option value="Virtual Assistance">Virtual Assistance</option>
                            <option value="Video Production">Video Production</option>
                        @endif
                    </select>
                    @error('category')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Job Type -->
                <div>
                    <label for="job_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Type*</label>
                    <select id="job_type" name="job_type" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="one-time" {{ old('job_type') == 'one-time' ? 'selected' : '' }}>One-time Project</option>
                        <option value="ongoing" {{ old('job_type') == 'ongoing' ? 'selected' : '' }}>Ongoing Work</option>
                    </select>
                    @error('job_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Skills -->
                <div class="col-span-2">
                    <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Required Skills*</label>
                    <select id="skills" name="skills[]" multiple required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @if(isset($skills) && count($skills) > 0)
                            @foreach($skills as $skill)
                                <option value="{{ $skill->name }}" {{ in_array($skill->name, old('skills', [])) ? 'selected' : '' }}>{{ $skill->name }}</option>
                            @endforeach
                        @else
                            <option value="HTML">HTML</option>
                            <option value="CSS">CSS</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="React">React</option>
                            <option value="Vue.js">Vue.js</option>
                            <option value="Angular">Angular</option>
                            <option value="Node.js">Node.js</option>
                            <option value="Python">Python</option>
                            <option value="Django">Django</option>
                            <option value="PHP">PHP</option>
                            <option value="Laravel">Laravel</option>
                            <option value="WordPress">WordPress</option>
                            <option value="Shopify">Shopify</option>
                            <option value="Swift">Swift</option>
                            <option value="Kotlin">Kotlin</option>
                            <option value="iOS">iOS</option>
                            <option value="Android">Android</option>
                            <option value="Flutter">Flutter</option>
                            <option value="React Native">React Native</option>
                            <option value="UI Design">UI Design</option>
                            <option value="UX Design">UX Design</option>
                            <option value="Figma">Figma</option>
                            <option value="Adobe XD">Adobe XD</option>
                            <option value="Photoshop">Photoshop</option>
                            <option value="Copywriting">Copywriting</option>
                            <option value="Content Writing">Content Writing</option>
                            <option value="SEO Writing">SEO Writing</option>
                            <option value="Technical Writing">Technical Writing</option>
                            <option value="Blogging">Blogging</option>
                            <option value="Social Media Marketing">Social Media Marketing</option>
                            <option value="Email Marketing">Email Marketing</option>
                            <option value="PPC">PPC</option>
                            <option value="Google Ads">Google Ads</option>
                            <option value="Facebook Ads">Facebook Ads</option>
                            <option value="Data Analysis">Data Analysis</option>
                            <option value="Machine Learning">Machine Learning</option>
                            <option value="SQL">SQL</option>
                            <option value="Project Management">Project Management</option>
                            <option value="Scrum">Scrum</option>
                            <option value="Agile">Agile</option>
                        @endif
                    </select>
                    @error('skills')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Select the most relevant skills for this job. You can select multiple options.</p>
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
                            <option value="KES" {{ old('currency') == 'KES' ? 'selected' : '' }}>KES</option>
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
                        <option value="on-site" {{ old('location_type') == 'on-site' ? 'selected' : '' }}>On-site</option>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for skills multi-select
        try {
            $('#skills').select2({
                placeholder: 'Select skills required for this job',
                allowClear: true,
                tags: true,
                width: '100%',
                dropdownParent: $('body')
            });
        } catch (error) {
            console.error('Error initializing Select2:', error);
        }
        
        // Toggle location field based on location type
        const locationTypeSelect = document.getElementById('location_type');
        const locationField = document.querySelector('.location-field');
        
        if (locationTypeSelect && locationField) {
            // Initial state
            if (locationTypeSelect.value === 'remote') {
                locationField.style.display = 'none';
            } else {
                locationField.style.display = 'block';
            }
            
            // On change
            locationTypeSelect.addEventListener('change', function() {
                if (this.value === 'remote') {
                    locationField.style.display = 'none';
                } else {
                    locationField.style.display = 'block';
                }
            });
        }
        
        // Display file name when selected
        const attachmentInput = document.getElementById('attachment');
        const attachmentName = document.getElementById('attachment-name');
        
        if (attachmentInput && attachmentName) {
            attachmentInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    attachmentName.textContent = 'Selected file: ' + this.files[0].name;
                } else {
                    attachmentName.textContent = '';
                }
            });
        }
    });
</script>
@endsection 