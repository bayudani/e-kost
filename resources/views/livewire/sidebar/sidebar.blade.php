<!-- PERBAIKAN: wire:poll ditaruh di DIV paling luar supaya selalu jalan -->
<div x-data="{ isOpen: false }" wire:poll.5s>
    
    <!-- Tombol Hamburger (Mobile) -->
    <button @click="isOpen = true" class="md:hidden fixed top-4 left-4 z-[60] p-2 bg-white text-slate-800 rounded-xl shadow-sm border border-slate-200 hover:bg-slate-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Overlay Latar Belakang Gelap -->
    <div x-show="isOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="isOpen = false" 
         class="md:hidden fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm" style="display: none;">
    </div>

    <!-- SIDEBAR UTAMA -->
    <aside 
        :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
        class="w-64 min-h-screen bg-white border-r border-slate-200 flex flex-col fixed top-0 left-0 z-50 shadow-xl md:shadow-sm transition-transform duration-300 md:translate-x-0">
        
        <!-- Header Logo -->
        <div class="h-20 flex items-center justify-between px-8 border-b border-slate-100">
            <h1 class="text-2xl font-extrabold text-blue-600 tracking-tight">
                KOST<span class="text-slate-800">PLACE</span>
                <p class="text-[10px] text-slate-500 mt-0.5 font-bold uppercase tracking-widest">
                    {{ auth()->user()->role ?? 'Guest' }}
                </p>
            </h1>

            <button @click="isOpen = false" class="md:hidden p-1 text-slate-400 hover:text-slate-600 bg-slate-50 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 px-2">
                Menu Utama
            </div>

            @foreach ($menus as $menu)
                @php
                    $isActive = request()->routeIs($menu['route'] . '*');
                @endphp

                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 font-medium relative
                    {{ $isActive
                        ? 'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-100'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    
                    {{ $menu['title'] }}

                    <!-- Badge angka - Sekarang auto update karena parent-nya polling -->
                    @if(isset($menu['show_badge']) && $menu['show_badge'] && $unreadCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-sm animate-pulse">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>

        <!-- Logout -->
        <div class="p-5 border-t border-slate-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition-colors font-semibold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar
                </button>
            </form>
        </div>

    </aside>
</div>