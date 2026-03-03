    @section('page_title', 'Katalog Barang')
    <div class="space-y-6 p-6">

        <!-- 🌟 Header & Search Section 🌟 -->
        <div
            class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">Katalog Barang</h2>
                <p class="text-slate-500 text-sm mt-1">Cari dan temukan barang preloved incaranmu di sini!</p>
            </div>

            <!-- Search Input -->
            <div class="relative w-full md:w-80">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl leading-5 bg-slate-50 hover:bg-white focus:bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition duration-200"
                    placeholder="Cari nama atau deskripsi barang...">
            </div>
        </div>

        <!-- 🌟 Filter Kategori Button Group 🌟 -->
        <div class="flex flex-wrap gap-2">
            <!-- Tombol "Semua" -->
            <button wire:click="setKategori('')"
                class="px-5 py-2 text-sm font-bold rounded-xl transition-all duration-200 shadow-sm
                {{ $kategori_id === '' ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                Semua
            </button>

            <!-- Tombol dari Data Kategori -->
            @foreach ($kategoris as $kat)
                <button wire:click="setKategori({{ $kat->id }})"
                    class="px-5 py-2 text-sm font-bold rounded-xl transition-all duration-200 shadow-sm capitalize
                    {{ $kategori_id == $kat->id ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                    {{ $kat->nama_kategori }}
                </button>
            @endforeach
        </div>

        <!-- 🌟 Grid Katalog Barang 🌟 -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($barangs as $item)
                <!-- Nanti anchor-nya diarahkan ke halaman detail barang -->
                <a href="{{ route('pembeli.detail', $item->id) }}"
                    class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col">

                    <!-- Box Foto Barang -->
                    <div class="aspect-square bg-slate-100 relative overflow-hidden flex items-center justify-center">
                        @if ($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <svg class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        @endif

                        <!-- Kategori Badge di pojok gambar -->
                        <div
                            class="absolute top-3 right-3 px-2 py-1 bg-white/90 backdrop-blur-sm text-[10px] font-extrabold rounded-md shadow-sm uppercase tracking-wider text-slate-700">
                            {{ $item->kategori->nama_kategori ?? '-' }}
                        </div>
                    </div>

                    <!-- Info Detail Barang -->
                    <div class="p-5 flex flex-col flex-1">
                        <h3
                            class="text-lg font-extrabold text-slate-800 line-clamp-1 group-hover:text-blue-600 transition-colors">
                            {{ $item->nama_barang }}</h3>
                        <p class="text-xl font-black text-blue-600 mt-1">Rp
                            {{ number_format($item->harga, 0, ',', '.') }}</p>

                        <!-- Info Penjual di bagian bawah Card -->
                        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center gap-2">
                            <div
                                class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">
                                {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span
                                class="text-xs font-medium text-slate-500 truncate">{{ $item->user->name ?? 'Unknown' }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <!-- State kalau barang nggak ketemu -->
                <div
                    class="col-span-full py-20 bg-white rounded-2xl border border-slate-200 text-center flex flex-col items-center">
                    <svg class="h-16 w-16 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <h3 class="text-lg font-bold text-slate-700">Waduh, barangnya nggak ketemu nih!</h3>
                    <p class="text-slate-500 text-sm mt-1">Coba cari pakai kata kunci lain atau pilih semua kategori.
                    </p>
                    @if ($search || $kategori_id)
                        <button wire:click="setKategori(''); $set('search', '')"
                            class="mt-4 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg transition-colors text-sm">
                            Reset Pencarian
                        </button>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($barangs->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $barangs->links() }}
            </div>
        @endif

    </div>
