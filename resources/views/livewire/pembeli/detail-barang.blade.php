<div class="space-y-6 max-w-6xl mx-auto w-full">
    @section('page_title', 'Detail Barang')

    <!-- Kontainer Utama -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden p-5 sm:p-6 lg:p-8">
        
        <!-- Tombol Back ke Katalog -->
        <div class="mb-6">
            <a href="{{ route('pembeli.katalog') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition-colors group">
                <div class="p-1.5 rounded-lg bg-slate-50 group-hover:bg-blue-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                Kembali ke Katalog
            </a>
        </div>
        
        <!-- Grid Layout: Kiri Foto, Kanan Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            
            <!-- 📸 AREA FOTO (KIRI) -->
            <div class="w-full">
                <div class="aspect-square bg-slate-50 border border-slate-100 rounded-2xl overflow-hidden flex items-center justify-center relative shadow-sm group">
                    @if($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                    @else
                        <!-- Fallback Image Premium -->
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 to-slate-100"></div>
                        <div class="flex flex-col items-center justify-center relative z-10 text-slate-300">
                            <svg class="h-20 w-20 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-medium">Foto tidak tersedia</span>
                        </div>
                    @endif
                    
                    <!-- Badge Status Barang (Overlay) -->
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold tracking-wide border shadow-sm backdrop-blur-md
                            {{ ($barang->status ?? 'tersedia') === 'tersedia' 
                                ? 'bg-emerald-500/90 text-white border-emerald-400' 
                                : 'bg-rose-500/90 text-white border-rose-400' }}">
                            {{ ucfirst($barang->status ?? 'Tersedia') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- 📝 AREA INFO (KANAN) -->
            <div class="w-full flex flex-col h-full">
                <div class="flex-1">
                    
                    <!-- Badges (Kategori & Kondisi) -->
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold text-blue-700 bg-blue-50 border border-blue-100 uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold text-slate-600 bg-slate-100 border border-slate-200 uppercase tracking-wider">
                            {{ $barang->kondisi_barang ?? 'Bekas' }}
                        </span>
                    </div>
                    
                    <!-- Nama Barang -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight mb-3">
                        {{ $barang->nama_barang }}
                    </h1>
                    
                    <!-- Harga -->
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-lg font-semibold text-slate-500">Rp</span>
                        <span class="text-4xl font-black text-blue-600 tracking-tight">
                            {{ number_format($barang->harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <hr class="border-slate-100 mb-6">

                    <!-- Deskripsi -->
                    <div class="mb-8">
                        <h3 class="text-sm font-bold text-slate-800 mb-2.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                            Deskripsi Produk
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed bg-slate-50/50 p-4 rounded-xl border border-slate-100 whitespace-pre-line">
                            {{ $barang->deskripsi ?? 'Tidak ada deskripsi rinci untuk barang ini.' }}
                        </p>
                    </div>

                    <!-- Info Penjual (Profil Card) -->
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between gap-4 mb-8 sm:mb-0">
                        <div class="flex items-center gap-3.5">
                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-600 font-bold text-xl border border-blue-200 shadow-inner">
                                {{ strtoupper(substr($barang->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Dijual Oleh</p>
                                <p class="text-sm font-bold text-slate-800">{{ $barang->user->name ?? 'Unknown Seller' }}</p>
                            </div>
                        </div>
                        
                        <!-- Mini chat icon button di dalam card penjual (Opsional/Bisa dihapus jika tidak perlu) -->
                        <button wire:click="hubungiPenjual" class="h-10 w-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors" title="Chat Cepat">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- 🚀 BUTTON ACTIONS (Menempel di Bawah) -->
                <div class="flex flex-col sm:flex-row gap-3 mt-8 pt-6 border-t border-slate-100">
                    <button wire:click="hubungiPenjual" class="w-full sm:w-1/3 py-3.5 px-4 bg-white border border-slate-200 text-slate-700 font-semibold rounded-xl hover:bg-slate-50 hover:border-blue-300 hover:text-blue-600 transition-all flex items-center justify-center gap-2 text-sm shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Tanya Penjual
                    </button>
                    <button wire:click="beliSekarang" class="w-full sm:flex-1 py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all flex items-center justify-center gap-2 text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Beli Sekarang
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>