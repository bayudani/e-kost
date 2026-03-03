<div class="space-y-6 flex-1 p-6">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h2 class="text-2xl font-black text-slate-800 uppercase italic tracking-tighter">Pesanan Masuk</h2>
        <p class="text-slate-500 text-sm mt-1">Pantau semua pesanan dan kelola pengiriman barang lu.</p>
    </div>

    <!-- List Transaksi -->
    <div class="grid grid-cols-1 gap-4">
        @forelse($transaksis as $trx)
            <div class="bg-white border-2 border-slate-200 rounded-3xl p-6 shadow-sm hover:border-blue-400 transition-all group">
                <div class="flex flex-col md:flex-row justify-between gap-6">
                    
                    <!-- Info Produk & Pembeli -->
                    <div class="flex gap-4 items-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-2xl overflow-hidden border border-slate-100 flex-shrink-0">
                            @if($trx->barang->foto)
                                <img src="{{ asset('storage/' . $trx->barang->foto) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-[10px] font-bold text-slate-300 uppercase">No Image</div>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest">Order #{{ $trx->id }}</p>
                            <h3 class="text-xl font-black text-slate-800 group-hover:text-blue-600 transition-colors">{{ $trx->barang->nama_barang }}</h3>
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 rounded-full bg-slate-200 flex items-center justify-center text-[8px] font-bold text-slate-500 italic">
                                    {{ strtoupper(substr($trx->pembeli->name ?? 'U', 0, 1)) }}
                                </div>
                                <p class="text-xs font-bold text-slate-500">Pembeli: <span class="text-slate-700">{{ $trx->pembeli->name ?? 'User' }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Status & Metode -->
                    <div class="flex flex-col justify-between items-end text-right">
                        <div>
                            <p class="text-xl font-black text-slate-800">Rp {{ number_format($trx->barang->harga, 0, ',', '.') }}</p>
                            <span class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] font-black rounded-lg uppercase tracking-tighter border border-slate-200">
                                {{ $trx->metode_pembayaran }}
                            </span>
                        </div>

                        <div class="mt-4 md:mt-0">
                            @if($trx->status_transaksi === 'Menunggu Pembayaran')
                                <span class="px-4 py-1.5 bg-amber-100 text-amber-700 text-xs font-black rounded-xl uppercase tracking-widest border border-amber-200">
                                    Menunggu Bayar
                                </span>
                            @elseif($trx->status_transaksi === 'Diverifikasi')
                                <span class="px-4 py-1.5 bg-blue-100 text-blue-700 text-xs font-black rounded-xl uppercase tracking-widest border border-blue-200">
                                    Siap Dikirim
                                </span>
                            @elseif($trx->status_transaksi === 'Selesai')
                                <span class="px-4 py-1.5 bg-emerald-100 text-emerald-700 text-xs font-black rounded-xl uppercase tracking-widest border border-emerald-200">
                                    Selesai
                                </span>
                            @else
                                <span class="px-4 py-1.5 bg-slate-100 text-slate-500 text-xs font-black rounded-xl uppercase tracking-widest border border-slate-200">
                                    {{ $trx->status_transaksi }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex gap-3">
                    <a href="{{ route('penjual.chat', ['selectedBarangId' => $trx->id_barang, 'receiverId' => $trx->id_pembeli]) }}" 
                       class="flex-1 py-3 bg-slate-800 text-white rounded-2xl font-black text-xs uppercase text-center transition-transform active:scale-95 shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Hubungi Pembeli
                    </a>
                    
                    @if($trx->status_transaksi === 'Diverifikasi' || ($trx->metode_pembayaran === 'COD' && $trx->status_transaksi === 'Menunggu Pembayaran'))
                        <div class="flex-1 py-3 bg-blue-100 text-blue-600 rounded-2xl font-black text-xs uppercase text-center border-2 border-dashed border-blue-300">
                            Menunggu Konfirmasi Terima
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-24 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm italic">Belum ada pesanan yang masuk bro. Sabar ya! ☕</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $transaksis->links() }}
    </div>
</div>