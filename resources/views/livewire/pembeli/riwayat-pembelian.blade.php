<div class="space-y-6 max-w-8xl mx-auto w-full p-6 sm:p-6 lg:p-8">
    @section('page_title', 'Riwayat Pembelian')

    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">Riwayat Pembelian</h2>
            <p class="text-sm font-medium text-slate-500 mt-1">Daftar transaksi yang sudah selesai atau dibatalkan.</p>
        </div>
        <div class="hidden sm:flex h-12 w-12 rounded-full bg-slate-50 items-center justify-center border border-slate-200 shadow-sm text-slate-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        </div>
    </div>

    <!-- List Riwayat -->
    <div class="space-y-4">
        @forelse($riwayats as $trx)
            <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col sm:flex-row gap-5 group">
                
                <!-- Thumbnail Barang -->
                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-slate-50 rounded-xl border border-slate-100 overflow-hidden flex-shrink-0 relative">
                    @if($trx->barang->foto)
                        <!-- Efek sedikit redup (opacity) karena ini barang masa lalu/history -->
                        <img src="{{ asset('storage/'.$trx->barang->foto) }}" alt="{{ $trx->barang->nama_barang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    @endif
                </div>

                <!-- Info Utama Barang -->
                <div class="flex-1 flex flex-col justify-center">
                    <!-- TRX ID & Tanggal -->
                    <div class="flex items-center gap-2.5 mb-2">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-md">
                            Transaksi #{{ $trx->id }}
                        </span>
                        <span class="text-[11px] font-medium text-slate-400 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $trx->tanggal_transaksi->format('d M Y') }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-800 leading-tight mb-2">{{ $trx->barang->nama_barang ?? 'Barang Tidak Diketahui' }}</h3>
                    
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-auto">
                        <p class="text-[11px] sm:text-xs font-medium text-slate-500">
                            Penjual: <span class="font-bold text-slate-700">{{ $trx->penjual->name ?? 'Unknown' }}</span>
                        </p>
                        <span class="hidden sm:block text-slate-300 text-xs">•</span>
                        <p class="text-[11px] sm:text-xs font-medium text-slate-500">
                            Metode: <span class="font-bold text-slate-700 uppercase">{{ $trx->metode_pembayaran }}</span>
                        </p>
                    </div>
                </div>

                <!-- Status & Harga -->
                <div class="sm:text-right flex flex-col justify-center items-start sm:items-end mt-2 sm:mt-0 sm:border-l sm:border-slate-100 sm:pl-5 flex-shrink-0">
                    <!-- Badge Status -->
                    <span class="px-3 py-1 text-[11px] font-bold rounded-full border tracking-wide mb-3 flex items-center gap-1.5
                        {{ $trx->status_transaksi === 'Selesai' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }}">
                        @if($trx->status_transaksi === 'Selesai')
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        @else
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        @endif
                        {{ $trx->status_transaksi === 'Selesai' ? 'Selesai' : 'Dibatalkan' }}
                    </span>
                    
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Total Belanja</p>
                    <p class="text-lg sm:text-xl font-black text-slate-800 tracking-tight">Rp {{ number_format($trx->barang->harga ?? 0, 0, ',', '.') }}</p>
                </div>

            </div>
        @empty
            <!-- Empty State Premium -->
            <div class="py-16 px-6 text-center bg-white rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight mb-2">Belum Ada Riwayat Transaksi</h3>
                <p class="text-slate-500 font-medium text-sm mb-6 max-w-sm mx-auto">Anda belum pernah menyelesaikan pesanan apapun. Yuk, jelajahi katalog untuk menemukan barang menarik!</p>
                <a href="{{ route('pembeli.katalog') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Cari Barang Sekarang
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination Custom UI -->
    @if ($riwayats->hasPages())
        <div class="mt-8 pt-6 border-t border-slate-100">
            {{ $riwayats->links() }}
        </div>
    @endif
</div>