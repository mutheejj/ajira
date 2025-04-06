@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="container mx-auto px-6">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">System Settings</h1>
    
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">System Configuration</h2>
        </div>
        
        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6">
            @csrf
            
            <!-- Site Settings Section -->
            <div class="mb-8">
                <h3 class="text-md font-medium text-gray-900 dark:text-white mb-4">Site Settings</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site Name</label>
                        <input type="text" name="site_name" id="site_name" value="{{ config('app.name') }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contact Email</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ config('mail.from.address', 'noreply@ajira.com') }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div class="col-span-1 md:col-span-2">
                        <label for="site_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site Description</label>
                        <textarea name="site_description" id="site_description" rows="3" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ config('app.description', 'Ajira Global - Connecting Job Seekers with Clients Worldwide') }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Mail Configuration Settings -->
            <div class="mb-8">
                <h3 class="text-md font-medium text-gray-900 dark:text-white mb-4">Mail Configuration</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mail_driver" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mail Driver</label>
                        <select name="mail_driver" id="mail_driver" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="smtp" {{ config('mail.default') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="mailgun" {{ config('mail.default') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="ses" {{ config('mail.default') == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                            <option value="mailersend" {{ config('mail.default') == 'mailersend' ? 'selected' : '' }}>MailerSend</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="mail_host" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mail Host</label>
                        <input type="text" name="mail_host" id="mail_host" value="{{ config('mail.host') }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="mail_port" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mail Port</label>
                        <input type="text" name="mail_port" id="mail_port" value="{{ config('mail.port') }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mail Encryption</label>
                        <select name="mail_encryption" id="mail_encryption" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="tls" {{ config('mail.encryption') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ config('mail.encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="" {{ config('mail.encryption') == '' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="mail_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mail Username</label>
                        <input type="text" name="mail_username" id="mail_username" value="{{ config('mail.username') }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="mail_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mail Password</label>
                        <input type="password" name="mail_password" id="mail_password" value="{{ config('mail.password') ? '••••••••' : '' }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Address</label>
                        <input type="email" name="mail_from_address" id="mail_from_address" value="{{ config('mail.from.address') }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="mail_from_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Name</label>
                        <input type="text" name="mail_from_name" id="mail_from_name" value="{{ config('mail.from.name') }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('test.email') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-sm">Test Email Configuration</a>
                </div>
            </div>
            
            <!-- Payments Settings -->
            <div class="mb-8">
                <h3 class="text-md font-medium text-gray-900 dark:text-white mb-4">Payment Settings</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="payment_currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Default Currency</label>
                        <select name="payment_currency" id="payment_currency" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="USD" selected>USD - US Dollar</option>
                            <option value="EUR">EUR - Euro</option>
                            <option value="GBP">GBP - British Pound</option>
                            <option value="CAD">CAD - Canadian Dollar</option>
                            <option value="AUD">AUD - Australian Dollar</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="payment_provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Provider</label>
                        <select name="payment_provider" id="payment_provider" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="stripe" selected>Stripe</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="stripe_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stripe Public Key</label>
                        <input type="text" name="stripe_key" id="stripe_key" value="{{ config('services.stripe.key') }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="stripe_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stripe Secret Key</label>
                        <input type="password" name="stripe_secret" id="stripe_secret" value="{{ config('services.stripe.secret') ? '••••••••' : '' }}" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="commission_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Platform Commission Rate (%)</label>
                        <input type="number" name="commission_rate" id="commission_rate" value="{{ config('app.commission_rate', 10) }}" min="0" max="100" step="0.1" class="block w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
            </div>
            
            <!-- Save Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 