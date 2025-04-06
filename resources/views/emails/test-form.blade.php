@extends('layouts.app')

@section('title', 'Test Email Configuration')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Test Email Configuration</h1>
        
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
        
        <!-- Current Email Configuration -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Current Email Configuration</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <tbody>
                        @foreach($emailSettings as $key => $value)
                            <tr class="border-b dark:border-gray-700">
                                <td class="py-2 px-4 font-medium text-gray-900 dark:text-white">{{ $key }}</td>
                                <td class="py-2 px-4 text-gray-600 dark:text-gray-300">
                                    @if(str_contains(strtolower($key), 'password'))
                                        ●●●●●●●●
                                    @else
                                        {{ $value ?: 'Not set' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                <p>These settings are from your <code>.env</code> file and <code>config/mail.php</code>.</p>
            </div>
        </div>
        
        <!-- Test Email Form -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Send Test Email</h2>
            
            <form action="{{ route('test.email.send') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Recipient Email Address*
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        placeholder="Enter email address">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Email Subject*
                    </label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject', 'Test Email from Ajira Global') }}" required
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        placeholder="Enter email subject">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Email Content*
                    </label>
                    <textarea id="content" name="content" rows="5" required
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                        placeholder="Enter email content">{{ old('content', "Hello,\n\nThis is a test email from Ajira Global to verify the email configuration is working correctly.\n\nRegards,\nAjira Team") }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                        </svg>
                        Send Test Email
                    </button>
                </div>
            </form>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                &larr; Back to Home
            </a>
        </div>
    </div>
</div>
@endsection 