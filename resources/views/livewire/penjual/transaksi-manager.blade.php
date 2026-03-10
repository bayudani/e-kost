<div class="space-y-6 max-w-8xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Pesanan Masuk')
    
    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight">Kelola Transaksi</h2>
        <p class="text-sm font-medium text-slate-500 mt-1">Meliihat Pesanan Masuk.</p>
    </div>

    <!-- Alert Flash Message -->
    @if (session()->has('message'))
        <div class="flex items-center gap-3 p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs sm:text-sm font-medium shadow-sm animate-in fade-in slide-in-from-top-4 duration-300 mb-6">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- List Transaksi -->
    <div class="space-y-5">
        @forelse($transaksis as $trx)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-md transition-shadow duration-300">
                
                <!-- Card Header (ID Trx & Tanggal) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider bg-white px-2.5 py-1 rounded-md border border-slate-200 shadow-sm">
                            Order #{{$trx->id }}
                        </span>
                        <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $trx->tanggal_transaksi->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <!-- Indikator Total Pembayaran -->
                    <div class="text-right w-full sm:w-auto mt-2 sm:mt-0">
                        <p class="text-lg font-black text-blue-600 tracking-tight">Rp {{ number_format($trx->barang->harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Card Body (Info Barang, Pembeli & Status) -->
                <div class="p-5 flex flex-col md:flex-row gap-6">
                    
                    <!-- Kiri: Info Barang & Pembeli -->
                    <div class="flex flex-1 gap-4">
                        <!-- Thumbnail Barang -->
                        <div class="w-20 h-20 sm:w-24 sm:h-24 bg-slate-50 rounded-xl border border-slate-100 overflow-hidden flex-shrink-0">
                            @if($trx->barang->foto)
                                <img src="{{ asset('storage/'.$trx->barang->foto) }}" alt="{{ $trx->barang->nama_barang }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col justify-center">
                            <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">{{ $trx->barang->nama_barang }}</h3>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2">
                                <p class="text-xs font-medium text-slate-500 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Pembeli: <span class="font-bold text-slate-700">{{ $trx->pembeli->name ?? 'User' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Kanan: Status -->
                    <div class="md:w-1/3 flex flex-col justify-center gap-3 md:border-l md:border-slate-100 md:pl-6">
                        
                        <!-- Status Pembayaran -->
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pembayaran</span>
                            @if($trx->metode_pembayaran === 'COD')
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-md uppercase tracking-wider">COD</span>
                            @elseif($trx->status_transaksi === 'Menunggu Pembayaran')
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold rounded-md uppercase tracking-wider">Belum Dibayar</span>
                            @else
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold rounded-md uppercase tracking-wider">Terverifikasi</span>
                            @endif
                        </div>

                        <!-- Status Penyerahan -->
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Penyerahan</span>
                            @if($trx->status_transaksi === 'Selesai')
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-md uppercase tracking-wider">Sudah Diterima</span>
                            @elseif($trx->status_transaksi === 'Diproses')
                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-bold rounded-md uppercase tracking-wider flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                    Sedang Diproses
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-slate-50 text-slate-600 border border-slate-200 text-[10px] font-bold rounded-md uppercase tracking-wider">Belum Diserahkan</span>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- Card Footer (Aksi) -->
                <div class="px-5 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3">
                    
                    <a href="{{ route('penjual.chat', ['selectedBarangId' => $trx->id_barang, 'receiverId' => $trx->id_pembeli]) }}" 
                       class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-50 hover:text-blue-600 hover:border-blue-300 transition-all shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Hubungi Pembeli
                    </a>

                    @if(($trx->status_transaksi === 'Diverifikasi' || ($trx->metode_pembayaran === 'COD' && $trx->status_transaksi === 'Menunggu Pembayaran')) && $trx->status_transaksi !== 'Diproses')
                        <button wire:click="konfirmasiPenyerahan({{ $trx->id }})" wire:confirm="Pastikan Anda telah menyerahkan barang kepada pembeli. Lanjutkan konfirmasi?" 
                           class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Konfirmasi Penyerahan
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <!-- Empty State Premium -->
            <div class="py-16 px-6 text-center bg-white rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight mb-2">Belum Ada Pesanan Masuk</h3>
                <p class="text-slate-500 font-medium text-sm mb-6 max-w-sm mx-auto">Pesanan dari pembeli akan muncul di sini. Pastikan barang dagangan Anda menarik ya!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Custom UI -->
    @if ($transaksis->hasPages())
        <div class="mt-8 pt-6 border-t border-slate-100">
            {{ $transaksis->links() }}
        </div>
    @endif
</div>