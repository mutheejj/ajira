<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Ajira Global')</title>
    
    <!-- Immediately apply the theme before page renders to prevent flashing -->
    <script>
        // Get theme from localStorage or use system preference
        const savedTheme = localStorage.getItem('theme');
        let currentTheme;
        
        if (savedTheme) {
            currentTheme = savedTheme;
        } else {
            // Check system preference
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            currentTheme = prefersDark ? 'dark' : 'light';
            localStorage.setItem('theme', currentTheme);
        }
        
        // Apply theme immediately before content renders
        if (currentTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        
        // Set an attribute for additional styling
        document.documentElement.setAttribute('data-theme', currentTheme);
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Theme transition styles */
        *, *::before, *::after {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Disable transitions for specific elements that might cause flicker */
        .no-transition {
            transition: none !important;
        }
        
        /* Theme toggle button styles */
        .theme-toggle-button {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .theme-toggle-button.processing {
            opacity: 0.6 !important;
            pointer-events: none !important;
            cursor: not-allowed !important;
        }
        
        /* Select2 styles */
        .select2-container--default .select2-selection--multiple {
            border-color: rgb(209, 213, 219);
            border-radius: 0.375rem;
        }
        .dark .select2-container--default .select2-selection--multiple {
            background-color: rgb(55, 65, 81);
            border-color: rgb(75, 85, 99);
        }
        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgb(75, 85, 99);
            color: white;
            border-color: rgb(107, 114, 128);
        }
        .dark .select2-dropdown {
            background-color: rgb(55, 65, 81);
            color: white;
        }
        .dark .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: rgb(75, 85, 99);
        }
        .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: rgb(79, 70, 229);
        }
        .select2-container {
            z-index: 9999;
        }
        
        /* User Sidebar Menu Styles */
        .user-sidebar {
            position: fixed;
            left: 0;
            top: 0; /* Will be set dynamically via JS */
            height: calc(100vh - var(--header-height, 0px));
            width: 280px;
            background-color: #ffffff;
            color: #000000;
            z-index: 50;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out, background-color 0.3s ease, color 0.3s ease;
            overflow-y: auto;
        }
        
        .dark .user-sidebar {
            background-color: #111827;
            color: #ffffff;
        }
        
        .user-sidebar.show {
            transform: translateX(0);
        }
        
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 49;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }
        
        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }
        
        .user-menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(0, 0, 0, 0.7);
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .dark .user-menu-item {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .user-menu-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: rgba(0, 0, 0, 0.9);
            border-left-color: #3b82f6;
        }
        
        .dark .user-menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: #3b82f6;
        }
        
        .user-menu-item.active {
            background-color: rgba(59, 130, 246, 0.1);
            color: rgba(0, 0, 0, 0.9);
            border-left-color: #3b82f6;
        }
        
        .dark .user-menu-item.active {
            background-color: rgba(59, 130, 246, 0.2);
            color: white;
            border-left-color: #3b82f6;
        }
        
        .user-menu-icon {
            width: 24px;
            height: 24px;
            margin-right: 12px;
        }
        
        .theme-toggle-btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.5rem;
            color: rgba(0, 0, 0, 0.7);
            border-left: 1px solid transparent;
            cursor: pointer;
        }
        
        .dark .theme-toggle-btn {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .theme-toggle-btn:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: rgba(0, 0, 0, 0.9);
        }
        
        .dark .theme-toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .theme-toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }
        
        .theme-toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .theme-toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #f3f4f6;
            transition: .4s;
            border-radius: 34px;
        }
        
        .dark .theme-toggle-slider {
            background-color: #374151;
        }
        
        .theme-toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: #3b82f6;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .theme-toggle-slider {
            background-color: #3b82f6;
        }
        
        input:checked + .theme-toggle-slider:before {
            transform: translateX(20px);
            background-color: white;
        }
        
        .online-status {
            display: flex;
            align-items: center;
            margin-top: 8px;
            color: rgba(0, 0, 0, 0.7);
        }
        
        .dark .online-status {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-indicator.online {
            background-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white transition-colors duration-300" id="app-body" x-data="{ sidebarOpen: false }">
    <!-- User Sidebar Menu (for authenticated users) -->
    @auth
    <div class="sidebar-overlay" :class="{ 'show': sidebarOpen }" @click="sidebarOpen = false"></div>
    <div class="user-sidebar" :class="{ 'show': sidebarOpen }">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ auth()->user()->name }}" class="h-12 w-12 rounded-full object-cover border-2 border-blue-500">
                @else
                    <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
                    
                    <div class="online-status">
                        <span class="status-indicator online"></span>
                        <span class="text-sm">Online for messages</span>
                    </div>
                </div>
            </div>
        </div>
        
        <nav class="mt-4">
            <a href="{{ auth()->user()->isJobSeeker() ? route('jobseeker.dashboard') : route('client.dashboard') }}" class="user-menu-item {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                Dashboard
            </a>
            
            <a href="{{ route('profile.edit') }}" class="user-menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                </svg>
                Your profile
            </a>
            
            @if(auth()->user()->user_type === 'job-seeker')
            <a href="{{ route('applications.my') }}" class="user-menu-item {{ request()->routeIs('applications.*') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                </svg>
                My Applications
            </a>
            
            <a href="{{ route('saved-jobs.index') }}" class="user-menu-item {{ request()->routeIs('saved-jobs.*') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                </svg>
                Saved Jobs
            </a>
            
            <a href="{{ route('jobs.index') }}" class="user-menu-item {{ request()->routeIs('jobs.*') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                </svg>
                Find Jobs
            </a>
            
            <a href="{{ route('jobseeker.tasks') }}" class="user-menu-item {{ request()->routeIs('jobseeker.tasks') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                </svg>
                Active Tasks
            </a>
            
            <a href="{{ route('jobseeker.worklog') }}" class="user-menu-item {{ request()->routeIs('jobseeker.worklog') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                Work Log
            </a>
            @endif
            
            @if(auth()->user()->user_type === 'client')
            <a href="{{ route('client.jobs') }}" class="user-menu-item {{ request()->routeIs('client.jobs*') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                </svg>
                My Jobs
            </a>
            
            <a href="{{ route('client.jobs.create') }}" class="user-menu-item {{ request()->routeIs('client.jobs.create') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                Post a Job
            </a>
            
            <a href="{{ route('client.applications') }}" class="user-menu-item {{ request()->routeIs('client.applications') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                </svg>
                Received Applications
            </a>
            
            <a href="{{ route('client.active-contracts') }}" class="user-menu-item {{ request()->routeIs('client.active-contracts') ? 'active' : '' }}">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                </svg>
                Active Contracts
            </a>
            @endif
            
            <a href="#" class="user-menu-item">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                </svg>
                Stats and trends
            </a>
            
            <div class="theme-toggle-btn">
                <div class="flex items-center">
                    <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <span id="theme-text">Theme: Dark</span>
                </div>
                <label class="theme-toggle-switch">
                    <input type="checkbox" id="sidebar-theme-toggle">
                    <span class="theme-toggle-slider"></span>
                    <small class="sr-only">Toggle dark mode</small>
                </label>
            </div>
            
            <a href="{{ route('settings') }}" class="user-menu-item">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                </svg>
                Account settings
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="user-menu-item w-full text-left">
                    <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414l-5.707-5.707A1 1 0 009.586 1H3zm9 3.586V3h-5v5h5V6.586z" clip-rule="evenodd"></path>
                    </svg>
                    Log out
                </button>
            </form>
        </nav>
    </div>
    @endauth
    
    <div class="flex flex-col min-h-screen">
        @include('layouts.header')
        
        <main class="flex-grow">
            @yield('content')
        </main>
        
        @include('layouts.footer')
    </div>
    
    <!-- User Menu Toggle Button (Visible only when authenticated) -->
    @auth
    <button
        class="fixed bottom-6 left-6 z-40 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
        @click="sidebarOpen = !sidebarOpen"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>
    @endauth
    
    <script>
        // Enhanced theme management with persistent state
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize variables
            const htmlElement = document.documentElement;
            const body = document.getElementById('app-body');
            
            // Set sidebar position below header
            const headerElement = document.querySelector('header');
            const userSidebar = document.querySelector('.user-sidebar');
            
            if (headerElement && userSidebar) {
                const headerHeight = headerElement.offsetHeight;
                document.documentElement.style.setProperty('--header-height', headerHeight + 'px');
                userSidebar.style.top = headerHeight + 'px';
                
                // Update on window resize
                window.addEventListener('resize', function() {
                    const updatedHeaderHeight = headerElement.offsetHeight;
                    document.documentElement.style.setProperty('--header-height', updatedHeaderHeight + 'px');
                    userSidebar.style.top = updatedHeaderHeight + 'px';
                });
            }
            
            // Get current theme (now just for UI updates, theme already applied)
            const currentTheme = htmlElement.getAttribute('data-theme');
            
            // Update sidebar theme toggle checkbox
            const sidebarThemeToggle = document.getElementById('sidebar-theme-toggle');
            if (sidebarThemeToggle) {
                sidebarThemeToggle.checked = currentTheme === 'dark';
                
                // Add event listener for the sidebar theme toggle
                sidebarThemeToggle.addEventListener('change', function() {
                    toggleTheme(this.checked ? 'dark' : 'light');
                });
            }
            
            // Update all theme toggles to reflect current state
            const themeToggles = document.querySelectorAll('.theme-toggle-checkbox');
            themeToggles.forEach(toggle => {
                if (toggle.type === 'checkbox') {
                    toggle.checked = currentTheme === 'dark';
                }
                
                toggle.addEventListener('click', function() {
                    const newTheme = htmlElement.classList.contains('dark') ? 'light' : 'dark';
                    toggleTheme(newTheme);
                });
            });
            
            // Function to toggle the theme
            window.toggleTheme = function(theme) {
                const htmlElement = document.documentElement;
                
                // Apply theme class to html element
                if (theme === 'dark') {
                    htmlElement.classList.add('dark');
                } else {
                    htmlElement.classList.remove('dark');
                }
                
                // Update theme in local storage
                localStorage.setItem('theme', theme);
                
                // Update attribute for additional styling
                htmlElement.setAttribute('data-theme', theme);
                
                // Update theme text in sidebar
                const themeText = document.getElementById('theme-text');
                if (themeText) {
                    themeText.textContent = `Theme: ${theme.charAt(0).toUpperCase() + theme.slice(1)}`;
                }
                
                // Update all toggle checkboxes to keep them in sync
                const themeToggles = document.querySelectorAll('.theme-toggle-checkbox');
                themeToggles.forEach(toggle => {
                    if (toggle.type === 'checkbox') {
                        toggle.checked = theme === 'dark';
                    }
                });
            };

            // Mobile menu toggle functionality
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    this.setAttribute('aria-expanded', mobileMenu.classList.contains('hidden') ? 'false' : 'true');
                });
            }
            
            // Mobile theme toggle
            const mobileThemeToggle = document.getElementById('theme-toggle-mobile');
            if (mobileThemeToggle) {
                mobileThemeToggle.addEventListener('click', function() {
                    const newTheme = htmlElement.classList.contains('dark') ? 'light' : 'dark';
                    toggleTheme(newTheme);
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>