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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-white text-slate-900">
        
        <div class="flex min-h-screen">
            
            <!-- Sidebar Component -->
            <livewire:sidebar />

            <!-- Main Content Area -->
            <!-- PERBAIKAN: Ubah ml-64 menjadi md:ml-64 agar di HP tampilannya full width -->
            <div class="flex-1 md:ml-64 flex flex-col min-h-screen transition-all duration-300">
                
                <!-- 🌟 Header / Topbar 🌟 -->
                <header class="bg-white sticky top-0 z-40 px-6 md:px-8 py-6">
                    <div class="flex items-center justify-between">
                        <!-- Nama Halaman Dinamis -->
                        <div>
                            <!-- PERBAIKAN: Tambahkan ml-10 di HP agar judul tidak tertutup tombol Hamburger Menu -->
                            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter italic ml-10 md:ml-0">
                                {{-- @yield('page_title', 'Dashboard') --}}
                            </h2>
                        </div>
                        
                        <!-- Tombol Logout di Pojok Kanan Atas -->
                        <div class="flex items-center">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors p-2 rounded-full hover:bg-red-50" title="Keluar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <!-- PERBAIKAN: Padding disesuaikan untuk mobile -->
                <main class="p-4 md:p-6 flex-1 flex flex-col">
                    {{ $slot }}
                </main>

            </div>
        </div>

        @livewireScripts
    </body>
</html>