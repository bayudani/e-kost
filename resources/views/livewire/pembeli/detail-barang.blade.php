@section('page_title', 'Detail barang')

<div class="max-w-5xl mx-auto py-8 p-6 ">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden p-8">
        <!-- Tombol Back ke Katalog -->
    <div class="mt-2">
        <a href="{{ route('pembeli.katalog') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>
    </div>
        <!-- Grid Layout: Kiri Foto, Kanan Detail -->
        <div class="flex flex-col md:flex-row gap-10 mt-4">
            
            
            <div class="w-full md:w-1/2">
                <div class="aspect-square bg-slate-50 border-2 border-slate-100 rounded-2xl overflow-hidden flex items-center justify-center relative">
                    @if($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center opacity-10">
                            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <line x1="0" y1="0" x2="100" y2="100" stroke="black" stroke-width="1"/>
                                <line x1="100" y1="0" x2="0" y2="100" stroke="black" stroke-width="1"/>
                            </svg>
                        </div>
                        <svg class="h-20 w-20 text-slate-300 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    @endif
                </div>
            </div>

            <!-- 📝 AREA INFO (KANAN) -->
            <div class="w-full md:w-1/2 flex flex-col justify-between">
                <div>
                    <!-- Kategori -->
                    <p class="text-sm font-bold text-blue-500 uppercase tracking-widest mb-2">
                        {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                    </p>
                    
                    <!-- Nama Barang -->
                    <h1 class="text-4xl font-black text-slate-800 leading-tight mb-4">
                        {{ $barang->nama_barang }}
                    </h1>
                    
                    <!-- Harga -->
                    <p class="text-3xl font-black text-blue-600 italic mb-8">
                        Rp {{ number_format($barang->harga, 0, ',', '.') }}
                    </p>

                    <!-- Deskripsi -->
                    <div class="space-y-2 mb-8">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi Barang:</p>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $barang->deskripsi ?? 'Tidak ada deskripsi barang.' }}
                        </p>
                    </div>

                    <!-- Info Penjual -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center gap-4 mb-8">
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl">
                            {{ strtoupper(substr($barang->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Penjual:</p>
                            <p class="text-lg font-bold text-slate-800">{{ $barang->user->name ?? 'Unknown Seller' }}</p>
                        </div>
                    </div>
                </div>

                <!-- 🚀 BUTTON ACTIONS -->
                <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                    <button wire:click="beliSekarang" class="flex-1 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-200 transition-all uppercase tracking-widest text-center">
                        Beli Sekarang
                    </button>
                    <button wire:click="hubungiPenjual" class="px-8 py-4 bg-white border-2 border-blue-600 text-blue-600 font-black rounded-2xl hover:bg-blue-50 transition-all uppercase tracking-widest text-center">
                        Chat
                    </button>
                </div>
            </div>

        </div>
    </div>

    
</div>