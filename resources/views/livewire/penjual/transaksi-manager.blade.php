<div class="space-y-6 flex-1 p-6">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase italic tracking-tighter">Pesanan Masuk</h2>
            <p class="text-slate-500 text-sm mt-1">Pantau dan konfirmasi penyerahan barang ke pembeli secara sat-set.</p>
        </div>
    </div>

    <!-- Alert Flash Message -->
    @if (session()->has('message'))
        <div class="p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm animate-pulse">
            {{ session('message') }}
        </div>
    @endif

    <!-- List Transaksi -->
    <div class="grid grid-cols-1 gap-6">
        @forelse($transaksis as $trx)
            <div class="bg-white border-2 border-slate-200 rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
                
                <!-- 🔝 Baris Atas: Order ID & Harga/Tanggal -->
                <div class="flex justify-between items-start mb-2">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-tight italic">Order #{{ $trx->id }}</p>
                    <div class="text-right">
                        <p class="text-2xl font-black text-blue-600">Rp. {{ number_format($trx->barang->harga, 0, ',', '.') }}</p>
                        <p class="text-xs font-bold text-slate-400">{{ $trx->tanggal_transaksi->format('Y-m-d') }}</p>
                    </div>
                </div>

                <!-- 🏷️ Tengah: Nama Barang & Pembeli -->
                <div class="mb-8">
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight leading-tight uppercase">{{ $trx->barang->nama_barang }}</h3>
                    <p class="text-sm font-bold text-slate-500">Pembeli : <span class="text-slate-800 italic uppercase">{{ $trx->pembeli->name ?? 'User' }}</span></p>
                </div>

                <!-- 📊 Status Section (2 Kolom Sejajar) -->
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <!-- Kolom Kiri: Status Pembayaran -->
                    <div class="space-y-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Pembayaran</p>
                        @if($trx->metode_pembayaran === 'COD')
                            <span class="inline-flex px-4 py-2 bg-emerald-500 text-white text-xs font-black rounded-lg border border-emerald-600 shadow-sm uppercase italic">COD</span>
                        @elseif($trx->status_transaksi === 'Menunggu Pembayaran')
                            <span class="inline-flex px-4 py-2 bg-slate-100 text-slate-500 text-xs font-black rounded-lg border border-slate-300 uppercase italic">Belum dibayar</span>
                        @else
                            <span class="inline-flex px-4 py-2 bg-emerald-500 text-white text-xs font-black rounded-lg border border-emerald-600 shadow-sm uppercase italic">Terverifikasi</span>
                        @endif
                    </div>

                    <!-- Kolom Kanan: Status Penyerahan -->
                    <div class="space-y-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Penyerahan</p>
                        @if($trx->status_transaksi === 'Selesai')
                            <span class="inline-flex px-4 py-2 bg-emerald-500 text-white text-xs font-black rounded-lg border border-emerald-600 shadow-sm uppercase italic">Sudah diserahkan</span>
                        @elseif($trx->status_transaksi === 'Diproses')
                            <span class="inline-flex px-4 py-2 bg-blue-500 text-white text-xs font-black rounded-lg border border-blue-600 shadow-sm uppercase italic animate-pulse">Sedang Diserahkan</span>
                        @else
                            <span class="inline-flex px-4 py-2 bg-slate-100 text-slate-500 text-xs font-black rounded-lg border border-slate-300 uppercase italic">Belum diserahkan</span>
                        @endif
                    </div>
                </div>

                <!-- ⚡ Action Buttons -->
                <div class="space-y-3">
                    @if(($trx->status_transaksi === 'Diverifikasi' || ($trx->metode_pembayaran === 'COD' && $trx->status_transaksi === 'Menunggu Pembayaran')) && $trx->status_transaksi !== 'Diproses')
                        <button wire:click="konfirmasiPenyerahan({{ $trx->id }})" wire:confirm="Yakin sudah serahin barangnya ke pembeli?" 
                            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-100 flex items-center justify-center gap-3 transition-all uppercase tracking-widest text-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Konfirmasi Penyerahan
                        </button>
                    @endif

                    <a href="{{ route('penjual.chat', ['selectedBarangId' => $trx->id_barang, 'receiverId' => $trx->id_pembeli]) }}" 
                       class="w-full py-4 border-2 border-slate-800 text-slate-800 rounded-xl font-black text-xs uppercase text-center transition-all hover:bg-slate-800 hover:text-white flex items-center justify-center gap-2 tracking-widest">
                        Hubungi Pembeli
                    </a>
                </div>

            </div>
        @empty
            <div class="py-24 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm italic">Belum ada orderan masuk nih. Sabar ya!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($transaksis->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $transaksis->links() }}
        </div>
    @endif
</div>