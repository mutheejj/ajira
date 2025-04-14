@extends('layouts.app')

@section('title', 'Talent Marketplace | Ajira Global')

@section('content')
<div class="py-16 bg-gradient-to-b from-indigo-50 dark:from-gray-800 to-white dark:to-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">Talent Marketplace</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-3xl mx-auto">Discover a world of skilled professionals ready to bring your projects to life.</p>
        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Join Now</a>
    </div>
</div>

<div class="py-16 bg-white dark:bg-gray-900">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Why Choose Ajira?</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">Our marketplace connects you with verified professionals who have been thoroughly vetted for their skills and experience.</p>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-gray-600 dark:text-gray-300">Rigorous vetting process for all talent</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-gray-600 dark:text-gray-300">Secure payment and escrow protection</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-gray-600 dark:text-gray-300">24/7 support and dispute resolution</span>
                    </li>
                </ul>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-lg">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Talent Categories</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Development</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Web, Mobile, Software</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Design</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">UI/UX, Graphics, Branding</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Marketing</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">SEO, Social Media, Content</p>
                    </div>
                    <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Business</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-300">Consulting, Finance, Legal</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Diverse Skillsets</h3>
                <p class="text-gray-600 dark:text-gray-400">Access professionals with expertise in various fields and industries.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h.5A2.5 2.5 0 0018 5.5V3.935m0 0A9.003 9.003 0 0012 2.055a9.003 9.003 0 00-6 1.88M3 17l.5 2.5m-.8-2.5H1.95m.2-1.5a10.99 10.99 0 0118.6 0M21 17l-.5 2.5m.8-2.5h1.15m-.2-1.5a10.99 10.99 0 00-18.6 0z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Global Reach</h3>
                <p class="text-gray-600 dark:text-gray-400">Connect with talent from around the world, available in your timezone.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Verified Talent</h3>
                <p class="text-gray-600 dark:text-gray-400">Work with professionals who have been verified for their skills and experience.</p>
            </div>
        </div>

        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-8 mb-16">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                        <span class="text-indigo-600 dark:text-indigo-400 font-bold">1</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Post Your Project</h3>
                    <p class="text-gray-600 dark:text-gray-300">Describe your needs and requirements in detail.</p>
                </div>
                <div>
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                        <span class="text-indigo-600 dark:text-indigo-400 font-bold">2</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Review Proposals</h3>
                    <p class="text-gray-600 dark:text-gray-300">Evaluate and compare proposals from interested talent.</p>
                </div>
                <div>
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-4">
                        <span class="text-indigo-600 dark:text-indigo-400 font-bold">3</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Start Working</h3>
                    <p class="text-gray-600 dark:text-gray-300">Begin your project with your chosen professional.</p>
                </div>
            </div>
        </div>

        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Ready to Find Your Perfect Match?</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-8">Join thousands of businesses that have found success on Ajira.</p>
            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full transition-colors duration-300">Get Started</a>
        </div>
    </div>
</div>
@endsection 