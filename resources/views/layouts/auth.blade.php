<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Authentication | Ajira Global')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .no-transition {
            transition: none !important;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white transition-colors duration-300">
    <div class="flex flex-col min-h-screen">
        <!-- Simplified Header -->
        <header class="bg-white dark:bg-gray-800 shadow-sm py-4 transition-colors duration-300">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Ajira Global Logo" class="h-10 w-auto">
                    <span class="text-xl font-bold ml-2 text-gray-900 dark:text-white">AjiraGlobal</span>
                </a>
                
                <!-- Theme Toggle Button -->
                <div class="flex items-center space-x-4">
                    <button 
                        id="theme-toggle"
                        class="p-2 rounded-full text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        aria-label="Toggle dark mode"
                    >
                        <!-- Sun icon (shown in dark mode) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                        </svg>
                        <!-- Moon icon (shown in light mode) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Simplified Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 py-4 transition-colors duration-300">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-600 dark:text-gray-400">&copy; {{ date('Y') }} Ajira Global. All rights reserved.</p>
                <div class="flex justify-center mt-2 space-x-4 text-sm">
                    <a href="{{ route('terms') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Terms</a>
                    <a href="{{ route('privacy') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Privacy</a>
                    <a href="{{ route('help-support') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Help</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Theme management
        document.addEventListener('DOMContentLoaded', function() {
            // Prevent transition flicker on page load
            document.body.classList.add('no-transition');
            
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
            
            // Theme toggle functionality
            function applyTheme(theme) {
                // Set theme attribute
                htmlElement.setAttribute('data-theme', theme);
                
                if (theme === 'dark') {
                    htmlElement.classList.add('dark');
                } else {
                    htmlElement.classList.remove('dark');
                }
            }
            
            // Toggle theme button
            const themeToggleBtn = document.getElementById('theme-toggle');
            
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    const currentTheme = htmlElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                    
                    localStorage.setItem('theme', newTheme);
                    applyTheme(newTheme);
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html> 