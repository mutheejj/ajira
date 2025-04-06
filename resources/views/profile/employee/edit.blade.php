@section('profile_content')
<!-- Profile Picture Section -->
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

<!-- Personal Information -->
// ... existing code ... 