@extends('layouts.app')

@section('title', 'How It Works - Ajira Global')

@section('content')
    <div class="bg-white dark:bg-gray-800">
        <!-- Page Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 py-16">
            <div class="container mx-auto px-4">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4">How Ajira Global Works</h1>
                <p class="text-xl text-white/90 max-w-3xl">Learn how our platform connects talented professionals with businesses seeking expertise worldwide.</p>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="container mx-auto px-4 py-12">
            <!-- Introduction -->
            <div class="max-w-4xl mx-auto mb-16">
                <h2 class="text-3xl font-semibold mb-6 text-gray-900 dark:text-white">Connecting Talent with Opportunity</h2>
                <p class="text-lg mb-6 text-gray-700 dark:text-gray-300">
                    Ajira Global is a comprehensive platform that bridges the gap between skilled professionals and businesses seeking expertise. 
                    Whether you're looking to hire top talent or find your next job opportunity, our platform provides the tools and resources you need to succeed.
                </p>
                <p class="text-lg text-gray-700 dark:text-gray-300">
                    Our mission is to create economic opportunities so people have better lives. We help businesses find, hire, and pay the best professionals around the world. 
                    We provide resources for job seekers to discover opportunities, develop skills, and showcase their expertise.
                </p>
            </div>
            
            <!-- For Clients Section -->
            <div class="mb-20">
                <h2 class="text-2xl font-semibold mb-8 text-gray-900 dark:text-white text-center">For Businesses & Clients</h2>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6 text-blue-600 dark:text-blue-300 font-bold">1</div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Post a Job</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Create a detailed job posting specifying the skills, experience, and qualifications you're looking for. 
                            Set your budget and timeline, and choose between hourly or fixed-price projects.
                        </p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6 text-blue-600 dark:text-blue-300 font-bold">2</div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Review Applications</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Review applications from qualified professionals. Evaluate profiles, portfolios, and reviews to find the perfect match for your project.
                            Use our built-in tools to communicate with potential candidates.
                        </p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6 text-blue-600 dark:text-blue-300 font-bold">3</div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Collaborate & Pay</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Work with your chosen professional using our secure platform. Track progress, share files, and communicate effectively.
                            Our secure payment system ensures you only pay for approved work.
                        </p>
                    </div>
                </div>
                
                <div class="mt-12 text-center">
                    <a href="{{ route('post-job') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Post a Job Now</a>
                </div>
            </div>
            
            <!-- For Job Seekers Section -->
            <div class="mb-20">
                <h2 class="text-2xl font-semibold mb-8 text-gray-900 dark:text-white text-center">For Professionals & Job Seekers</h2>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6 text-blue-600 dark:text-blue-300 font-bold">1</div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Create Your Profile</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Build a comprehensive profile highlighting your skills, experience, and portfolio. 
                            Set your rates, specify your expertise, and showcase your past work to attract potential clients.
                        </p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6 text-blue-600 dark:text-blue-300 font-bold">2</div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Find & Apply to Jobs</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Browse job postings that match your skills and interests. Apply to positions with a customized cover letter explaining why you're the perfect fit.
                            Use our search filters to find the most relevant opportunities.
                        </p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="bg-gray-50 dark:bg-gray-700 p-8 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6 text-blue-600 dark:text-blue-300 font-bold">3</div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Deliver Quality Work</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Once hired, communicate clearly with your client, deliver high-quality work, and build your reputation.
                            Get paid securely through our platform and collect reviews to enhance your profile.
                        </p>
                    </div>
                </div>
                
                <div class="mt-12 text-center">
                    <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Create an Account</a>
                </div>
            </div>
            
            <!-- FAQs Section -->
            <div class="max-w-4xl mx-auto" x-data="{ activeTab: 0 }">
                <h2 class="text-2xl font-semibold mb-8 text-gray-900 dark:text-white text-center">Frequently Asked Questions</h2>
                
                <div class="space-y-6">
                    <!-- FAQ Item 1 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button
                            @click="activeTab = activeTab === 1 ? 0 : 1"
                            class="flex justify-between items-center w-full px-4 py-3 text-left bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                            <span class="font-medium text-gray-900 dark:text-white">How much does it cost to hire on Ajira Global?</span>
                            <svg 
                                class="w-5 h-5 text-gray-500 transition-transform" 
                                :class="{ 'transform rotate-180': activeTab === 1 }"
                                fill="currentColor" 
                                viewBox="0 0 20 20"
                            >
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div x-show="activeTab === 1" class="px-4 py-3 bg-gray-50 dark:bg-gray-700">
                            <p class="text-gray-600 dark:text-gray-300">
                                Clients pay a 5% service fee on top of the amount paid to the professional. For example, if you pay a professional $100, you'll be charged $105 in total. This fee helps us maintain and improve the platform.
                            </p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 2 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button
                            @click="activeTab = activeTab === 2 ? 0 : 2"
                            class="flex justify-between items-center w-full px-4 py-3 text-left bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                            <span class="font-medium text-gray-900 dark:text-white">How do professionals get paid?</span>
                            <svg 
                                class="w-5 h-5 text-gray-500 transition-transform" 
                                :class="{ 'transform rotate-180': activeTab === 2 }"
                                fill="currentColor" 
                                viewBox="0 0 20 20"
                            >
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div x-show="activeTab === 2" class="px-4 py-3 bg-gray-50 dark:bg-gray-700">
                            <p class="text-gray-600 dark:text-gray-300">
                                Professionals receive payments through our secure payment system. For fixed-price projects, payments are released once the client approves the work. For hourly projects, payments are processed weekly based on verified hours. Professionals can withdraw funds to their bank accounts or other payment methods.
                            </p>
                        </div>
                    </div>
                    
                    <!-- FAQ Item 3 -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <button
                            @click="activeTab = activeTab === 3 ? 0 : 3"
                            class="flex justify-between items-center w-full px-4 py-3 text-left bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                            <span class="font-medium text-gray-900 dark:text-white">Is there a fee for job seekers?</span>
                            <svg 
                                class="w-5 h-5 text-gray-500 transition-transform" 
                                :class="{ 'transform rotate-180': activeTab === 3 }"
                                fill="currentColor" 
                                viewBox="0 0 20 20"
                            >
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div x-show="activeTab === 3" class="px-4 py-3 bg-gray-50 dark:bg-gray-700">
                            <p class="text-gray-600 dark:text-gray-300">
                                Professionals pay a 10% service fee on their earnings. For example, if you earn $100 from a client, you'll receive $90 after the service fee. This fee helps us maintain and improve the platform, provide customer support, and facilitate secure payments.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 