@extends('layouts.app')

@section('title', 'Edit Job: ' . $jobPost->title . ' | Ajira Global')

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
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Job</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Update your job posting</p>
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
        <form action="{{ route('client.jobs.update', $jobPost->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Job Title -->
                <div class="col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Title*</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $jobPost->title) }}" required placeholder="E.g., WordPress Developer Needed for E-commerce Site" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Job Description -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Description*</label>
                    <textarea id="description" name="description" rows="6" required placeholder="Provide a detailed description of the job requirements, responsibilities, and any specific skills needed..." class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description', $jobPost->description) }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tip: Be specific about deliverables, timeline, and required experience to attract the right candidates.</p>
                    <input type="hidden" id="requirements" name="requirements" value="{{ old('description', $jobPost->requirements) }}">
                </div>
                
                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Category*</label>
                    <select id="category" name="category" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="">Select a category</option>
                        @if(isset($categories) && count($categories) > 0)
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ old('category', $jobPost->category) == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        @else
                            <option value="Web Development" {{ old('category', $jobPost->category) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                            <option value="Mobile Development" {{ old('category', $jobPost->category) == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                            <option value="UI/UX Design" {{ old('category', $jobPost->category) == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                            <option value="Graphic Design" {{ old('category', $jobPost->category) == 'Graphic Design' ? 'selected' : '' }}>Graphic Design</option>
                            <option value="Content Writing" {{ old('category', $jobPost->category) == 'Content Writing' ? 'selected' : '' }}>Content Writing</option>
                            <option value="Digital Marketing" {{ old('category', $jobPost->category) == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                            <option value="SEO" {{ old('category', $jobPost->category) == 'SEO' ? 'selected' : '' }}>SEO</option>
                            <option value="Data Science" {{ old('category', $jobPost->category) == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                            <option value="Project Management" {{ old('category', $jobPost->category) == 'Project Management' ? 'selected' : '' }}>Project Management</option>
                            <option value="Virtual Assistance" {{ old('category', $jobPost->category) == 'Virtual Assistance' ? 'selected' : '' }}>Virtual Assistance</option>
                            <option value="Video Production" {{ old('category', $jobPost->category) == 'Video Production' ? 'selected' : '' }}>Video Production</option>
                        @endif
                    </select>
                    @error('category')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Job Type -->
                <div>
                    <label for="project_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Type*</label>
                    <select id="project_type" name="project_type" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="one-time" {{ old('project_type', $jobPost->project_type) == 'one-time' ? 'selected' : '' }}>One-time Project</option>
                        <option value="ongoing" {{ old('project_type', $jobPost->project_type) == 'ongoing' ? 'selected' : '' }}>Ongoing Work</option>
                    </select>
                    @error('project_type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Skills -->
                <div class="col-span-2">
                    <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Required Skills*</label>
                    <select id="skills" name="skills[]" multiple required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @php
                            $currentSkills = old('skills', $jobPost->skills ?? []);
                            if (is_string($currentSkills)) {
                                $currentSkills = json_decode($currentSkills);
                            }
                        @endphp
                        
                        @if(isset($skills) && count($skills) > 0)
                            @foreach($skills as $skill)
                                <option value="{{ $skill->name }}" {{ in_array($skill->name, $currentSkills) ? 'selected' : '' }}>{{ $skill->name }}</option>
                            @endforeach
                        @else
                            <option value="HTML" {{ in_array('HTML', $currentSkills) ? 'selected' : '' }}>HTML</option>
                            <option value="CSS" {{ in_array('CSS', $currentSkills) ? 'selected' : '' }}>CSS</option>
                            <option value="JavaScript" {{ in_array('JavaScript', $currentSkills) ? 'selected' : '' }}>JavaScript</option>
                            <option value="React" {{ in_array('React', $currentSkills) ? 'selected' : '' }}>React</option>
                            <option value="Vue.js" {{ in_array('Vue.js', $currentSkills) ? 'selected' : '' }}>Vue.js</option>
                            <option value="Angular" {{ in_array('Angular', $currentSkills) ? 'selected' : '' }}>Angular</option>
                            <option value="Node.js" {{ in_array('Node.js', $currentSkills) ? 'selected' : '' }}>Node.js</option>
                            <option value="Python" {{ in_array('Python', $currentSkills) ? 'selected' : '' }}>Python</option>
                            <option value="Django" {{ in_array('Django', $currentSkills) ? 'selected' : '' }}>Django</option>
                            <option value="PHP" {{ in_array('PHP', $currentSkills) ? 'selected' : '' }}>PHP</option>
                            <option value="Laravel" {{ in_array('Laravel', $currentSkills) ? 'selected' : '' }}>Laravel</option>
                            <option value="WordPress" {{ in_array('WordPress', $currentSkills) ? 'selected' : '' }}>WordPress</option>
                            <option value="Shopify" {{ in_array('Shopify', $currentSkills) ? 'selected' : '' }}>Shopify</option>
                            <option value="Swift" {{ in_array('Swift', $currentSkills) ? 'selected' : '' }}>Swift</option>
                            <option value="Kotlin" {{ in_array('Kotlin', $currentSkills) ? 'selected' : '' }}>Kotlin</option>
                            <option value="iOS" {{ in_array('iOS', $currentSkills) ? 'selected' : '' }}>iOS</option>
                            <option value="Android" {{ in_array('Android', $currentSkills) ? 'selected' : '' }}>Android</option>
                            <option value="Flutter" {{ in_array('Flutter', $currentSkills) ? 'selected' : '' }}>Flutter</option>
                            <option value="React Native" {{ in_array('React Native', $currentSkills) ? 'selected' : '' }}>React Native</option>
                            <option value="UI Design" {{ in_array('UI Design', $currentSkills) ? 'selected' : '' }}>UI Design</option>
                            <option value="UX Design" {{ in_array('UX Design', $currentSkills) ? 'selected' : '' }}>UX Design</option>
                            <option value="Figma" {{ in_array('Figma', $currentSkills) ? 'selected' : '' }}>Figma</option>
                            <option value="Adobe XD" {{ in_array('Adobe XD', $currentSkills) ? 'selected' : '' }}>Adobe XD</option>
                            <option value="Photoshop" {{ in_array('Photoshop', $currentSkills) ? 'selected' : '' }}>Photoshop</option>
                            <option value="Copywriting" {{ in_array('Copywriting', $currentSkills) ? 'selected' : '' }}>Copywriting</option>
                            <option value="Content Writing" {{ in_array('Content Writing', $currentSkills) ? 'selected' : '' }}>Content Writing</option>
                            <option value="SEO Writing" {{ in_array('SEO Writing', $currentSkills) ? 'selected' : '' }}>SEO Writing</option>
                            <option value="Technical Writing" {{ in_array('Technical Writing', $currentSkills) ? 'selected' : '' }}>Technical Writing</option>
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
                
                <!-- Experience Level -->
                <div>
                    <label for="experience_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience Level*</label>
                    <select id="experience_level" name="experience_level" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        <option value="entry" {{ old('experience_level', $jobPost->experience_level) == 'entry' ? 'selected' : '' }}>Entry Level</option>
                        <option value="intermediate" {{ old('experience_level', $jobPost->experience_level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="expert" {{ old('experience_level', $jobPost->experience_level) == 'expert' ? 'selected' : '' }}>Expert</option>
                    </select>
                    @error('experience_level')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Budget -->
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget*</label>
                    <div class="flex">
                        <select id="currency" name="currency" class="inline-flex w-20 rounded-l-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="USD" {{ old('currency', $jobPost->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ old('currency', $jobPost->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ old('currency', $jobPost->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                        </select>
                        <input type="number" step="0.01" min="0" id="budget" name="budget" value="{{ old('budget', $jobPost->budget) }}" required placeholder="100.00" class="flex-1 rounded-r-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                    @error('budget')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Location Option -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location Preference*</label>
                    <div class="flex gap-4 mt-2">
                        <div class="flex items-center">
                            <input type="radio" id="remote" name="remote_work" value="1" {{ old('remote_work', $jobPost->remote_work) == 1 ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="remote" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Remote</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="onsite" name="remote_work" value="0" {{ old('remote_work', $jobPost->remote_work) == 0 ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <label for="onsite" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Onsite</label>
                        </div>
                    </div>
                    @error('remote_work')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Location Field (conditionally shown) -->
                <div id="location-field" class="{{ old('remote_work', $jobPost->remote_work) == 0 ? '' : 'hidden' }}">
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location*</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $jobPost->location) }}" placeholder="City, Country" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    @error('location')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="col-span-2 flex justify-end mt-4">
                    <a href="{{ route('jobs.show', $jobPost->id) }}" class="px-4 py-2 mr-2 text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Update Job
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for skills
        $('#skills').select2({
            tags: true,
            placeholder: "Select required skills",
            allowClear: true
        });
        
        // Toggle location field based on remote work option
        const remoteRadio = document.getElementById('remote');
        const onsiteRadio = document.getElementById('onsite');
        const locationField = document.getElementById('location-field');
        
        remoteRadio.addEventListener('change', function() {
            if (this.checked) {
                locationField.classList.add('hidden');
            }
        });
        
        onsiteRadio.addEventListener('change', function() {
            if (this.checked) {
                locationField.classList.remove('hidden');
            }
        });
    });
</script>
@endsection 