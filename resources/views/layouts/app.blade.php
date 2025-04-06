<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Ajira Global')</title>
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
            background-color: #111827;
            color: white;
            z-index: 50;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
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
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .user-menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: #3b82f6;
        }
        
        .user-menu-item.active {
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
            color: rgba(255, 255, 255, 0.7);
            border-left: 1px solid transparent;
            cursor: pointer;
        }
        
        .theme-toggle-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .theme-toggle-switch {
            position: relative;
            display: inline-block;
            width: 28px;
            height: 28px;
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
            background-color: #374151;
            transition: .4s;
            border-radius: 34px;
        }
        
        .theme-toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .theme-toggle-slider {
            background-color: #3b82f6;
        }
        
        input:checked + .theme-toggle-slider:before {
            transform: translateX(24px);
        }
        
        .online-status {
            display: flex;
            align-items: center;
            margin-top: 8px;
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
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                @if(auth()->user()->profile_picture)
                    <img src="{{ auth()->user()->profile_picture }}" alt="{{ auth()->user()->name }}" class="h-12 w-12 rounded-full object-cover border-2 border-blue-500">
                @else
                    <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h3 class="text-lg font-bold text-white">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-400">{{ auth()->user()->email }}</p>
                    
                    <div class="online-status">
                        <span class="status-indicator online"></span>
                        <span class="text-sm">Online for messages</span>
                    </div>
                </div>
            </div>
        </div>
        
        <nav class="mt-4">
            <a href="{{ auth()->user()->is_job_seeker ? route('jobseeker.dashboard') : route('client.dashboard') }}" class="user-menu-item {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
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
            
            <a href="#" class="user-menu-item">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                </svg>
                Stats and trends
            </a>
            
            <a href="#" class="user-menu-item">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z" clip-rule="evenodd"></path>
                    <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"></path>
                </svg>
                Membership plan
            </a>
            
            <a href="#" class="user-menu-item">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                </svg>
                Connects
            </a>
            
            <a href="#" class="user-menu-item">
                <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                Apps and Offers
            </a>
            
            <div class="theme-toggle-btn">
                <div class="flex items-center">
                    <svg class="user-menu-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <span>Theme: Dark</span>
                </div>
                <label class="theme-toggle-switch">
                    <input type="checkbox" id="sidebar-theme-toggle" checked>
                    <span class="theme-toggle-slider"></span>
                    <small class="sr-only">Toggle dark mode</small>
                </label>
            </div>
            
            <a href="#" class="user-menu-item">
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
        // Theme management
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent transition flicker on page load
            document.body.classList.add('no-transition');
            
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
            
            const htmlElement = document.documentElement;
            
            // Check for saved theme preference or use system preference
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
            
            // Apply theme
            applyTheme(currentTheme);
            
            // Update sidebar theme toggle checkbox
            const sidebarThemeToggle = document.getElementById('sidebar-theme-toggle');
            if (sidebarThemeToggle) {
                sidebarThemeToggle.checked = currentTheme === 'dark';
                
                // Add event listener for the sidebar theme toggle
                sidebarThemeToggle.addEventListener('change', function() {
                    window.toggleTheme(this.checked ? 'dark' : 'light');
                });
            }
            
            // Listen for system theme changes
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', (e) => {
                if (localStorage.getItem('theme') === 'system') {
                    const systemTheme = e.matches ? 'dark' : 'light';
                    applyTheme(systemTheme);
                }
            });
            
            // Re-enable transitions after page load
            setTimeout(() => {
                document.body.classList.remove('no-transition');
            }, 100);
            
            // Theme toggle functionality (main handler - the header buttons use this indirectly)
            function applyTheme(theme) {
                // Set theme attribute
                htmlElement.setAttribute('data-theme', theme);
                
                // Update body classes
                const body = document.getElementById('app-body');
                
                if (theme === 'dark') {
                    body.classList.add('dark:bg-gray-900', 'dark:text-white');
                    body.classList.remove('bg-gray-100', 'text-gray-900');
                    
                    // Add dark class to html for Tailwind dark mode
                    htmlElement.classList.add('dark');
                } else {
                    body.classList.remove('dark:bg-gray-900', 'dark:text-white');
                    body.classList.add('bg-gray-100', 'text-gray-900');
                    
                    // Remove dark class from html for Tailwind dark mode
                    htmlElement.classList.remove('dark');
                }
                
                // Update sidebar theme toggle button text
                const themeText = document.querySelector('.theme-toggle-btn span');
                if (themeText) {
                    themeText.textContent = `Theme: ${theme.charAt(0).toUpperCase() + theme.slice(1)}`;
                }
            }
            
            // Make theme toggle available globally
            window.toggleTheme = function(newTheme) {
                if (!newTheme) {
                    // Cycle through themes if no specific theme is provided
                    const currentTheme = htmlElement.getAttribute('data-theme');
                    if (currentTheme === 'light') {
                        newTheme = 'dark';
                    } else if (currentTheme === 'dark') {
                        newTheme = 'system';
                        // Check system preference for immediate feedback
                        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        applyTheme(prefersDark ? 'dark' : 'light');
                    } else {
                        newTheme = 'light';
                    }
                }
                
                localStorage.setItem('theme', newTheme);
                
                if (newTheme !== 'system') {
                    applyTheme(newTheme);
                    
                    // Update sidebar theme toggle if it exists
                    const sidebarThemeToggle = document.getElementById('sidebar-theme-toggle');
                    if (sidebarThemeToggle) {
                        sidebarThemeToggle.checked = newTheme === 'dark';
                    }
                }
            };
            
            // Connect desktop and mobile theme toggles to use the global function
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleMobileBtn = document.getElementById('theme-toggle-mobile');
            
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => window.toggleTheme());
            }
            
            if (themeToggleMobileBtn) {
                themeToggleMobileBtn.addEventListener('click', () => window.toggleTheme());
            }
        });
    </script>
    @yield('scripts')
</body>
</html>