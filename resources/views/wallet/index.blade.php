@extends('layouts.app')

@section('title', 'My Wallet | Ajira Global')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        @if(auth()->user()->isJobSeeker())
                            Job Seeker
                        @elseif(auth()->user()->is_client)
                            Client
                        @elseif(auth()->user()->is_admin)
                            Administrator
                        @endif
                    </p>
                </div>
            </div>
            
            <nav class="space-y-1">
                @if(auth()->user()->isJobSeeker())
                    <a href="{{ route('jobseeker.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('applications.index') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0019.414 6L15 1.586A2 2 0 0013.586 1H10a2 2 0 00-2 2zm7 2l3 3v1h-4V4h1zm-2 12H5V4h5v3a2 2 0 002 2h3v7z" clip-rule="evenodd" />
                        </svg>
                        My Applications
                    </a>
                    <a href="{{ route('jobseeker.tasks') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                        Active Tasks
                    </a>
                    <a href="{{ route('jobseeker.worklog') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        Work Log
                    </a>
                @elseif(auth()->user()->is_client)
                    <a href="{{ route('client.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('client.jobs') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                        My Jobs
                    </a>
                    <a href="{{ route('client.applications') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0019.414 6L15 1.586A2 2 0 0013.586 1H10a2 2 0 00-2 2zm7 2l3 3v1h-4V4h1zm-2 12H5V4h5v3a2 2 0 002 2h3v7z" clip-rule="evenodd" />
                        </svg>
                        Applications
                    </a>
                    <a href="{{ route('client.active-contracts') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1.323l-3.954 1.582A1 1 0 004 6.832v10.336a1 1 0 001.424.933l3.79-2.016a1 1 0 01.943 0l3.792 2.016a1 1 0 001.424-.933V6.832a1 1 0 00-1.046-.933L10 3.323V3a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Active Contracts
                    </a>
                @elseif(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                        </svg>
                        Users
                    </a>
                    <a href="{{ route('admin.jobs') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                        </svg>
                        Jobs
                    </a>
                @endif
                
                <a href="{{ route('wallet.index') }}" class="flex items-center px-3 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-md font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                    </svg>
                    Wallet
                </a>
                
                <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                    </svg>
                    Profile Settings
                </a>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1">
            <!-- Wallet Overview -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Wallet</h1>
                    <div class="flex space-x-2 mt-4 md:mt-0">
                        <a href="{{ route('wallet.transactions') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Transaction History
                        </a>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-6 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-100 dark:border-green-900 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-16 w-32 h-32 bg-green-100 dark:bg-green-800 rounded-full opacity-50"></div>
                        <div class="relative">
                            <h2 class="text-lg font-medium text-green-800 dark:text-green-300 mb-2">Available Balance</h2>
                            <p class="text-3xl font-bold text-green-900 dark:text-green-200">${{ number_format($wallet->available_balance, 2) }}</p>
                            <p class="text-sm text-green-700 dark:text-green-400 mt-2">
                                @if($pendingWithdrawals > 0)
                                    <span class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        ${{ number_format($pendingWithdrawals, 2) }} pending withdrawal
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-100 dark:border-blue-900 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-16 w-32 h-32 bg-blue-100 dark:bg-blue-800 rounded-full opacity-50"></div>
                        <div class="relative">
                            <h2 class="text-lg font-medium text-blue-800 dark:text-blue-300 mb-2">This Month</h2>
                            <p class="text-3xl font-bold text-blue-900 dark:text-blue-200">${{ number_format($monthlyIncome, 2) }}</p>
                            <p class="text-sm text-blue-700 dark:text-blue-400 mt-2">Monthly income</p>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-100 dark:border-purple-900 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-16 w-32 h-32 bg-purple-100 dark:bg-purple-800 rounded-full opacity-50"></div>
                        <div class="relative">
                            <h2 class="text-lg font-medium text-purple-800 dark:text-purple-300 mb-2">Currency</h2>
                            <p class="text-3xl font-bold text-purple-900 dark:text-purple-200">{{ strtoupper($wallet->currency) }}</p>
                            <p class="text-sm text-purple-700 dark:text-purple-400 mt-2">Primary currency</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deposit Funds</h2>
                        <form action="{{ route('wallet.deposit') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" min="10" step="0.01" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white" placeholder="0.00" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <label for="currency" class="sr-only">Currency</label>
                                        <span class="h-full inline-flex items-center px-3 border-l border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 sm:text-sm">
                                            USD
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                                <select id="payment_method" name="payment_method" class="mt-1 block w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 dark:text-white" required>
                                    <option value="">Select payment method</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Deposit Funds
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Withdraw Funds</h2>
                        <form action="{{ route('wallet.withdraw') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="withdraw_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="amount" id="withdraw_amount" min="10" max="{{ $wallet->available_balance }}" step="0.01" class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white" placeholder="0.00" required>
                                    <div class="absolute inset-y-0 right-0 flex items-center">
                                        <label for="currency" class="sr-only">Currency</label>
                                        <span class="h-full inline-flex items-center px-3 border-l border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 sm:text-sm">
                                            USD
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="withdrawal_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Withdrawal Method</label>
                                <select id="withdrawal_method" name="withdrawal_method" class="mt-1 block w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm text-gray-900 dark:text-white" required>
                                    <option value="">Select withdrawal method</option>
                                    <option value="bank_account">Bank Account</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="wise">Wise Transfer</option>
                                    <option value="payoneer">Payoneer</option>
                                    <option value="skrill">Skrill</option>
                                    <option value="western_union">Western Union</option>
                                </select>
                            </div>
                            
                            <div id="mpesa-fields" class="mb-4 hidden">
                                <label for="mpesa_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">M-Pesa Phone Number</label>
                                <input type="text" id="mpesa_phone" name="mpesa_phone" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white" placeholder="e.g. 254712345678">
                            </div>
                            
                            <div id="account-details-field" class="mb-4">
                                <label for="account_details" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Details</label>
                                <textarea id="account_details" name="account_details" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white" placeholder="Enter your payment details" required></textarea>
                            </div>
                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Withdraw Funds
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Recent Transactions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Transactions</h2>
                    <a href="{{ route('wallet.transactions') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">View All</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 text-sm">
                            <tr>
                                <th class="py-3 px-4 text-left font-medium">Date</th>
                                <th class="py-3 px-4 text-left font-medium">Description</th>
                                <th class="py-3 px-4 text-left font-medium">Amount</th>
                                <th class="py-3 px-4 text-left font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($recentTransactions as $transaction)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                <td class="py-3 px-4 text-gray-600 dark:text-gray-300">
                                    {{ $transaction->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $transaction->description }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->reference }}</div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="{{ in_array($transaction->type, ['deposit', 'payment', 'refund']) ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} font-medium">
                                        {{ in_array($transaction->type, ['deposit', 'payment', 'refund']) ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($transaction->status === 'completed')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Completed</span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                    @elseif($transaction->status === 'failed')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Failed</span>
                                    @elseif($transaction->status === 'cancelled')
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-lg font-medium mb-1">No transactions yet</p>
                                        <p class="text-sm">Your transaction history will appear here</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h3 class="font-medium text-gray-900 dark:text-white mb-2">Important Information</h3>
                    <ul class="list-disc pl-5 space-y-1 text-gray-600 dark:text-gray-300 text-sm">
                        <li>Withdrawals typically take 1-3 business days to process.</li>
                        <li>There is a minimum withdrawal amount of $10.</li>
                        <li>Make sure your account details are correct before requesting a withdrawal.</li>
                        <li>Contact support if you have any questions about your transactions.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle withdrawal method selection
        const withdrawalMethodSelect = document.getElementById('withdrawal_method');
        const mpesaFields = document.getElementById('mpesa-fields');
        const accountDetailsField = document.getElementById('account-details-field');
        
        withdrawalMethodSelect.addEventListener('change', function() {
            // Reset visibility
            mpesaFields.classList.add('hidden');
            accountDetailsField.classList.remove('hidden');
            
            // Show specific fields based on selection
            if (this.value === 'mpesa') {
                mpesaFields.classList.remove('hidden');
                document.getElementById('account_details').placeholder = 'Additional notes (optional)';
                document.getElementById('account_details').required = false;
            } else {
                let placeholder = 'Enter your payment details';
                
                switch(this.value) {
                    case 'bank_account':
                        placeholder = 'Bank name, Account number, Account name, Branch/Swift code';
                        break;
                    case 'paypal':
                        placeholder = 'PayPal email address';
                        break;
                    case 'wise':
                        placeholder = 'Wise email or account details';
                        break;
                    case 'payoneer':
                        placeholder = 'Payoneer email or account ID';
                        break;
                    case 'skrill':
                        placeholder = 'Skrill email address';
                        break;
                    case 'western_union':
                        placeholder = 'Full name, address, country, phone number';
                        break;
                }
                
                document.getElementById('account_details').placeholder = placeholder;
                document.getElementById('account_details').required = true;
            }
        });
    });
</script>
@endpush

@endsection 