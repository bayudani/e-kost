<div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Kelola Barang')

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 lg:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 sm:gap-5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Kelola Barang</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1 sm:mt-1.5 font-medium">Pantau seluruh katalog barang yang diunggah pengguna.</p>
        </div>
        
        <!-- Search Input -->
        <div class="relative w-full md:w-72">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" 
                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" 
                placeholder="Cari nama barang / penjual...">
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="flex items-center justify-between p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs sm:text-sm font-medium">{{ session('message') }}</span>
            </div>
            <button wire:click="$set('message', null)" class="text-emerald-500 hover:text-emerald-700 transition-colors p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <!-- min-w-[800px] memaksa tabel tetap lebar di HP biar isinya gak kegencet -->
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                <thead class="bg-slate-50/80 border-b border-slate-200">
                    <tr class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Gambar & Info</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Kategori</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Harga</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Penjual</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Status</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($barangs as $item)
                        <tr wire:key="admin-barang-{{ $item->id }}" class="hover:bg-slate-50/80 transition-colors group">
                            
                            <!-- Kolom Gambar & Info Singkat -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-3 md:gap-4 min-w-[250px] max-w-[300px]">
                                    <!-- Box Gambar -->
                                    <div class="h-12 w-12 sm:h-14 sm:w-14 rounded-xl bg-slate-100 flex-shrink-0 border border-slate-200 overflow-hidden">
                                        @if($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-slate-300">
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- Nama Barang -->
                                    <div class="min-w-0">
                                        <div class="text-sm font-semibold text-slate-800 truncate" title="{{ $item->nama_barang }}">{{ $item->nama_barang }}</div>
                                        <div class="text-[10px] sm:text-[11px] text-slate-400 font-medium mt-0.5">ID: #{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom Kategori -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200 rounded-md text-[10px] font-bold uppercase tracking-wider">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </td>

                            <!-- Kolom Harga -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <span class="text-sm font-bold text-slate-800">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                            </td>

                            <!-- Kolom Penjual -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs border border-blue-100 flex-shrink-0">
                                        {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-700">{{ $item->user->name ?? 'Unknown' }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium">User ID: {{ $item->user_id }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom Status -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] sm:text-[11px] font-semibold tracking-wide border
                                    {{ $item->status === 'tersedia' 
                                        ? 'bg-emerald-50 text-emerald-700 border-emerald-200' 
                                        : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                                    @if($item->status === 'tersedia')
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 flex-shrink-0"></span>
                                    @else
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5 flex-shrink-0"></span>
                                    @endif
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center justify-center h-full">
                                    <!-- Tombol Delete (Merah) -->
                                    <button wire:click="deleteBarang({{ $item->id }})" 
                                        wire:confirm="Yakin Admin mau hapus barang '{{ $item->nama_barang }}' dari sistem secara permanen?"
                                        class="p-1.5 sm:p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors flex items-center justify-center" 
                                        title="Hapus Barang (Force Delete)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 sm:px-6 py-12 sm:py-16 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-2">
                                        @if($search)
                                            <!-- Ikon pencarian tidak ditemukan -->
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                        @else
                                            <!-- Ikon box kosong -->
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        @endif
                                    </div>
                                    <h3 class="text-base font-bold text-slate-800 tracking-tight">
                                        {{ $search ? 'Barang tidak ditemukan' : 'Katalog masih kosong' }}
                                    </h3>
                                    <p class="text-slate-500 font-medium text-sm">
                                        {{ $search ? 'Coba gunakan kata kunci pencarian yang lain.' : 'Belum ada pengguna yang memposting barang jualan.' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($barangs->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $barangs->links() }}
            </div>
        @endif
    </div>
</div>