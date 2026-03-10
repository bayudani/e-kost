<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KostPlace') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <!-- FIX: Cuma load CSS aja dari Vite. JS-nya kita off-in biar Alpine bawaan Laravel ga nabrak Alpine bawaan Livewire -->
        @vite(['resources/css/app.css'])
        
        @livewireStyles
    </head>
    <!-- PERBAIKAN: Tambah bg-slate-50 agar ada kontras antara background aplikasi dengan card/header putih -->
    <body class="font-sans antialiased text-slate-900 bg-slate-50">
        
        <!-- PERBAIKAN: Hapus p-6 di sini supaya layar bisa full ujung ke ujung -->
        <div class="flex min-h-screen">
            
            <!-- Sidebar Component -->
            <livewire:sidebar />

            <!-- Main Content Area -->
            <!-- PERBAIKAN: Ubah md:ml-64 menjadi md:ml-72 karena sidebar kita lebarnya w-72 -->
            <div class="flex-1 md:ml-72 flex flex-col min-h-screen transition-all duration-300">
                
                <!-- 🌟 Header / Topbar 🌟 -->
                <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm h-20 flex items-center">
                    <div class="w-full flex items-center justify-between px-4 sm:px-6 lg:px-8">
                        
                        <!-- Nama Halaman Dinamis -->
                        <!-- PERBAIKAN: pl-12 di mobile agar teks tidak tertimpa tombol Hamburger Menu Sidebar -->
                        <div class="pl-12 md:pl-0">
                            <h2 class="font-bold text-xl sm:text-2xl text-slate-800 leading-tight tracking-tight">
                                @if (isset($header))
                                    {{ $header }}
                                @else
                                    @yield('page_title', 'Dashboard')
                                @endif
                            </h2>
                        </div>
                        
                        <!-- User Profile Info -->
                        <div class="flex items-center gap-3 sm:gap-4">
                            <!-- Nama & Role (Disembunyikan di HP biar ga sempit, muncul di layar tablet/laptop) -->
                            <div class="hidden sm:flex flex-col text-right">
                                <span class="text-sm font-bold text-slate-700">{{ Auth::user()->name ?? 'Guest User' }}</span>
                                <span class="text-xs font-medium text-slate-500 capitalize">{{ Auth::user()->role ?? 'Visitor' }}</span>
                            </div>
                            
                            <!-- Inisial Avatar Kekinian -->
                            <div class="h-10 w-10 sm:h-11 sm:w-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-blue-500/30 border-2 border-white ring-2 ring-slate-100 transition-transform hover:scale-105 cursor-pointer">
                                {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                            </div>
                        </div>
                        
                    </div>
                </header>

                <!-- Page Content -->
                <main class="p-4 sm:p-6 lg:p-8 flex-1 flex flex-col w-full">
                    {{ $slot }}
                </main>

            </div>
        </div>

        @livewireScripts
    </body>
</html>