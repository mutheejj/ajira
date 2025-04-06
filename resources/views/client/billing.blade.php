@extends('layouts.app')

@section('title', 'Billing & Payments | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Billing & Payments</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your payment methods and billing history</p>
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
        <!-- Left Column - Payment Methods and Subscriptions -->
        <div class="col-span-1 lg:col-span-2">
            <!-- Payment Methods -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Payment Methods</h2>
                    <button type="button" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New
                    </button>
                </div>
                
                @if(count($paymentMethods) > 0)
                <div class="space-y-4">
                    @foreach($paymentMethods as $method)
                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg {{ $method->is_default ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : 'bg-white dark:bg-gray-800' }}">
                        <div class="flex items-center">
                            <div class="mr-3">
                                @if($method->type === 'credit_card')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                </svg>
                                @elseif($method->type === 'paypal')
                                <svg class="h-8 w-8 text-blue-500" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20.1 6.75C19.8 4.21 17.91 3 15.22 3H8.12C7.43 3 6.85 3.54 6.75 4.21L4.17 18.12C4.1 18.59 4.47 19 4.95 19H8.01L8.61 15.03C8.68 14.5 9.15 14.14 9.69 14.14H11.58C14.91 14.14 17.04 12.36 17.56 9.21C17.89 7.57 17.56 6.32 16.5 5.4C16.27 5.18 16.01 5 15.72 6.75H20.1Z"/>
                                    <path d="M16.5 5.4C16.27 5.18 16.01 5 15.72 4.84C15.08 4.52 14.31 4.36 13.41 4.36H8.12C7.84 4.36 7.59 4.54 7.53 4.81L5.5 15.92C5.45 16.19 5.67 16.45 5.95 16.45H8.01L8.61 15.03C8.68 14.5 9.15 14.14 9.69 14.14H11.58C14.91 14.14 17.04 12.36 17.56 9.21C17.89 7.57 17.56 6.32 16.5 5.4Z"/>
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $method->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $method->type === 'credit_card' ? 'Ending in ' . $method->last4 : $method->email }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">{{ $method->type === 'credit_card' ? 'Expires ' . $method->exp_month . '/' . $method->exp_year : 'Connected Account' }}</p>
                                @if($method->is_default)
                                <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Default</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            @if(!$method->is_default)
                            <button type="button" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                Set Default
                            </button>
                            @endif
                            <button type="button" class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">
                                Remove
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">No payment methods added yet.</p>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Payment Method
                    </button>
                </div>
                @endif
            </div>
            
            <!-- Subscription Plans -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Subscription Plans</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Basic Plan -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 flex flex-col {{ $currentPlan === 'basic' ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : 'bg-white dark:bg-gray-800' }}">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Basic</h3>
                            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">$0 <span class="text-sm font-normal text-gray-500 dark:text-gray-400">/month</span></p>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Perfect for getting started with your first project.</p>
                            
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Post up to 3 jobs</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Basic search filters</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Standard support</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mt-6">
                            @if($currentPlan === 'basic')
                            <button type="button" disabled class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 opacity-50 cursor-not-allowed">
                                Current Plan
                            </button>
                            @else
                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Switch to Basic
                            </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Pro Plan -->
                    <div class="border-2 border-blue-500 dark:border-blue-400 rounded-lg p-6 flex flex-col bg-white dark:bg-gray-800 relative">
                        <div class="absolute top-0 right-0 bg-blue-500 text-white px-3 py-1 text-xs font-bold uppercase rounded-bl-lg rounded-tr-lg">
                            Popular
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pro</h3>
                            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">$49 <span class="text-sm font-normal text-gray-500 dark:text-gray-400">/month</span></p>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">For businesses with multiple projects and regular hiring needs.</p>
                            
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Unlimited job postings</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Featured job listings</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Advanced talent filters</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Priority support</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mt-6">
                            @if($currentPlan === 'pro')
                            <button type="button" disabled class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 opacity-50 cursor-not-allowed">
                                Current Plan
                            </button>
                            @else
                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Upgrade to Pro
                            </button>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Enterprise Plan -->
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 flex flex-col {{ $currentPlan === 'enterprise' ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800' : 'bg-white dark:bg-gray-800' }}">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Enterprise</h3>
                            <p class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">$149 <span class="text-sm font-normal text-gray-500 dark:text-gray-400">/month</span></p>
                            <p class="mt-3 text-sm text-gray-500 dark:text-gray-400">For large organizations with premium requirements.</p>
                            
                            <ul class="mt-4 space-y-2">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">All Pro features</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Dedicated account manager</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">Custom reporting</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm text-gray-600 dark:text-gray-300">API access</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="mt-6">
                            @if($currentPlan === 'enterprise')
                            <button type="button" disabled class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 opacity-50 cursor-not-allowed">
                                Current Plan
                            </button>
                            @else
                            <button type="button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Upgrade to Enterprise
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Billing History -->
        <div class="col-span-1">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Billing History</h2>
                
                @if(count($transactions) > 0)
                <div class="space-y-4">
                    @foreach($transactions as $transaction)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->description }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction->date->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->currency }} {{ number_format($transaction->amount, 2) }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $transaction->status === 'successful' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2 flex justify-between items-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                @if($transaction->type === 'subscription')
                                Subscription - {{ $transaction->plan }}
                                @elseif($transaction->type === 'payment')
                                Payment for {{ $transaction->item }}
                                @else
                                {{ ucfirst($transaction->type) }}
                                @endif
                            </p>
                            <a href="{{ route('invoices.download', $transaction->id) }}" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                Download Invoice
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if(count($transactions) > 5)
                <div class="mt-4 text-center">
                    <a href="{{ route('client.transactions') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                        View All Transactions
                    </a>
                </div>
                @endif
                @else
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-600 dark:text-gray-400 mb-2">No billing history yet.</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500">Transaction records will appear here once you make a payment.</p>
                </div>
                @endif
            </div>
            
            <!-- Billing Address -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Billing Address</h2>
                    <button type="button" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                        Edit
                    </button>
                </div>
                
                @if($billingAddress)
                <div class="text-sm text-gray-600 dark:text-gray-300">
                    <p>{{ $billingAddress->name }}</p>
                    <p>{{ $billingAddress->address_line1 }}</p>
                    @if($billingAddress->address_line2)
                    <p>{{ $billingAddress->address_line2 }}</p>
                    @endif
                    <p>{{ $billingAddress->city }}, {{ $billingAddress->state }} {{ $billingAddress->postal_code }}</p>
                    <p>{{ $billingAddress->country }}</p>
                </div>
                @else
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <p>No billing address added yet.</p>
                    <button type="button" class="mt-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                        Add Billing Address
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 