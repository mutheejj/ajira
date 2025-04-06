@extends('layouts.app')

@section('title', 'Edit Client Profile | Ajira Global')

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
                <div class="mb-6">
                    <div class="flex items-center">
                        <div class="relative">
                            <div id="profile-image-container" class="w-24 h-24 rounded-full overflow-hidden">
                                @if($user->profile_picture)
                                    <img id="profile-image-preview" src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <div id="profile-image-placeholder" class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <label for="profile_picture" class="absolute bottom-0 right-0 bg-white dark:bg-gray-800 rounded-full p-1 shadow-md cursor-pointer">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*">
                            </label>
                            
                            @if($user->profile_picture)
                            <button type="button" id="remove_profile_picture" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                            @endif
                            <input type="hidden" name="remove_profile_picture" id="remove_profile_picture_input" value="0">
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Upload a profile picture</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">JPG, PNG or GIF (Max. 5MB)</p>
                        </div>
                    </div>
                    @error('profile_picture')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
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
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Company Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Name *</label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Industry *</label>
                        <input type="text" id="industry" name="industry" value="{{ old('industry', $user->industry) }}" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('industry')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="company_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Size *</label>
                        <select id="company_size" name="company_size" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                            <option value="">Select company size</option>
                            <option value="1-10" {{ old('company_size', $user->company_size) == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                            <option value="11-50" {{ old('company_size', $user->company_size) == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                            <option value="51-200" {{ old('company_size', $user->company_size) == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                            <option value="201-500" {{ old('company_size', $user->company_size) == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                            <option value="501-1000" {{ old('company_size', $user->company_size) == '501-1000' ? 'selected' : '' }}>501-1000 employees</option>
                            <option value="1001+" {{ old('company_size', $user->company_size) == '1001+' ? 'selected' : '' }}>1001+ employees</option>
                        </select>
                        @error('company_size')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website</label>
                        <input type="url" id="website" name="website" value="{{ old('website', $user->website) }}" placeholder="https://example.com" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Description</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white">{{ old('description', $user->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
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
                <a href="{{ route('client.profile') }}" class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm mr-3 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Profile picture preview functionality
        const profilePictureInput = document.getElementById('profile_picture');
        const profileImagePreview = document.getElementById('profile-image-preview');
        const profileImagePlaceholder = document.getElementById('profile-image-placeholder');
        const profileImageContainer = document.getElementById('profile-image-container');
        const removeProfilePictureBtn = document.getElementById('remove_profile_picture');
        const removeProfilePictureInput = document.getElementById('remove_profile_picture_input');
        
        // Preview uploaded image
        if (profilePictureInput) {
            profilePictureInput.addEventListener('change', function() {
                const file = this.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        // Create or use existing preview image
                        let imgElement = profileImagePreview;
                        
                        if (!imgElement) {
                            imgElement = document.createElement('img');
                            imgElement.id = 'profile-image-preview';
                            imgElement.classList.add('w-full', 'h-full', 'object-cover');
                            
                            // Remove placeholder if it exists
                            if (profileImagePlaceholder) {
                                profileImagePlaceholder.remove();
                            }
                            
                            // Add the image to the container
                            profileImageContainer.appendChild(imgElement);
                            
                            // Add remove button if it doesn't exist
                            if (!removeProfilePictureBtn) {
                                const removeBtn = document.createElement('button');
                                removeBtn.id = 'remove_profile_picture';
                                removeBtn.type = 'button';
                                removeBtn.className = 'absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition-colors';
                                removeBtn.innerHTML = `
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                `;
                                
                                const parentElement = profileImageContainer.parentElement;
                                parentElement.appendChild(removeBtn);
                                
                                // Add event listener to the new button
                                setupRemoveButton(removeBtn);
                            }
                        }
                        
                        // Set the preview image source
                        imgElement.src = e.target.result;
                        
                        // Reset remove flag when a new image is selected
                        if (removeProfilePictureInput) {
                            removeProfilePictureInput.value = "0";
                        }
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Setup remove button functionality
        function setupRemoveButton(button) {
            button.addEventListener('click', function() {
                // Set the hidden input value to indicate removal
                if (removeProfilePictureInput) {
                    removeProfilePictureInput.value = "1";
                }
                
                // Clear the file input
                if (profilePictureInput) {
                    profilePictureInput.value = '';
                }
                
                // Remove the preview image and show placeholder
                if (profileImagePreview) {
                    profileImagePreview.remove();
                }
                
                // Create placeholder if it doesn't exist
                if (!profileImagePlaceholder) {
                    const placeholder = document.createElement('div');
                    placeholder.id = 'profile-image-placeholder';
                    placeholder.className = 'w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center';
                    placeholder.innerHTML = `
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    `;
                    
                    profileImageContainer.appendChild(placeholder);
                }
                
                // Hide the remove button
                this.style.display = 'none';
            });
        }
        
        // Initialize remove button if it exists
        if (removeProfilePictureBtn) {
            setupRemoveButton(removeProfilePictureBtn);
        }
    });
</script>
@endpush 