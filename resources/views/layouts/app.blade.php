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

    @vite(['resources/css/app.css'])

    @livewireStyles
</head>

<body class="font-sans antialiased text-slate-900 bg-slate-50">

    <div class="flex min-h-screen">

        <!-- Sidebar Component -->
        <livewire:sidebar />

        <!-- Main Content Area -->
        <div class="flex-1 md:ml-72 flex flex-col min-h-screen transition-all duration-300">

            

            <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm h-20 flex items-center">
                <div class="w-full flex items-center justify-between px-4 sm:px-6 lg:px-8">

                    <!-- Nama Halaman Dinamis -->
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
                            <span
                                class="text-sm font-bold text-slate-700">{{ Auth::user()->name ?? 'Guest User' }}</span>
                            <span
                                class="text-xs font-medium text-slate-500 capitalize">{{ Auth::user()->role ?? 'Visitor' }}</span>
                        </div>

                        <!-- Inisial Avatar Kekinian -->
                        <div
                            class="h-10 w-10 sm:h-11 sm:w-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-md shadow-blue-500/30 border-2 border-white ring-2 ring-slate-100 transition-transform hover:scale-105 cursor-pointer">
                            <a href="{{ route('profil') }}">
                                {{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            @if(auth()->user()->role === 'penjual')
            @if (empty(auth()->user()->no_hp) || empty(auth()->user()->no_rekening) || empty(auth()->user()->atas_nama))
                <div
                    class="bg-rose-50 border border-rose-200 p-4 sm:p-5 rounded-2xl flex flex-col md:flex-row md:items-center justify-between shadow-sm animate-pulse gap-4 mt-16 mx-4">
                    <div class="flex items-start md:items-center gap-3 md:gap-4">
                        <div class="p-2 bg-rose-100 rounded-full flex-shrink-0 mt-0.5 md:mt-0">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-rose-800 leading-relaxed">
                            <span class="font-black text-rose-900">Tindakan Diperlukan!</span> Anda belum melengkapi
                            Data Pencairan (No HP, Rekening, & Atas Nama). Informasi ini <span
                                class="font-bold underline">wajib</span> agar Admin dapat mentransfer uang penjualan ke
                            rekening Anda.
                        </p>
                    </div>
                    <a href="{{ route('profil') }}"
                        class="w-full md:w-auto px-6 py-3 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm hover:shadow-md text-center whitespace-nowrap flex items-center justify-center gap-2">
                        Lengkapi Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            @endif
            @endif

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8 flex-1 flex flex-col w-full">
                {{ $slot }}
            </main>

        </div>
    </div>

    @livewireScripts
</body>

</html>
