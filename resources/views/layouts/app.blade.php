<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Ajira Global')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    </style>
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white transition-colors duration-300" id="app-body">
    <div class="flex flex-col min-h-screen">
        @include('layouts.header')
        
        <main class="flex-grow">
            @yield('content')
        </main>
        
        @include('layouts.footer')
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