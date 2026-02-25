<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VAR APP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @if(Auth::check() && Auth::user()->role === 'admin')
        <!-- Chart.js for Admin Dashboard -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endif

    <script>
        // Check for saved theme or system preference
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        
        /* Sidebar transition */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        
        /* Professional Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-ivory dark:bg-night-bg text-gray-800 dark:text-night-text transition-colors duration-300 font-sans antialiased overflow-x-hidden" x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('theme') === 'dark' }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 md:hidden"
         x-cloak>
    </div>

    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <x-sidebar />

        <!-- MAIN AREA -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300">
            <!-- MOBILE HEADER -->
            <header class="md:hidden bg-ivory dark:bg-night-card border-b border-gray-200 dark:border-night-border px-4 py-3 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="p-2 -ml-2 rounded-full bg-white dark:bg-gray-700 shadow-sm text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 transition-colors">
                        <!-- 4 Lines Icon Custom -->
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </button>
                    <span class="ml-3 font-bold text-gray-800 dark:text-white">VAR PANEL</span>
                </div>
                <div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-xs">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </header>

            <!-- CONTENT -->
            <main class="flex-1 p-4 md:p-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>