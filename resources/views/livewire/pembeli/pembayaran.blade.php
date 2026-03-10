<div class="space-y-6 max-w-5xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Pembayaran')

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header -->
        <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
            <a href="{{ route('pembeli.status') }}" class="p-1.5 sm:p-2 -ml-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-lg sm:text-xl font-bold text-slate-800 tracking-tight">Detail Pembayaran</h2>
        </div>

        <div class="p-5 sm:p-8">
            
            <!-- ❌ Tampilan: Status Dibatalkan (Expired) -->
            @if($transaksi->status_transaksi === 'Dibatalkan')
                <div class="text-center p-8 sm:p-12 bg-rose-50 rounded-2xl border border-rose-200 shadow-sm animate-in zoom-in-95 duration-300">
                    <div class="w-20 h-20 bg-rose-100 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-rose-700 tracking-tight mb-2">Dibatalkan / Waktu Habis!</h2>
                    <p class="text-sm font-medium text-rose-600/80">Pesanan ini telah dibatalkan. Kemungkinan karena Anda membatalkan pesanan atau melewati batas waktu pembayaran 24 jam.</p>
                </div>

            <!-- ⏳ Tampilan: Status Menunggu Verifikasi -->
            @elseif($transaksi->status_transaksi === 'Menunggu Verifikasi')
                <div class="text-center p-8 sm:p-12 bg-blue-50 rounded-2xl border border-blue-200 shadow-sm animate-in zoom-in-95 duration-300">
                    <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner">
                        <svg class="w-10 h-10 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-blue-800 tracking-tight mb-3">Menunggu Verifikasi Admin</h2>
                    <p class="text-sm font-medium text-blue-600/80 max-w-md mx-auto mb-8">
                        Terima kasih! Bukti transfer Anda sudah kami terima dan sedang masuk antrean pengecekan oleh tim Admin KostPlace.
                    </p>
                    <a href="{{ route('pembeli.status') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-xl font-semibold shadow-sm transition-all text-sm">
                        Kembali ke Status Pesanan
                    </a>
                </div>

            <!-- ✅ Tampilan: Status Diverifikasi / Diproses / Selesai -->
            @elseif(in_array($transaksi->status_transaksi, ['Diverifikasi', 'Diproses', 'Selesai']))
                <div class="text-center p-8 sm:p-12 bg-emerald-50 rounded-2xl border border-emerald-200 shadow-sm animate-in zoom-in-95 duration-300">
                    <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-5 shadow-inner">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-emerald-800 tracking-tight mb-3">Pembayaran Berhasil!</h2>
                    <p class="text-sm font-medium text-emerald-700/80 max-w-md mx-auto mb-8">
                        Pembayaran Anda telah terverifikasi. Saat ini pesanan Anda berada pada status: <span class="font-bold uppercase text-emerald-800">[{{ $transaksi->status_transaksi }}]</span>.
                    </p>
                    <a href="{{ route('pembeli.status') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3.5 rounded-xl font-semibold shadow-sm transition-all text-sm">
                        Lihat Status Pengiriman
                    </a>
                </div>

            <!-- 🟡 Tampilan: Status Menunggu Pembayaran -->
            @elseif($transaksi->status_transaksi === 'Menunggu Pembayaran')
                
                <!-- Jika Metode COD -->
                @if($transaksi->metode_pembayaran === 'COD')
                    <div class="p-8 sm:p-10 bg-emerald-50 rounded-2xl border border-emerald-200 text-center shadow-sm">
                        <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-5">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h2 class="text-2xl font-black text-emerald-800 tracking-tight mb-3">Instruksi Pembayaran COD</h2>
                        <p class="text-emerald-700 font-medium text-sm leading-relaxed mb-8 max-w-md mx-auto">
                            Anda memilih metode Cash On Delivery. Silakan hubungi penjual melalui chat untuk menentukan kesepakatan lokasi dan waktu pertemuan.
                        </p>
                        <a href="{{ route('pembeli.chat') }}" class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3.5 rounded-xl font-semibold shadow-sm hover:shadow-md hover:shadow-emerald-500/20 transition-all text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Hubungi Penjual Sekarang
                        </a>
                    </div>

                <!-- Jika Metode TRANSFER -->
                @else
                    <div class="space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-300">
                        
                        <!-- Total Pembayaran -->
                        <div class="text-center space-y-2">
                            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Total Pembayaran</p>
                            <p class="text-4xl sm:text-5xl font-black text-blue-600 tracking-tight">
                                <span class="text-2xl sm:text-3xl font-semibold text-slate-400">Rp</span> {{ number_format($transaksi->barang->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Countdown Banner (Pake pure Alpine JS inline) -->
                        <div x-data="{
                                expiry: new Date('{{ $transaksi->created_at->addHours(24)->toIso8601String() }}').getTime(),
                                remaining: '',
                                init() {
                                    this.update();
                                    setInterval(() => this.update(), 1000);
                                },
                                update() {
                                    let diff = this.expiry - new Date().getTime();
                                    if (diff < 0) {
                                        this.remaining = 'WAKTU HABIS';
                                        window.location.reload();
                                        return;
                                    }
                                    let h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                    let s = Math.floor((diff % (1000 * 60)) / 1000);
                                    this.remaining = `${h}j ${m}m ${s}d`;
                                }
                            }" 
                            class="bg-amber-50 px-5 py-4 rounded-xl flex items-center justify-between border border-amber-200 shadow-sm relative overflow-hidden">
                            <!-- Aksen Warna Garis -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-amber-400"></div>
                            
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-bold text-amber-800 text-sm">Batas Waktu Pembayaran:</span>
                            </div>
                            <span class="text-lg font-black text-amber-600 tracking-wider font-mono bg-white px-3 py-1 rounded-lg border border-amber-100 shadow-sm" x-text="remaining"></span>
                        </div>

                        <!-- Instruksi Transfer (Card Bank) -->
                        <div class="bg-blue-50/50 p-6 sm:p-8 rounded-2xl border border-blue-100 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm">
                            <div class="text-center sm:text-left">
                                <p class="text-[11px] font-bold text-blue-500 uppercase tracking-widest mb-1.5">Transfer Bank Rekber</p>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight mb-1">BCA - 1234567890</h3>
                                <p class="font-semibold text-slate-500 text-sm uppercase">a.n Admin KostPlace (Jeny Anjely)</p>
                            </div>
                            <div class="w-16 h-16 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center justify-center text-blue-600 font-black italic text-xl">
                                BCA
                            </div>
                        </div>

                        <hr class="border-slate-100">
                        
                        <!-- Form Upload Bukti -->
                        <form wire:submit.prevent="uploadBukti" class="space-y-6">
                            <div class="space-y-3">
                                <label class="block text-sm font-bold text-slate-700">Upload Bukti Transfer</label>
                                
                                <!-- Custom File Upload UI -->
                                <div class="flex flex-col sm:flex-row items-center gap-4">
                                    <label class="flex-shrink-0 cursor-pointer px-5 py-3 bg-white border border-slate-200 hover:bg-slate-50 hover:border-blue-300 rounded-xl text-sm font-semibold text-blue-600 transition-all shadow-sm w-full sm:w-auto text-center">
                                        <span class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            Pilih Gambar Bukti
                                        </span>
                                        <input type="file" wire:model="bukti_transfer" class="hidden" accept="image/*">
                                    </label>
                                    
                                    <span class="text-xs font-medium text-slate-400 truncate" wire:loading.remove wire:target="bukti_transfer">
                                        @if($bukti_transfer)
                                            {{ $bukti_transfer->getClientOriginalName() }}
                                        @else
                                            Maksimal ukuran file 2MB (JPG/PNG)
                                        @endif
                                    </span>
                                    <span class="text-xs text-blue-500 font-bold animate-pulse" wire:loading wire:target="bukti_transfer">Memproses file...</span>
                                </div>
                                @error('bukti_transfer') <span class="text-rose-500 text-xs font-bold block">{{ $message }}</span> @enderror
                                
                                <!-- Image Preview -->
                                @if ($bukti_transfer)
                                    <div class="mt-4 p-2 bg-slate-50 rounded-xl border border-slate-100 inline-block">
                                        <img src="{{ $bukti_transfer->temporaryUrl() }}" class="h-32 object-cover rounded-lg shadow-sm border border-slate-200">
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold transition-all flex items-center justify-center gap-2 text-sm shadow-sm hover:shadow-md hover:shadow-blue-500/20 disabled:opacity-50" wire:loading.attr="disabled" wire:target="uploadBukti">
                                <span wire:loading.remove wire:target="uploadBukti">Konfirmasi Pembayaran</span>
                                <span wire:loading wire:target="uploadBukti" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Sedang Mengupload...
                                </span>
                            </button>
                        </form>
                    </div>
                @endif
            @endif
            
        </div>
    </div>
</div>