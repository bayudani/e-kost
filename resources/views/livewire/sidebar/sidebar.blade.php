<aside class="w-64 min-h-screen bg-white border-r border-slate-200 flex flex-col fixed top-0 left-0 z-50 shadow-sm">

    <!-- Header Logo -->
    <div class="h-20 flex items-center px-8 border-b border-slate-100">
        <h1 class="text-2xl font-extrabold text-blue-600 tracking-tight">
            KOST<span class="text-slate-800">PLACE</span>
            {{-- role --}}
            <p class="text-sm text-gray-800 mt-2 font-medium capitalize">
                {{ auth()->user()->role ?? 'Guest' }}
            </p>
        </h1>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 px-2">
            Menu {{ auth()->user()->role ?? '' }}
        </div>

        @foreach ($menus as $menu)
            @php
                $isActive = request()->routeIs($menu['route'] . '*');
            @endphp

            <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 font-medium
               {{ $isActive
                   ? 'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-100'
                   : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                {{ $menu['title'] }}
            </a>
        @endforeach
    </nav>

    <!-- Logout -->
    <div class="p-5 border-t border-slate-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition-colors font-semibold text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>

</aside>
