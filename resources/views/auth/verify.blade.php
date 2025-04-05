@extends('layouts.auth')

@section('title', 'Verify Email | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="bg-blue-600 dark:bg-blue-700 px-6 py-4">
            <h1 class="text-xl font-bold text-white text-center">Verify Your Email Address</h1>
        </div>
        
        <div class="p-6">
            @if (session('resent'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                    <p>A fresh verification link has been sent to your email address.</p>
                </div>
            @endif

            <p class="text-gray-600 dark:text-gray-400 mb-4">
                Before proceeding, please check your email for a verification link. If you did not receive the email, click the button below to request another.
            </p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <div class="flex justify-center">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Resend Verification Email
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 