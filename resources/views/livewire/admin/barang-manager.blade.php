@section('page_title', 'Katalog Barang')

<!-- PERBAIKAN: Hapus p-6 di wrapper utama, ganti dengan mb-6 agar rapi -->
<div class="bg-white md:rounded-2xl shadow-sm md:border border-slate-200 overflow-hidden relative flex-1 mb-6">
    
    <!-- Header Card & Search Bar -->
    <!-- PERBAIKAN: Padding disesuaikan untuk HP (px-4 py-4) dan Desktop (md:px-8 md:py-6) -->
    <div class="px-4 md:px-8 py-4 md:py-6 border-b border-slate-100 bg-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Kelola Barang</h2>
            <p class="text-slate-500 text-xs md:text-sm mt-1">Pantau seluruh katalog barang yang diunggah pengguna.</p>
        </div>
        
        <!-- Search Input -->
        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out" placeholder="Cari nama barang atau penjual...">
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <!-- PERBAIKAN: Margin disesuaikan untuk mobile -->
        <div class="mx-4 md:mx-8 mt-4 md:mt-6 p-3 md:p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex justify-between items-center transition-all">
            <span class="font-medium text-xs md:text-sm">{{ session('message') }}</span>
            <button wire:click="$set('message', null)" class="text-emerald-700 hover:text-emerald-900 font-bold ml-4">&times;</button>
        </div>
    @endif

    <!-- Table Section -->
    <!-- PERBAIKAN: overflow-x-auto untuk tabel agar bisa di-scroll horizontal -->
    <div class="overflow-x-auto w-full px-4 md:px-8 py-4">
        <!-- min-w-[800px] memaksa tabel tetap lebar di HP biar isinya gak kegencet -->
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead class="bg-slate-50 rounded-xl">
                <tr>
                    <!-- PERBAIKAN: Padding responsif dan whitespace-nowrap -->
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider rounded-l-xl whitespace-nowrap">Gambar & Info</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Kategori</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Harga</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Penjual</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center rounded-r-xl whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($barangs as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                        
                        <!-- Kolom Gambar & Info Singkat -->
                        <td class="py-3 md:py-4 px-4 md:px-6">
                            <div class="flex items-center gap-3 md:gap-4 min-w-[250px]">
                                <!-- Box Gambar -->
                                <div class="h-12 w-12 md:h-14 md:w-14 rounded-lg bg-slate-200 flex-shrink-0 border border-slate-200 overflow-hidden flex items-center justify-center">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}" class="h-full w-full object-cover">
                                    @else
                                        <!-- Placeholder Image -->
                                        <svg class="h-6 w-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <!-- Nama Barang -->
                                <div>
                                    <div class="text-sm font-bold text-slate-800">{{ $item->nama_barang }}</div>
                                    <div class="text-[10px] md:text-xs text-slate-500 mt-0.5 truncate w-32 md:w-48" title="{{ $item->deskripsi }}">{{ Str::limit($item->deskripsi, 30) }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Kolom Kategori -->
                        <td class="py-3 md:py-4 px-4 md:px-6 whitespace-nowrap">
                            <span class="text-sm text-slate-600 font-medium capitalize">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                        </td>

                        <!-- Kolom Harga -->
                        <td class="py-3 md:py-4 px-4 md:px-6 whitespace-nowrap">
                            <span class="text-sm font-bold text-slate-800">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </td>

                        <!-- Kolom Penjual -->
                        <td class="py-3 md:py-4 px-4 md:px-6 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-700">{{ $item->user->name ?? 'Unknown' }}</span>
                                <span class="text-[10px] md:text-xs text-slate-400">ID: {{ $item->user_id }}</span>
                            </div>
                        </td>

                        <!-- Kolom Status -->
                        <td class="py-3 md:py-4 px-4 md:px-6 whitespace-nowrap">
                            <span class="px-3 py-1.5 text-[10px] md:text-xs font-bold rounded-lg 
                                {{ $item->status === 'tersedia' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>

                        <!-- Kolom Aksi -->
                        <!-- PERBAIKAN: Hapus class flex dan mt-4 pada <td> yang bikin tombolnya turun berantakan -->
                        <td class="py-3 md:py-4 px-4 md:px-6 whitespace-nowrap">
                            <div class="flex justify-center items-center h-full">
                                <!-- Tombol Delete -->
                                <button 
                                    wire:click="deleteBarang({{ $item->id }})" 
                                    wire:confirm="Yakin mau hapus barang '{{ $item->nama_barang }}' ini?"
                                    class="p-1.5 md:p-2 text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors flex items-center justify-center" 
                                    title="Hapus Barang">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 md:py-16 text-center">
                            <svg class="mx-auto h-10 w-10 md:h-12 md:w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-slate-500 text-sm md:text-base font-medium">Belum ada barang yang di-upload.</p>
                            @if($search)
                                <p class="text-slate-400 text-xs md:text-sm mt-1">Coba cari dengan kata kunci lain.</p>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($barangs->hasPages())
        <div class="px-4 md:px-8 py-4 border-t border-slate-100 bg-slate-50">
            {{ $barangs->links() }}
        </div>
    @endif

</div>