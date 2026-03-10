<div class="space-y-6 max-w-8xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Status Transaksi')
    
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight">Status Transaksi</h2>
        <p class="text-sm font-medium text-slate-500 mt-1">Status Transaksi Pembayaran.</p>
    </div>
    
    <div class="space-y-5">
        @forelse($transaksis as $trx)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden group hover:shadow-md transition-shadow duration-300">
                
                <!-- Card Header (ID Trx, Tanggal, & Status) -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider bg-white px-2.5 py-1 rounded-md border border-slate-200 shadow-sm">
                            Transaksi #{{ $trx->id }}
                        </span>
                        <span class="text-xs font-medium text-slate-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ $trx->tanggal_transaksi->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <!-- Badge Status Dinamis -->
                    @php
                        $statusColors = [
                            'Menunggu Pembayaran' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'Menunggu Verifikasi' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'Diverifikasi' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'Diproses' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                        ];
                        $badgeClass = $statusColors[$trx->status_transaksi] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                    @endphp
                    <span class="px-3 py-1 text-[11px] font-bold rounded-full border shadow-sm tracking-wide {{ $badgeClass }}">
                        <span class="mr-1.5 inline-block w-1.5 h-1.5 rounded-full {{ str_replace(['bg-', '100', 'text-', '700', 'border-', '200'], ['bg-', '500', '', '', '', ''], $badgeClass) }}"></span>
                        {{ $trx->status_transaksi }}
                    </span>
                </div>

                <!-- Card Body (Info Barang & Harga) -->
                <div class="p-5 flex flex-col sm:flex-row gap-5">
                    
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

                    <!-- Detail Text -->
                    <div class="flex-1 flex flex-col justify-center">
                        <h3 class="text-lg font-bold text-slate-800 leading-tight mb-1">{{ $trx->barang->nama_barang }}</h3>
                        
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2">
                            <p class="text-xs font-medium text-slate-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Penjual: <span class="font-bold text-slate-700">{{ $trx->penjual->name ?? 'Unknown' }}</span>
                            </p>
                            <span class="hidden sm:block text-slate-300">•</span>
                            <p class="text-xs font-medium text-slate-500 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Metode: <span class="font-bold text-blue-600 uppercase">{{ $trx->metode_pembayaran }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Harga -->
                    <div class="sm:text-right flex flex-col justify-center mt-3 sm:mt-0 sm:border-l sm:border-slate-100 sm:pl-5">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Total Harga</p>
                        <p class="text-xl font-black text-blue-600 tracking-tight">Rp {{ number_format($trx->barang->harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Card Footer (Aksi) -->
                <div class="px-5 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3">
                    
                    <!-- Tombol Chat (Selalu Muncul) -->
                    <a href="{{ route('pembeli.chat', ['selectedBarangId' => $trx->id_barang, 'receiverId' => $trx->id_penjual]) }}" 
                       class="w-full sm:w-auto px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-50 hover:text-blue-600 hover:border-blue-300 transition-all shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        Chat Penjual
                    </a>
                    
                    <!-- Tombol Lanjut Bayar (Jika Status Nunggu Bayar) -->
                    @if($trx->status_transaksi === 'Menunggu Pembayaran')
                        <a href="{{ route('pembeli.pembayaran', $trx->id) }}" 
                           class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            {{ $trx->metode_pembayaran === 'COD' ? 'Lihat Instruksi COD' : 'Lanjut Pembayaran' }}
                        </a>
                    @endif

                    <!-- Tombol Terima Barang (Jika Sedang Diproses / COD) -->
                    @if($trx->status_transaksi === 'Diproses' || ($trx->status_transaksi !== 'Menunggu Pembayaran' && $trx->metode_pembayaran === 'COD'))
                        <button wire:click="konfirmasiTerima({{ $trx->id }})" 
                                wire:confirm="Pastikan barang sudah Anda terima dan sesuai dengan deskripsi pesanan. Lanjutkan?" 
                                class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-sm shadow-sm hover:shadow-md hover:shadow-emerald-500/20 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Pesanan Diterima
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <!-- Empty State Premium -->
            <div class="py-16 px-6 text-center bg-white rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight mb-2">Belum Ada Transaksi Aktif</h3>
                <p class="text-slate-500 font-medium text-sm mb-6 max-w-sm mx-auto">Anda belum memiliki pesanan yang sedang berlangsung saat ini. Yuk, mulai cari barang incaran Anda!</p>
                <a href="{{ route('pembeli.katalog') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    Mulai Belanja Dulu
                </a>
            </div>
        @endforelse
    </div>
</div>