@extends('layouts.app')

@section('title', 'Edit Job Seeker Profile | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Edit Profile</h1>
        
        @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900 dark:text-green-200" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
            @csrf
            @method('PATCH')
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h2>
                
                <!-- Profile Picture -->
                <div class="p-4 bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Profile Picture</h2>
                    </div>
                    
                    <div class="flex items-center space-x-8">
                        <div class="relative">
                            <div id="profile-image-container" class="w-32 h-32 rounded-full overflow-hidden border-2 border-gray-200 dark:border-gray-700">
                                @if(Auth::user()->profile_picture)
                                    <img id="profile-image-preview" src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="w-full h-full object-cover" alt="Profile Picture">
                                @else
                                    <div id="profile-image-placeholder" class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            @if(Auth::user()->profile_picture)
                                <button id="remove_profile_picture" type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                        
                        <div>
                            <label for="profile_picture" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 transition cursor-pointer">
                                Select Image
                            </label>
                            <input id="profile_picture" name="profile_picture" type="file" accept="image/*" class="hidden">
                            <input id="remove_profile_picture_input" type="hidden" name="remove_profile_picture" value="0">
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">JPG, PNG or GIF (Max. 2MB)</p>
                        </div>
                    </div>
                </div>
                
                <!-- Name and Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Professional Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="profession" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Professional Title *</label>
                        <input type="text" id="profession" name="profession" value="{{ old('profession', $user->profession) }}" required placeholder="e.g. Full Stack Developer" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('profession')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="experience" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience Level *</label>
                        <select id="experience" name="experience" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                            <option value="">Select experience level</option>
                            <option value="entry" {{ old('experience', $user->experience) == 'entry' ? 'selected' : '' }}>Entry Level</option>
                            <option value="intermediate" {{ old('experience', $user->experience) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="expert" {{ old('experience', $user->experience) == 'expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                        @error('experience')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Skills -->
                <div class="mt-6">
                    <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Skills *</label>
                    <select id="skills" name="skills[]" multiple class="select2 w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @foreach(\App\Models\Skill::orderBy('name')->get() as $skill)
                            <option value="{{ $skill->name }}" {{ in_array($skill->name, old('skills', $user->skills ?? [])) ? 'selected' : '' }}>{{ $skill->name }}</option>
                        @endforeach
                    </select>
                    @error('skills')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Select up to 10 skills that best describe your expertise.</p>
                </div>
                
                <!-- Bio -->
                <div class="mt-6">
                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Professional Bio *</label>
                    <textarea id="bio" name="bio" rows="4" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Portfolio & Documents</h2>
                
                <!-- Resume -->
                <div class="mb-6">
                    <label for="resume" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Resume</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="resume" name="resume" class="hidden" accept=".pdf,.doc,.docx">
                        <label for="resume" class="px-4 py-2 text-sm text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer">
                            Upload Resume
                        </label>
                        @if($user->resume)
                            <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                                Current: <a href="{{ asset('storage/' . $user->resume) }}" target="_blank" class="text-blue-600 dark:text-blue-400 underline">View Resume</a>
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PDF, DOC or DOCX (Max. 5MB)</p>
                    @error('resume')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Portfolio -->
                <div class="mb-6">
                    <label for="portfolio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Portfolio (ZIP file)</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="portfolio" name="portfolio" class="hidden" accept=".zip">
                        <label for="portfolio" class="px-4 py-2 text-sm text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 cursor-pointer">
                            Upload Portfolio
                        </label>
                        @if($user->portfolio)
                            <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                                Current: <a href="{{ asset('storage/' . $user->portfolio) }}" target="_blank" class="text-blue-600 dark:text-blue-400 underline">Download Portfolio</a>
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">ZIP file containing your work samples (Max. 10MB)</p>
                    @error('portfolio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Portfolio Description -->
                <div class="mb-6">
                    <label for="portfolio_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Portfolio Description</label>
                    <textarea id="portfolio_description" name="portfolio_description" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">{{ old('portfolio_description', $user->portfolio_description) }}</textarea>
                    @error('portfolio_description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Social Links</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="github_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">GitHub Profile</label>
                        <input type="url" id="github_link" name="github_link" value="{{ old('github_link', $user->github_link) }}" placeholder="https://github.com/username" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('github_link')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="linkedin_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">LinkedIn Profile</label>
                        <input type="url" id="linkedin_link" name="linkedin_link" value="{{ old('linkedin_link', $user->linkedin_link) }}" placeholder="https://linkedin.com/in/username" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('linkedin_link')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="personal_website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Personal Website</label>
                        <input type="url" id="personal_website" name="personal_website" value="{{ old('personal_website', $user->personal_website) }}" placeholder="https://example.com" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('personal_website')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Change Password</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Leave these fields blank if you don't want to change your password.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div></div>
                    
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                    </div>
                </div>
            </div>
            
            <div class="p-6 flex justify-end">
                <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm mr-3 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Initialize select2 for skills if available
    $(document).ready(function() {
        if ($.fn.select2) {
            $('#skills').select2({
                theme: "classic",
                placeholder: "Select skills",
                maximumSelectionLength: 10
            });
        }
        
        // Show filename when a file is selected
        $('#resume, #portfolio').change(function() {
            var fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $(this).next('label').siblings('span').remove();
                $(this).next('label').after('<span class="ml-3 text-sm text-gray-600 dark:text-gray-400">Selected: ' + fileName + '</span>');
            }
        });
    });
</script>
@endpush
@endsection 