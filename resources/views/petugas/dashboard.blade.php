@extends('layouts.petugas')

@section('content')
<div x-data="{
    time: new Date(),
    init() {
        setInterval(() => {
            this.time = new Date();
        }, 1000);
    },
    get formattedDate() {
        return this.time.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    },
    get formattedTime() {
        return this.time.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
    }
}" class="space-y-8">

    <!-- WELCOME HEADER -->
    <div class="bg-gradient-to-r from-secondary to-blue-600 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Selamat Datang, {{ Auth::user()->name }}</h1>
            <p class="text-blue-100 text-lg mb-6">Panel Petugas Lapangan</p>
            
            <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-6 bg-white/10 backdrop-blur-sm p-4 rounded-xl inline-flex border border-white/20">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span x-text="formattedDate" class="font-semibold"></span>
                </div>
                <div class="hidden md:block w-px h-6 bg-white/30"></div>
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-text="formattedTime" class="font-mono font-bold text-xl tracking-wider"></span>
                </div>
            </div>
        </div>
        
        <!-- Decorative Background Pattern -->
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
    </div>

    <!-- MENU GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- SIMPER CARD -->
        <a href="{{ route('petugas.simper.index') }}" class="group relative bg-white dark:bg-night-card rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-night-border h-48 flex flex-col justify-between p-6">
            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 dark:bg-blue-900/20 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110 duration-500"></div>
            
            <div class="relative z-10 flex justify-between items-start">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-xl text-secondary dark:text-blue-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div class="bg-secondary text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-2 group-hover:translate-x-0">
                    Input Data
                </div>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-secondary dark:group-hover:text-blue-400 transition-colors">SIMPER</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Surat Izin Masuk Perusahaan</p>
            </div>
            
            <div class="absolute bottom-0 left-0 w-full h-1 bg-secondary transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
        </a>

        <!-- UJSIMP CARD -->
        <a href="{{ route('petugas.ujsimp.index') }}" class="group relative bg-white dark:bg-night-card rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-night-border h-48 flex flex-col justify-between p-6">
            <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 dark:bg-orange-900/20 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110 duration-500"></div>
            
            <div class="relative z-10 flex justify-between items-start">
                <div class="p-3 bg-orange-100 dark:bg-orange-900/30 rounded-xl text-primary dark:text-orange-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div class="bg-primary text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-2 group-hover:translate-x-0">
                    Input Data
                </div>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-primary dark:group-hover:text-orange-400 transition-colors">UJSIMP</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ujian SIM Perusahaan</p>
            </div>
            
            <div class="absolute bottom-0 left-0 w-full h-1 bg-primary transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
        </a>

        <!-- CHECKUP CARD -->
        <a href="{{ route('petugas.checkup.index') }}" class="group relative bg-white dark:bg-night-card rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-night-border h-48 flex flex-col justify-between p-6">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 dark:bg-emerald-900/20 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110 duration-500"></div>
            
            <div class="relative z-10 flex justify-between items-start">
                <div class="p-3 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl text-emerald-600 dark:text-emerald-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="bg-emerald-500 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-2 group-hover:translate-x-0">
                    Input Data
                </div>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">CHECKUP KENDARAAN</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pemeriksaan Kelayakan Kendaraan</p>
            </div>
            
            <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
        </a>

        <!-- RANMOR CARD -->
        <a href="{{ route('petugas.ranmor.index') }}" class="group relative bg-white dark:bg-night-card rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-night-border h-48 flex flex-col justify-between p-6">
            <div class="absolute top-0 right-0 w-32 h-32 bg-violet-50 dark:bg-violet-900/20 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110 duration-500"></div>
            
            <div class="relative z-10 flex justify-between items-start">
                <div class="p-3 bg-violet-100 dark:bg-violet-900/30 rounded-xl text-violet-600 dark:text-violet-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="bg-violet-500 text-white text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-2 group-hover:translate-x-0">
                    Input Data
                </div>
            </div>
            
            <div class="relative z-10">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">CHECK FISIK RANMOR</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pemeriksaan Fisik Kendaraan Bermotor</p>
            </div>
            
            <div class="absolute bottom-0 left-0 w-full h-1 bg-violet-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
        </a>
        
    </div>

</div>
@endsection