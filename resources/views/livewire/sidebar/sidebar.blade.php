<!-- PERBAIKAN: wire:poll ditaruh di DIV paling luar supaya selalu jalan -->
<div x-data="{ isOpen: false }" wire:poll.5s>
    
    <!-- Tombol Hamburger (Mobile) -->
    <button @click="isOpen = true" 
            class="md:hidden fixed top-4 left-4 z-[60] p-2.5 bg-white text-slate-700 rounded-xl shadow-md border border-slate-200 hover:bg-slate-50 hover:text-blue-600 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Overlay Latar Belakang Gelap untuk Mobile -->
    <div x-show="isOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="isOpen = false" 
         class="md:hidden fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm" 
         style="display: none;">
    </div>

    <!-- SIDEBAR UTAMA -->
    <aside 
        :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
        class="w-72 min-h-screen bg-white border-r border-slate-200 flex flex-col fixed top-0 left-0 z-50 shadow-2xl md:shadow-none transition-transform duration-300 md:translate-x-0">
        
        <!-- Header Logo (Lebih padat ke atas seperti referensi) -->
        <div class="h-20 flex items-center px-6 border-b border-slate-100 flex-shrink-0">
            <a href="#" class="flex items-center gap-3 group">
                <!-- Ikon Logo Ala Referensi E-Absensi -->
                   <div class="bg-blue-600 text-white p-2 rounded-xl group-hover:bg-blue-700 transition-colors shadow-sm shadow-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                    KOST<span class="text-blue-600">PLACE</span>
                </h1>
            </a>

            <!-- Tombol Close Mobile -->
            <button @click="isOpen = false" class="md:hidden ml-auto p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-5 space-y-2 overflow-y-auto custom-scrollbar">
            
            <!-- Jika mau nambah menu statis Dashboard seperti di gambar referensi, bisa uncomment di bawah ini -->
            <!-- 
            <a href="#" class="group flex items-center gap-4 px-4 py-3.5 rounded-xl transition-all duration-300 font-semibold bg-blue-600 text-white shadow-lg shadow-blue-600/30 mb-6">
                <span class="text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                </span>
                <span class="flex-1 text-[15px]">Dashboard</span>
            </a> 
            -->

            <!-- Kategori Header -->
            <div class="px-4 mb-4 mt-2">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                    Menu
                </p>
            </div>

            @foreach ($menus as $menu)
                @php
                    $isActive = request()->routeIs($menu['route'] . '*');
                @endphp

                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                   class="group flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 font-semibold
                   {{ $isActive
                       ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20'
                       : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
                    
                    <!-- Mapping Ikon Berdasarkan String Ikon dari PHP -->
                    <span class="{{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-blue-500' }} transition-colors">
                        @switch($menu['icon'] ?? '')
                            @case('katalog')
                            @case('barang')
                                <!-- Ikon Kotak / Cube -->
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                @break

                            @case('chat')
                                <!-- Ikon Chat Bubble -->
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                                @break

                            @case('transaksi')
                                <!-- Ikon Clipboard / Dokumen -->
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                                @break

                            @case('riwayat')
                                <!-- Ikon Jam / Riwayat -->
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @break
                                
                            @case('user')
                                <!-- Ikon User Group -->
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                @break

                            @case('kategori')
                                <!-- Ikon Tag Label -->
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                                @break

                            @case('verifikasi')
                                <!-- Ikon Perisai Centang -->
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                @break

                            @default
                                <!-- Ikon Default Bulat kalau tidak ada -->
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m-4-4h8" /></svg>
                        @endswitch
                    </span>

                    <span class="flex-1 text-[14.5px]">{{ $menu['title'] }}</span>

                    <!-- Badge Notification -->
                    @if(isset($menu['show_badge']) && $menu['show_badge'] && $unreadCount > 0)
                        <div class="flex items-center justify-center min-w-[24px] h-6 px-1.5 {{ $isActive ? 'bg-white text-blue-600' : 'bg-red-500 text-white' }} text-[11px] font-bold rounded-full shadow-sm relative">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            <!-- Ping Animation -->
                            <span class="absolute flex h-3 w-3 -top-1 -right-1">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $isActive ? 'bg-white' : 'bg-red-400' }} opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 {{ $isActive ? 'bg-white' : 'bg-red-500' }} border-2 {{ $isActive ? 'border-blue-600' : 'border-white' }}"></span>
                            </span>
                        </div>
                    @endif
                </a>
            @endforeach
        </nav>

        <!-- Footer / User Profile & Logout -->
        <div class="p-5 border-t border-slate-100 bg-white">
            <!-- User Info -->
            <div class="flex items-center gap-3 px-2 py-2 mb-4">
                <div class="h-10 w-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold border border-blue-100 flex-shrink-0">
                    {{ substr(auth()->user()->name ?? 'G', 0, 1) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-semibold text-slate-800 truncate">
                        {{ auth()->user()->name ?? 'Guest User' }}
                    </p>
                    <p class="text-[11px] font-medium text-slate-500 truncate uppercase tracking-wider">
                        {{ auth()->user()->role ?? 'Visitor' }}
                    </p>
                </div>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-slate-600 bg-white border border-slate-200 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 rounded-xl transition-all duration-200 font-semibold text-sm shadow-sm group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 group-hover:text-rose-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>

    </aside>
</div>