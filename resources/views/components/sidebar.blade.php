<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
       class="fixed md:sticky top-0 left-0 h-screen w-64 bg-white dark:bg-night-card border-r border-gray-200 dark:border-night-border flex flex-col z-50 sidebar-transition shadow-lg md:shadow-none">
    
    <!-- Logo Section -->
    <div class="px-6 py-6 border-b border-gray-100 dark:border-night-border flex items-center justify-between">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-secondary dark:text-blue-400">VAR SYSTEM</h2>
            <p class="text-[10px] font-bold text-primary dark:text-orange-400 tracking-widest mt-1">
                @if(Auth::user()->role === 'admin')
                    ADMINISTRATOR
                @elseif(Auth::user()->role === 'petugas')
                    PETUGAS LAPANGAN
                @else
                    VIEWER / KARYAWAN
                @endif
            </p>
        </div>
        <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        
        @php
            $role = Auth::user()->role;
            $prefix = $role === 'admin' ? 'admin' : ($role === 'petugas' ? 'petugas' : 'viewer');
        @endphp

        <a href="{{ route($prefix . '.dashboard') }}"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
           {{ request()->routeIs($prefix . '.dashboard') 
              ? 'bg-gradient-to-r from-secondary to-blue-600 text-white shadow-md' 
              : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-secondary dark:hover:text-blue-400' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs($prefix . '.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-secondary dark:group-hover:text-blue-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </a>

        <div class="pt-6 pb-2 px-4 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider flex items-center">
            <span class="w-full border-t border-gray-200 dark:border-gray-700 mr-2"></span>
            <span>{{ $role === 'admin' ? 'Approval' : ($role === 'petugas' ? 'Modul Input' : 'Dokumen Saya') }}</span>
            <span class="w-full border-t border-gray-200 dark:border-gray-700 ml-2"></span>
        </div>

        <!-- SIMPER Link -->
        <a href="{{ route($prefix . '.simper.index') }}"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
           {{ request()->routeIs($prefix . '.simper.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-secondary dark:text-blue-400 font-semibold border-l-4 border-secondary' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            SIMPER
        </a>

        <!-- UJSIMP Link -->
        <a href="{{ route($prefix . '.ujsimp.index') }}"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
           {{ request()->routeIs($prefix . '.ujsimp.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-secondary dark:text-blue-400 font-semibold border-l-4 border-secondary' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            UJSIMP
        </a>

        <!-- CHECKUP Link -->
        <a href="{{ route($prefix . '.checkup.index') }}"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
           {{ request()->routeIs($prefix . '.checkup.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-secondary dark:text-blue-400 font-semibold border-l-4 border-secondary' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            CheckUp Kendaraan
        </a>

        <!-- RANMOR Link -->
        <a href="{{ route($prefix . '.ranmor.index') }}"
           class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group
           {{ request()->routeIs($prefix . '.ranmor.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-secondary dark:text-blue-400 font-semibold border-l-4 border-secondary' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            RANMOR
        </a>
    </nav>

    <!-- Bottom Section: User & Theme -->
    <div class="p-4 border-t border-gray-200 dark:border-night-border bg-gray-50 dark:bg-night-card/50">
        
        <!-- Theme Toggle Professional Switch -->
        <div class="flex items-center justify-between mb-4 bg-gray-200 dark:bg-gray-700 rounded-full p-1 relative">
            <div class="w-1/2 h-full absolute top-0 left-0 bg-white dark:bg-gray-600 rounded-full shadow-sm transition-transform duration-300"
                 :class="darkMode ? 'translate-x-full' : 'translate-x-0'"></div>
            
            <button @click="darkMode = false; localStorage.setItem('theme', 'light'); document.documentElement.classList.remove('dark')"
                    class="flex-1 relative z-10 flex items-center justify-center py-1.5 text-xs font-bold transition-colors duration-300"
                    :class="!darkMode ? 'text-primary' : 'text-gray-500'">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                DAY
            </button>
            
            <button @click="darkMode = true; localStorage.setItem('theme', 'dark'); document.documentElement.classList.add('dark')"
                    class="flex-1 relative z-10 flex items-center justify-center py-1.5 text-xs font-bold transition-colors duration-300"
                    :class="darkMode ? 'text-blue-400' : 'text-gray-500'">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                NIGHT
            </button>
        </div>

        <!-- User Dropdown (Sidebar Integrated) -->
        <div x-data="{ userMenuOpen: false }" class="relative">
            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center w-full hover:bg-white dark:hover:bg-gray-700 p-2 rounded-lg transition-colors">
                <div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="ml-3 text-left flex-1 overflow-hidden">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="userMenuOpen" x-collapse class="mt-2 pl-2 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-secondary dark:hover:text-blue-400 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    Profile Settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>