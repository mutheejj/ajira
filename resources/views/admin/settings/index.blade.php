@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">System Settings</h1>
        <div class="flex space-x-3">
            <button type="button" id="clearCache" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Clear Cache
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 dark:bg-green-900 dark:text-green-200" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 dark:bg-red-900 dark:text-red-200" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        <!-- General Settings -->
        <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            @csrf
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">General Settings</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Basic platform configuration.</p>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site Name</label>
                        <div class="mt-1">
                            <input type="text" name="site_name" id="site_name" value="{{ $settings->site_name ?? 'Ajira Freelance Platform' }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="site_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site Email</label>
                        <div class="mt-1">
                            <input type="email" name="site_email" id="site_email" value="{{ $settings->site_email ?? 'info@ajira.com' }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Currency</label>
                        <div class="mt-1">
                            <select id="currency" name="currency" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="USD" {{ ($settings->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="KES" {{ ($settings->currency ?? '') == 'KES' ? 'selected' : '' }}>KES (KSh)</option>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Timezone</label>
                        <div class="mt-1">
                            <select id="timezone" name="timezone" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="UTC" {{ ($settings->timezone ?? 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="Africa/Nairobi" {{ ($settings->timezone ?? '') == 'Africa/Nairobi' ? 'selected' : '' }}>Africa/Nairobi (EAT)</option>
                                <option value="America/New_York" {{ ($settings->timezone ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                                <option value="Europe/London" {{ ($settings->timezone ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
                            </select>
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="site_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Site Description</label>
                        <div class="mt-1">
                            <textarea id="site_description" name="site_description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $settings->site_description ?? 'Ajira - Connecting Freelancers and Clients' }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Brief description for your site.</p>
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Registration Settings</h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="enable_registration" name="enable_registration" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600" {{ ($settings->enable_registration ?? true) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="enable_registration" class="font-medium text-gray-700 dark:text-gray-300">Enable Registration</label>
                                <p class="text-gray-500 dark:text-gray-400">Allow new users to register on the platform.</p>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="email_verification" name="email_verification" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600" {{ ($settings->email_verification ?? true) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="email_verification" class="font-medium text-gray-700 dark:text-gray-300">Email Verification</label>
                                <p class="text-gray-500 dark:text-gray-400">Require email verification for new users.</p>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="allow_client_registration" name="allow_client_registration" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600" {{ ($settings->allow_client_registration ?? true) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="allow_client_registration" class="font-medium text-gray-700 dark:text-gray-300">Allow Client Registration</label>
                                <p class="text-gray-500 dark:text-gray-400">Allow new clients to register.</p>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="allow_freelancer_registration" name="allow_freelancer_registration" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600" {{ ($settings->allow_freelancer_registration ?? true) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="allow_freelancer_registration" class="font-medium text-gray-700 dark:text-gray-300">Allow Freelancer Registration</label>
                                <p class="text-gray-500 dark:text-gray-400">Allow new job seekers to register.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Jobs Settings</h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="job_approval_required" name="job_approval_required" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600" {{ ($settings->job_approval_required ?? true) ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="job_approval_required" class="font-medium text-gray-700 dark:text-gray-300">Job Approval Required</label>
                                <p class="text-gray-500 dark:text-gray-400">New jobs require admin approval before becoming visible.</p>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="max_active_jobs" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max Active Jobs Per Client</label>
                        <div class="mt-1">
                            <input type="number" name="max_active_jobs" id="max_active_jobs" value="{{ $settings->max_active_jobs ?? 5 }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Set to 0 for unlimited jobs.</p>
                    </div>
                    
                    <div class="sm:col-span-3">
                        <label for="featured_jobs_limit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Jobs Limit</label>
                        <div class="mt-1">
                            <input type="number" name="featured_jobs_limit" id="featured_jobs_limit" value="{{ $settings->featured_jobs_limit ?? 6 }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="default_job_expiry_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Job Expiry (Days)</label>
                        <div class="mt-1">
                            <input type="number" name="default_job_expiry_days" id="default_job_expiry_days" value="{{ $settings->default_job_expiry_days ?? 30 }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">File Upload Settings</h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="max_file_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Max File Size (MB)</label>
                        <div class="mt-1">
                            <input type="number" name="max_file_size" id="max_file_size" value="{{ $settings->max_file_size ?? 10 }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="allowed_file_types" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Allowed File Types</label>
                        <div class="mt-1">
                            <input type="text" name="allowed_file_types" id="allowed_file_types" value="{{ $settings->allowed_file_types ?? 'pdf,doc,docx,jpg,jpeg,png' }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Comma-separated list of file extensions.</p>
                    </div>
                </div>
            </div>
            
            <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-right sm:px-6">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save Settings
                </button>
            </div>
        </form>
        
        <!-- System Information -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">System Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Technical details about your installation.</p>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <dl>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Laravel Version</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ app()->version() }}</dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">PHP Version</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ phpversion() }}</dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Database</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) }} / {{ DB::connection()->getDatabaseName() }}</dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Server</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'Unknown' }}</dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Environment</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ config('app.env') }}</dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">App URL</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white sm:mt-0 sm:col-span-2">{{ config('app.url') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
        
        <!-- Cache Management -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Cache Management</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Clear various caches to apply changes.</p>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:p-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <form action="{{ route('admin.cache.clear') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cache_type" value="application">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Clear Application Cache
                            </button>
                        </form>
                    </div>
                    
                    <div>
                        <form action="{{ route('admin.cache.clear') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cache_type" value="config">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                </svg>
                                Clear Config Cache
                            </button>
                        </form>
                    </div>
                    
                    <div>
                        <form action="{{ route('admin.cache.clear') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cache_type" value="view">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Clear View Cache
                            </button>
                        </form>
                    </div>
                    
                    <div>
                        <form action="{{ route('admin.cache.clear') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cache_type" value="route">
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                Clear Route Cache
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('clearCache').addEventListener('click', function() {
        if (confirm('Are you sure you want to clear all caches?')) {
            // Create and submit form to clear all caches
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.cache.clear.all') }}';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
</script>
@endsection 