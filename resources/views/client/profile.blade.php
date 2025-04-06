@extends('layouts.app')

@section('title', 'My Profile | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Profile</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your client profile and settings</p>
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
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Profile Summary -->
        <div class="col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <div class="flex flex-col items-center">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-4 border-white dark:border-gray-800">
                            @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <button type="button" onclick="document.getElementById('photo-upload').click()" class="absolute bottom-0 right-0 bg-blue-600 text-white rounded-full p-2 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                    </div>
                    
                    <h2 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">{{ $user->company_name }}</p>
                    
                    @if(!$user->email_verified_at)
                    <div class="mt-2 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs px-3 py-1 rounded-full">
                        Email not verified
                    </div>
                    @else
                    <div class="mt-2 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs px-3 py-1 rounded-full">
                        Verified Account
                    </div>
                    @endif
                </div>
                
                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Account Info</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500 mt-0.5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">{{ $user->email }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500 mt-0.5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">{{ $user->country ?: 'Location not specified' }}</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500 mt-0.5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-600 dark:text-gray-300">Member since {{ $user->created_at->format('M Y') }}</span>
                        </li>
                    </ul>
                </div>
                
                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Account Statistics</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <span class="block text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['active_jobs'] }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Active Jobs</span>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <span class="block text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_jobs'] }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Total Jobs</span>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <span class="block text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['active_contracts'] }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Active Contracts</span>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-center">
                            <span class="block text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['hired_freelancers'] }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Hired Freelancers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Profile Edit Form -->
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Edit Profile</h2>
                
                <form action="{{ route('client.update-profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <input type="file" id="photo-upload" name="profile_photo" class="hidden" accept="image/*">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information Section -->
                        <div class="col-span-2">
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-3">Personal Information</h3>
                        </div>
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name*</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Email (Read-only) -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}" readonly class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Email cannot be changed. Contact support for assistance.</p>
                        </div>
                        
                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Company Information Section -->
                        <div class="col-span-2">
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-3 mt-4">Company Information</h3>
                        </div>
                        
                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Name</label>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('company_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Company Size -->
                        <div>
                            <label for="company_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Size</label>
                            <select id="company_size" name="company_size" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select company size</option>
                                <option value="1-10" {{ old('company_size', $user->company_size) == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                <option value="11-50" {{ old('company_size', $user->company_size) == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                <option value="51-200" {{ old('company_size', $user->company_size) == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                <option value="201-500" {{ old('company_size', $user->company_size) == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                <option value="501+" {{ old('company_size', $user->company_size) == '501+' ? 'selected' : '' }}>501+ employees</option>
                            </select>
                            @error('company_size')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Industry -->
                        <div>
                            <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Industry</label>
                            <select id="industry" name="industry" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select industry</option>
                                @foreach($industries as $industry)
                                <option value="{{ $industry }}" {{ old('industry', $user->industry) == $industry ? 'selected' : '' }}>{{ $industry }}</option>
                                @endforeach
                            </select>
                            @error('industry')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Website -->
                        <div>
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Website</label>
                            <input type="url" id="website" name="website" value="{{ old('website', $user->website) }}" placeholder="https://example.com" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('website')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Location Section -->
                        <div class="col-span-2">
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-3 mt-4">Location</h3>
                        </div>
                        
                        <!-- Country -->
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                            <select id="country" name="country" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select country</option>
                                @foreach($countries as $country)
                                <option value="{{ $country }}" {{ old('country', $user->country) == $country ? 'selected' : '' }}>{{ $country }}</option>
                                @endforeach
                            </select>
                            @error('country')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('city')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- About Section -->
                        <div class="col-span-2">
                            <h3 class="text-md font-medium text-gray-900 dark:text-white mb-3 mt-4">About</h3>
                        </div>
                        
                        <!-- Bio -->
                        <div class="col-span-2">
                            <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bio</label>
                            <textarea id="bio" name="bio" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tell freelancers about your company or projects you typically work on.</p>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Security Settings -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mt-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Security Settings</h2>
                
                <div class="space-y-6">
                    <!-- Change Password -->
                    <div>
                        <h3 class="text-md font-medium text-gray-900 dark:text-white mb-3">Change Password</h3>
                        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password*</label>
                                <input type="password" id="current_password" name="current_password" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('current_password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password*</label>
                                <input type="password" id="password" name="password" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New Password*</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Email Verification -->
                    @if(!$user->email_verified_at)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h3 class="text-md font-medium text-gray-900 dark:text-white mb-3">Email Verification</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Your email address is not verified. Please verify your email to unlock all features.</p>
                        <form action="{{ route('verification.send') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Resend Verification Email
                            </button>
                        </form>
                    </div>
                    @endif
                    
                    <!-- Account Deletion -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h3 class="text-md font-medium text-red-600 dark:text-red-400 mb-3">Danger Zone</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                        <button type="button" onclick="confirmAccountDeletion()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete Account
                        </button>
                        
                        <!-- Account Deletion Confirmation Modal -->
                        <div id="delete-account-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="sm:flex sm:items-start">
                                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </div>
                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                                    Delete Account
                                                </h3>
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        Are you sure you want to delete your account? All of your data will be permanently removed. This action cannot be undone.
                                                    </p>
                                                </div>
                                                <div class="mt-4">
                                                    <form action="{{ route('account.delete') }}" method="POST" id="delete-account-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div>
                                                            <label for="delete-confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type "DELETE" to confirm</label>
                                                            <input type="text" id="delete-confirmation" name="confirmation" required class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="button" onclick="document.getElementById('delete-account-form').submit();" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Delete Account
                                        </button>
                                        <button type="button" onclick="confirmAccountDeletion(false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Profile Photo Upload
    document.getElementById('photo-upload').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.w-32.h-32 img, .w-32.h-32 div').remove();
                let img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-full', 'h-full', 'object-cover');
                document.querySelector('.w-32.h-32').appendChild(img);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Account Deletion Modal
    function confirmAccountDeletion(show = true) {
        const modal = document.getElementById('delete-account-modal');
        
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }
    
    // Validation for delete account form
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('delete-account-form');
        const confirmationInput = document.getElementById('delete-confirmation');
        
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                if (confirmationInput.value !== 'DELETE') {
                    e.preventDefault();
                    alert('Please type "DELETE" to confirm account deletion');
                }
            });
        }
    });
</script>
@endsection 