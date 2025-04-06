@extends('layouts.auth')

@section('title', 'Sign Up | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="bg-blue-600 dark:bg-blue-700 px-6 py-4">
            <h1 class="text-2xl font-bold text-white text-center">Join Ajira Global</h1>
        </div>
        
        <div class="p-6">
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Multi-step Form -->
            <div x-data="{ step: 1, userType: '', formSubmitted: false }">
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex mb-2">
                        <div class="flex-1 text-center" :class="{'text-blue-600 dark:text-blue-400 font-medium': step >= 1, 'text-gray-500 dark:text-gray-400': step < 1}">Account Type</div>
                        <div class="flex-1 text-center" :class="{'text-blue-600 dark:text-blue-400 font-medium': step >= 2, 'text-gray-500 dark:text-gray-400': step < 2}">Basic Information</div>
                        <div class="flex-1 text-center" :class="{'text-blue-600 dark:text-blue-400 font-medium': step >= 3, 'text-gray-500 dark:text-gray-400': step < 3}">Professional Details</div>
                    </div>
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200 dark:bg-gray-700">
                        <div :style="'width:' + ((step - 1) / 2 * 100) + '%'" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600 dark:bg-blue-500 transition-all duration-500"></div>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}" id="registration-form" @submit.prevent="formSubmitted ? true : $event.target.submit(); formSubmitted = true;">
                    @csrf
                    <!-- Step 1: Account Type Selection -->
                    <div x-show="step === 1" class="space-y-6">
                        <div class="mb-6 text-center">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Choose your account type</h2>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Select how you want to use Ajira Global</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Client Option -->
                            <div @click="userType = 'client'" 
                                 :class="{'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20': userType === 'client'}"
                                 class="p-6 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex items-center mb-4">
                                    <input type="radio" name="user_type" id="user_type_client" value="client" x-model="userType" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                    <label for="user_type_client" class="ml-3 block text-lg font-medium text-gray-800 dark:text-white">
                                        I'm hiring for a project
                                    </label>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 ml-7">
                                    I need to hire skilled professionals to work on my projects, either for short-term contracts or ongoing work.
                                </p>
                                <div class="flex items-center mt-4 ml-7 text-sm text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Post jobs and hire talent
                                </div>
                                <div class="flex items-center mt-2 ml-7 text-sm text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Browse professional profiles
                                </div>
                            </div>

                            <!-- Job Seeker Option -->
                            <div @click="userType = 'job-seeker'" 
                                 :class="{'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20': userType === 'job-seeker'}"
                                 class="p-6 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex items-center mb-4">
                                    <input type="radio" name="user_type" id="user_type_job_seeker" value="job-seeker" x-model="userType" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                    <label for="user_type_job_seeker" class="ml-3 block text-lg font-medium text-gray-800 dark:text-white">
                                        I'm looking for work
                                    </label>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 ml-7">
                                    I want to find projects that match my skills and experience, and connect with clients from around the world.
                                </p>
                                <div class="flex items-center mt-4 ml-7 text-sm text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Find jobs that match your skills
                                </div>
                                <div class="flex items-center mt-2 ml-7 text-sm text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Build your professional profile
                                </div>
                            </div>
                        </div>

                        @error('user_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <div class="flex justify-end mt-8">
                            <button 
                                type="button" 
                                @click="step = 2" 
                                :disabled="!userType"
                                :class="{'opacity-50 cursor-not-allowed': !userType}"
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Basic Information -->
                    <div x-show="step === 2" class="space-y-6">
                        <div class="mb-6 text-center">
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Create your account</h2>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">Fill in your basic information</p>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('name') border-red-500 @enderror">
                            
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('email') border-red-500 @enderror">
                            
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                            <input id="password" type="password" name="password" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('password') border-red-500 @enderror">
                            
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors">
                        </div>

                        <div class="flex justify-between mt-8">
                            <button 
                                type="button" 
                                @click="step = 1" 
                                class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Back
                            </button>
                            <button 
                                type="button" 
                                @click="step = 3" 
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Professional Details (conditional based on user type) -->
                    <div x-show="step === 3" class="space-y-6">
                        <!-- Client-specific fields -->
                        <div x-show="userType === 'client'">
                            <div class="mb-6 text-center">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Company Information</h2>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Tell us about your business</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Name</label>
                                    <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" 
                                        x-bind:required="userType === 'client'"
                                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('company_name') border-red-500 @enderror">
                                    
                                    @error('company_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="industry" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Industry</label>
                                    <select id="industry" name="industry" 
                                        x-bind:required="userType === 'client'"
                                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('industry') border-red-500 @enderror">
                                        <option value="">Select Industry</option>
                                        <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                        <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                                        <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                                        <option value="Marketing" {{ old('industry') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                        <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                        <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                        <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    
                                    @error('industry')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="company_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Size</label>
                                    <select id="company_size" name="company_size" 
                                        x-bind:required="userType === 'client'"
                                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('company_size') border-red-500 @enderror">
                                        <option value="">Select Company Size</option>
                                        <option value="1-10" {{ old('company_size') == '1-10' ? 'selected' : '' }}>1-10 employees</option>
                                        <option value="11-50" {{ old('company_size') == '11-50' ? 'selected' : '' }}>11-50 employees</option>
                                        <option value="51-200" {{ old('company_size') == '51-200' ? 'selected' : '' }}>51-200 employees</option>
                                        <option value="201-500" {{ old('company_size') == '201-500' ? 'selected' : '' }}>201-500 employees</option>
                                        <option value="501+" {{ old('company_size') == '501+' ? 'selected' : '' }}>501+ employees</option>
                                    </select>
                                    
                                    @error('company_size')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Website (Optional)</label>
                                    <input id="website" type="url" name="website" value="{{ old('website') }}"
                                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('website') border-red-500 @enderror">
                                    
                                    @error('website')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Job Seeker specific fields -->
                        <div x-show="userType === 'job-seeker'">
                            <div class="mb-6 text-center">
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Professional Information</h2>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Tell us about your skills and experience</p>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label for="profession" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professional Title</label>
                                    <input id="profession" type="text" name="profession" value="{{ old('profession') }}" placeholder="e.g. Full Stack Developer"
                                        x-bind:required="userType === 'job-seeker'"
                                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('profession') border-red-500 @enderror">
                                    
                                    @error('profession')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="experience" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Years of Experience</label>
                                    <select id="experience" name="experience"
                                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('experience') border-red-500 @enderror">
                                        <option value="">Select Experience</option>
                                        <option value="0-1" {{ old('experience') == '0-1' ? 'selected' : '' }}>0-1 years</option>
                                        <option value="1-3" {{ old('experience') == '1-3' ? 'selected' : '' }}>1-3 years</option>
                                        <option value="3-5" {{ old('experience') == '3-5' ? 'selected' : '' }}>3-5 years</option>
                                        <option value="5-10" {{ old('experience') == '5-10' ? 'selected' : '' }}>5-10 years</option>
                                        <option value="10+" {{ old('experience') == '10+' ? 'selected' : '' }}>10+ years</option>
                                    </select>
                                    
                                    @error('experience')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="skills" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Main Skills (comma separated)</label>
                                    <input id="skills" type="text" name="skills" value="{{ old('skills') }}" placeholder="e.g. JavaScript, React, Node.js"
                                        class="mt-1 block w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white transition-colors @error('skills') border-red-500 @enderror">
                                    
                                    @error('skills')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center mt-6">
                            <input id="terms" type="checkbox" name="terms" required
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600 rounded transition-colors">
                            <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                I agree to the <a href="{{ route('terms') }}" class="text-blue-600 dark:text-blue-400 hover:underline" target="_blank">Terms of Service</a> and <a href="{{ route('privacy') }}" class="text-blue-600 dark:text-blue-400 hover:underline" target="_blank">Privacy Policy</a>
                            </label>
                        </div>

                        <div class="flex justify-between mt-8">
                            <button 
                                type="button" 
                                @click="step = 2" 
                                class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Back
                            </button>
                            <button 
                                type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Create Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        Log in here
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection