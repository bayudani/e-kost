<header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center justify-between px-8 py-4">
        <div>
            @if (isset($header))
                <h2 class="font-bold text-xl text-slate-800 leading-tight">
                    {{ $header }}
                </h2>
            @else
                <h2 class="font-bold text-xl text-slate-800 leading-tight">Dashboard</h2>
            @endif
        </div>
        
        <!-- User Profile Info -->
        <div class="flex items-center gap-4">
            <div class="flex flex-col text-right">
                <span class="text-sm font-bold text-slate-700">{{ Auth::user()->name }}</span>
                <!-- Nampilin Role User, di-capitalize biar rapi -->
                <span class="text-xs text-slate-500 capitalize">{{ Auth::user()->role ?? 'Guest' }}</span>
            </div>
            <!-- Inisial Avatar Kekinian (Ngambil huruf pertama dari nama) -->
            <div class="h-10 w-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold shadow-md">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </div>
    </div>
</header>