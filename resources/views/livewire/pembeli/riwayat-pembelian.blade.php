@section('page_title', 'Riwayat Pembelian')
<div class="space-y-6 flex-1 p-6">
    <!-- Header Section -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-black tracking-tighter text-slate-800 uppercase italic">Riwayat Pembelian</h2>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Daftar transaksi yang sudah selesai</p>
        </div>
        <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200 shadow-sm">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($riwayats as $trx)
            <!-- Card Riwayat Sesuai Gambar 3.23 -->
            <div class="bg-white border-2 border-slate-200 rounded-xl p-5 shadow-sm transition-all hover:border-blue-300">
                
                <!-- Baris 1: Transaksi ID & Harga -->
                <div class="flex justify-between items-start">
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-tighter">Transaksi #{{ $trx->id }}</p>
                    <p class="text-lg font-black text-blue-600 italic">Rp. {{ number_format($trx->barang->harga, 0, ',', '.') }}</p>
                </div>

                <!-- Baris 2: Tanggal (Di bawah harga) -->
                <div class="flex justify-end -mt-1 mb-2">
                    <p class="text-[10px] font-bold text-slate-400">{{ $trx->tanggal_transaksi->format('Y-m-d') }}</p>
                </div>

                <!-- Baris 3: Nama Barang & Status -->
                <div class="flex justify-between items-center mb-1">
                    <h3 class="text-xl font-black text-slate-800">{{ $trx->barang->nama_barang }}</h3>
                    <span class="font-black text-xs uppercase tracking-widest {{ $trx->status_transaksi === 'Selesai' ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $trx->status_transaksi === 'Selesai' ? 'Selesai' : 'Dibatalkan' }}
                    </span>
                </div>

                <!-- Baris 4: Penjual -->
                <p class="text-sm font-bold text-slate-500 mb-4">
                    Penjual : <span class="text-slate-700 uppercase italic">{{ $trx->penjual->name }}</span>
                </p>

                <!-- Baris 5 & 6: Metode Pembayaran -->
                <div class="pt-3 border-t border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Metode Pembayaran</p>
                    <p class="text-sm font-black text-slate-700 uppercase tracking-tight">{{ $trx->metode_pembayaran }}</p>
                </div>

            </div>
        @empty
            <div class="py-20 text-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                <p class="text-slate-400 font-bold uppercase tracking-widest text-sm">Belum ada riwayat transaksi nih!</p>
                <a href="{{ route('pembeli.katalog') }}" class="mt-4 inline-block text-blue-600 font-black underline uppercase text-xs">Cari Barang</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($riwayats->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $riwayats->links() }}
        </div>
    @endif
</div>