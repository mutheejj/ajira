<header class="sticky top-0 z-50 bg-white dark:bg-gray-900 shadow-md transition-colors duration-300">
    <div class="container mx-auto px-4 py-3">
        <div class="flex flex-wrap items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Ajira Global Logo" class="h-10 w-10 object-cover rounded-full">
                    <span class="text-xl font-bold ml-2 text-gray-900 dark:text-white">AjiraGlobal</span>
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="flex md:hidden items-center space-x-3">
                <!-- Theme Toggle Button (Mobile) -->
                <button 
                    id="theme-toggle-mobile"
                    class="theme-toggle-button theme-toggle-checkbox flex justify-center items-center p-3 rounded-full text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors w-10 h-10 z-20 cursor-pointer relative overflow-hidden"
                    aria-label="Toggle dark mode"
                >
                    <!-- Sun icon (shown in dark mode) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                    </svg>
                    <!-- Moon icon (shown in light mode) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                </button>

                <!-- Menu Toggle Button -->
                <button 
                    id="mobile-menu-toggle" 
                    class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition-colors"
                    aria-expanded="false"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Search Form -->
            <div class="hidden md:flex md:flex-1 md:mx-6">
                <form action="{{ route('jobs.search') }}" method="GET" class="w-full flex bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Search jobs..." 
                        class="flex-grow px-4 py-2 bg-transparent focus:outline-none text-gray-900 dark:text-white"
                    >
                    <button type="submit" class="px-4 bg-transparent text-gray-500 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Desktop Navigation and User Menu -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Navigation -->
                <nav class="flex items-center space-x-6">
                    <a href="{{ route('jobs.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Find Talent</a>
                    <a href="{{ route('freelancer.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Find Work</a>
                </nav>

                <!-- Theme Toggle -->
                <button 
                    type="button" 
                    id="header-theme-toggle"
                    class="text-gray-600 dark:text-gray-300 focus:outline-none theme-toggle-checkbox" 
                    aria-label="Toggle theme"
                >
                    <!-- Sun icon (visible in dark mode) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon icon (visible in light mode) -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- User Menu / Auth Buttons -->
                @auth
                    <div class="relative" x-data="{ isOpen: false }">
                        <button 
                            @click="isOpen = !isOpen"
                            class="flex items-center space-x-1 focus:outline-none"
                        >
                            @if(auth()->user()->profile_picture)
                                <img 
                                    src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                    alt="{{ auth()->user()->name }}" 
                                    class="h-8 w-8 rounded-full object-cover"
                                >
                            @else
                                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </button>

                        <div 
                            x-show="isOpen" 
                            @click.away="isOpen = false"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 transition-all duration-150"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                        >
                            <a 
                                href="{{ auth()->user()->isJobSeeker() ? route('jobseeker.dashboard') : route('client.dashboard') }}" 
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            >
                                Dashboard
                            </a>
                            <a 
                                href="{{ route('wallet.index') }}" 
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            >
                                Wallet
                            </a>
                            <a 
                                href="{{ route('profile.edit') }}" 
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            >
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                >
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <a 
                            href="{{ route('login') }}" 
                            class="px-4 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                        >
                            Login
                        </a>
                        <a 
                            href="{{ route('register') }}" 
                            class="px-4 py-2 text-sm rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors"
                        >
                            Sign Up
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div id="mobile-menu" class="hidden mt-4 pb-2">
            <!-- Mobile Search Form -->
            <form action="{{ route('jobs.search') }}" method="GET" class="mb-4 flex bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden">
                <input 
                    type="text" 
                    name="query" 
                    placeholder="Search jobs..." 
                    class="flex-grow px-4 py-2 bg-transparent focus:outline-none text-gray-900 dark:text-white"
                >
                <button type="submit" class="px-4 bg-transparent text-gray-500 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            <!-- Mobile Navigation -->
            <nav class="flex flex-col space-y-3 mb-4">
                <a href="{{ route('jobs.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Find Talent</a>
                <a href="{{ route('freelancer.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Find Work</a>
                
                @auth
                    @if(auth()->user()->isJobSeeker())
                        <a href="{{ route('jobseeker.dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                        <a href="{{ route('applications.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">My Applications</a>
                        <a href="{{ route('saved-jobs.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Saved Jobs</a>
                    @elseif(auth()->user()->is_client)
                        <a href="{{ route('client.dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Dashboard</a>
                        <a href="{{ route('client.jobs') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">My Jobs</a>
                        <a href="{{ route('post-job') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Post a Job</a>
                    @endif

                    <a href="{{ route('wallet.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Wallet</a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Profile</a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button 
                            type="submit" 
                            class="w-full text-left text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                        >
                            Logout
                        </button>
                    </form>
                @else
                    <div class="flex flex-col space-y-2 mt-2">
                        <a 
                            href="{{ route('login') }}" 
                            class="px-4 py-2 text-center border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                        >
                            Login
                        </a>
                        <a 
                            href="{{ route('register') }}" 
                            class="px-4 py-2 text-center rounded-md bg-blue-600 text-white hover:bg-blue-700 transition-colors"
                        >
                            Sign Up
                        </a>
                    </div>
                @endauth
            </nav>
        </div>
    </div>
</header>

<script>
    // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                
                // Update aria-expanded attribute
                const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
                mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
            });
        }
        
        // Header theme toggle function
        window.toggleThemeFromHeader = function() {
            const currentTheme = localStorage.getItem('theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            window.toggleTheme(newTheme);
        };
    });
</script>