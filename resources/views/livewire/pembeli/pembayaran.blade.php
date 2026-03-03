@section('page_title', 'Pembayaran')

<div class="p-6">
    <!-- Path: Status Dibatalkan -->
    @if($transaksi->status_transaksi === 'Dibatalkan')
        <div class="text-center p-10 bg-red-50 text-red-600 rounded-2xl border-2 border-red-200">
            <h2 class="text-2xl font-black">PESANAN EXPIRED!</h2>
            <p>Waktu bayar lu udah abis bro (lewat 24 jam).</p>
        </div>

    <!-- Path: Metode COD -->
    @elseif($transaksi->metode_pembayaran === 'COD')
        <div class="bg-emerald-50 p-8 rounded-2xl border-2 border-emerald-200">
            <h2 class="text-2xl font-black text-emerald-800 uppercase italic">Instruksi COD</h2>
            <p class="mt-2 text-emerald-700">Silakan hubungi penjual via chat untuk menentukan lokasi dan waktu ketemuan.</p>
            <a href="{{ route('pembeli.chat') }}" class="mt-4 inline-block bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold">Chat Penjual</a>
        </div>

    <!-- Path: Metode TRANSFER (Pake Countdown) -->
    @else
        <div class="space-y-6">
            <!-- Countdown Banner -->
            <div x-data="countdown('{{ $transaksi->created_at->addHours(24)->toIso8601String() }}')" 
                 class="bg-amber-100 p-4 rounded-xl flex items-center justify-between border border-amber-200">
                <span class="font-bold text-amber-800 uppercase text-sm">Batas Waktu Bayar:</span>
                <span class="text-xl font-black text-amber-900 font-mono" x-text="remaining"></span>
            </div>

            <!-- Instruksi Transfer -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                <p class="text-sm font-bold text-slate-400">TRANSFER KE:</p>
                <h3 class="text-2xl font-black text-blue-600">BCA - 1234567890</h3>
                <p class="font-bold uppercase">A.N Jeny Anjely</p>
                
                <form wire:submit.prevent="uploadBukti" class="mt-6 pt-6 border-t border-dashed">
                    <label class="block font-bold mb-2">Upload Bukti Transfer:</label>
                    <input type="file" wire:model="bukti_transfer" class="block w-full text-sm text-slate-500">
                    <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-4 rounded-xl font-black uppercase tracking-widest">Konfirmasi</button>
                </form>
            </div>
        </div>

        <script>
            function countdown(expiryDate) {
                return {
                    expiry: new Date(expiryDate).getTime(),
                    remaining: '',
                    init() {
                        this.update();
                        setInterval(() => this.update(), 1000);
                    },
                    update() {
                        let now = new Date().getTime();
                        let diff = this.expiry - now;
                        if (diff < 0) {
                            this.remaining = "WAKTU HABIS";
                            window.location.reload(); // Reload buat update status ke DB
                            return;
                        }
                        let h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        let s = Math.floor((diff % (1000 * 60)) / 1000);
                        this.remaining = `${h}j ${m}m ${s}d`;
                    }
                }
            }
        </script>
    @endif
</div>