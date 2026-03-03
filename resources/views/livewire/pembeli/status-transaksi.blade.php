@section('page_title', 'Status Transaksi')
<div class="space-y-6 flex-1  p-6">
    <h2 class="text-2xl font-black text-slate-800 uppercase">Status Transaksi</h2>
    
    @forelse($transaksis as $trx)
        <div class="bg-white border-2 border-slate-200 rounded-2xl p-6 shadow-sm overflow-hidden relative group">
            <!-- Header Card (Trx ID & Total) -->
            <div class="flex justify-between items-start mb-4 border-b border-slate-100 pb-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Transaksi #{{ $trx->id }}</p>
                    <h3 class="text-xl font-black text-slate-800">{{ $trx->barang->nama_barang }}</h3>
                </div>
                <div class="text-right">
                    <p class="text-lg font-black text-blue-600">Rp {{ number_format($trx->barang->harga, 0, ',', '.') }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $trx->tanggal_transaksi->format('Y-m-d') }}</p>
                </div>
            </div>

            <!-- Detail Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="space-y-1">
                    <p class="text-xs font-bold text-slate-500 uppercase">Penjual: <span class="text-slate-800">{{ $trx->penjual->name }}</span></p>
                    <p class="text-xs font-bold text-slate-500 uppercase">Metode: <span class="text-indigo-600 italic font-black uppercase">{{ $trx->metode_pembayaran }}</span></p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-slate-400 uppercase mb-1">Status Saat Ini:</p>
                    <span class="px-3 py-1.5 text-xs font-black rounded-lg uppercase tracking-tighter
                        {{ $trx->status_transaksi === 'Diverifikasi' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $trx->status_transaksi === 'Diverifikasi' ? 'Telah Diverifikasi' : $trx->status_transaksi }}
                    </span>
                </div>
            </div>

            <!-- Aksi -->
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('pembeli.chat') }}" class="flex-1 py-3 bg-blue-600 text-white rounded-xl font-black text-xs uppercase text-center flex items-center justify-center gap-2">
                    <span>Chat Penjual</span>
                </a>
                
                @if($trx->status_transaksi === 'Diproses' || $trx->metode_pembayaran === 'COD')
                    <button wire:click="konfirmasiTerima({{ $trx->id }})" wire:confirm="Yakin barang sudah di tangan dan sesuai deskripsi?" 
                        class="flex-1 py-3 bg-white border-2 border-emerald-500 text-emerald-600 rounded-xl font-black text-xs uppercase hover:bg-emerald-50 transition-all">
                        Barang Sudah Diterima
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="py-20 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
            <p class="text-slate-400 font-bold uppercase tracking-widest">Belum ada transaksi aktif bro!</p>
            <a href="{{ route('pembeli.katalog') }}" class="mt-4 inline-block text-blue-600 font-black underline uppercase text-sm">Gas Belanja Dulu</a>
        </div>
    @endforelse
</div>
