@extends('layouts.app')

@section('title', 'Ajira Global - Find & Hire Top Talent')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Find Global Talent or Your Next Job Opportunity</h1>
                <p class="text-xl mb-8">Connect with top professionals worldwide or discover your next career move on Ajira Global.</p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-white text-blue-600 font-semibold hover:bg-gray-100 transition-colors">
                        Get Started
                    </a>
                    <a href="{{ route('how-it-works') }}" class="px-6 py-3 rounded-lg border border-white text-white font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                        How It Works
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decorative Element -->
        <div class="hidden lg:block absolute right-0 bottom-0 w-1/3 h-full">
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute inset-0 h-full w-full text-white opacity-10">
                <polygon points="0,0 100,0 100,100" fill="currentColor"></polygon>
            </svg>
        </div>
    </section>

    <!-- Category Filters Section (Upwork-style) -->
    <section class="py-8 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl shadow-md p-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Find Work in These Categories</h2>
                
                <!-- Filter Controls -->
                <div class="mb-8">
                    <div class="flex flex-wrap gap-3 mb-4">
                        <button class="px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-colors">All Categories</button>
                        <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">Development & IT</button>
                        <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">Design & Creative</button>
                        <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">Sales & Marketing</button>
                        <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">Writing & Translation</button>
                        <button class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">Admin & Support</button>
                    </div>
                    
                    <!-- Secondary filters -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="experience-level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience Level</label>
                            <select id="experience-level" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option>Any Experience</option>
                                <option>Entry Level</option>
                                <option>Intermediate</option>
                                <option>Expert</option>
                            </select>
                        </div>
                        <div>
                            <label for="job-type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Job Type</label>
                            <select id="job-type" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option>All Job Types</option>
                                <option>Hourly</option>
                                <option>Fixed-Price</option>
                                <option>Full-time</option>
                            </select>
                        </div>
                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget</label>
                            <select id="budget" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option>Any Budget</option>
                                <option>Under $100</option>
                                <option>$100 - $500</option>
                                <option>$500 - $1,000</option>
                                <option>$1,000 - $5,000</option>
                                <option>$5,000+</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Job Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Job Card 1 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Senior Web Developer</h3>
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">New</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-4">Looking for an experienced developer to build a responsive e-commerce website with React and Node.js.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">React</span>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Node.js</span>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">E-commerce</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 dark:text-gray-400">$30-50/hr</span>
                            <span class="text-gray-600 dark:text-gray-400">Posted 2 days ago</span>
                        </div>
                    </div>
                    
                    <!-- Job Card 2 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">UI/UX Designer</h3>
                            <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">Featured</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-4">Seeking a talented designer to create user interfaces for a mobile application. Experience with Figma required.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">UI/UX</span>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Figma</span>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Mobile App</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 dark:text-gray-400">$2,000-3,000</span>
                            <span class="text-gray-600 dark:text-gray-400">Posted 3 days ago</span>
                        </div>
                    </div>
                    
                    <!-- Job Card 3 -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Content Writer</h3>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Verified</span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-4">Looking for a skilled content writer to create blog posts, articles, and marketing copy for a SaaS company.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Content Writing</span>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">SEO</span>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">Marketing</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600 dark:text-gray-400">$25-35/hr</span>
                            <span class="text-gray-600 dark:text-gray-400">Posted 1 day ago</span>
                        </div>
                    </div>
                </div>
                
                <!-- View More Button -->
                <div class="mt-8 text-center">
                    <a href="{{ route('jobs.index') }}" class="inline-block px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        View All Jobs
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Categories Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Popular Job Categories</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Category 1 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Web Development</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">1,245 Jobs Available</p>
                </div>
                
                <!-- Category 2 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Design & Creative</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">876 Jobs Available</p>
                </div>
                
                <!-- Category 3 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 dark:bg-purple-900 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Marketing</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">632 Jobs Available</p>
                </div>
                
                <!-- Category 4 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 dark:bg-yellow-900 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Content Writing</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">518 Jobs Available</p>
                </div>
                
                <!-- Category 5 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Finance & Accounting</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">423 Jobs Available</p>
                </div>
                
                <!-- Category 6 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 dark:bg-indigo-900 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Cloud Computing</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">386 Jobs Available</p>
                </div>
                
                <!-- Category 7 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-pink-100 dark:bg-pink-900 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-600 dark:text-pink-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Customer Service</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">352 Jobs Available</p>
                </div>
                
                <!-- Category 8 -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Admin & Support</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">305 Jobs Available</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">Success Stories</h2>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded-full mr-4"></div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Sarah Johnson</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Web Developer</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">"Ajira Global helped me find consistent remote work with clients from around the world. The platform is easy to use and the payment system is reliable."</p>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded-full mr-4"></div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Michael Chen</h4>
                            <p class="text-gray-600 dark:text-gray-300 text-sm">Startup Founder</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">"As a startup founder, I needed to find talented professionals quickly. Ajira Global made it easy to connect with skilled freelancers who delivered quality work on time."</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl max-w-2xl mx-auto mb-8">Join thousands of professionals on Ajira Global and start your journey today.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-white text-blue-600 font-semibold hover:bg-gray-100 transition-colors">
                    Create an Account
                </a>
                <a href="{{ route('learn-more') }}" class="px-6 py-3 rounded-lg border border-white text-white font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    Learn More
                </a>
            </div>
        </div>
    </section>
@endsection