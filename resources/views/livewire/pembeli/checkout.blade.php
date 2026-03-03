@section('page_title', 'Checkout')
<div class=" flex-1 max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center gap-4">
            <a href="{{ route('pembeli.katalog') }}" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg></a>
            <h2 class="text-xl font-black text-slate-800 uppercase">Checkout</h2>
        </div>

        <div class="p-6 space-y-6">
            <!-- Ringkasan Barang -->
            <div class="flex gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                <div class="w-20 h-20 bg-white rounded-lg border border-slate-200 overflow-hidden">
                    <img src="{{ asset('storage/'.$barang->foto) }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="text-xs font-bold text-blue-500 uppercase">{{ $barang->kategori->nama_kategori }}</p>
                    <h3 class="font-bold text-slate-800">{{ $barang->nama_barang }}</h3>
                    <p class="text-sm font-medium text-slate-500">Penjual: {{ $barang->user->name }}</p>
                    <p class="text-blue-600 font-bold mt-1">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Pilih Metode -->
            <div class="space-y-3">
                <p class="text-sm font-bold text-slate-700">Pilih Metode Pembayaran:</p>
                <div wire:click="$set('metode_pembayaran', 'COD')" class="p-4 border-2 rounded-xl cursor-pointer transition-all {{ $metode_pembayaran === 'COD' ? 'border-blue-500 bg-blue-50' : 'border-slate-200' }}">
                    <p class="font-bold {{ $metode_pembayaran === 'COD' ? 'text-blue-700' : 'text-slate-600' }}">COD (Cash On Delivery)</p>
                    <p class="text-xs text-slate-500">Bayar langsung saat ketemuan.</p>
                </div>
                <div wire:click="$set('metode_pembayaran', 'Transfer')" class="p-4 border-2 rounded-xl cursor-pointer transition-all {{ $metode_pembayaran === 'Transfer' ? 'border-blue-500 bg-blue-50' : 'border-slate-200' }}">
                    <p class="font-bold {{ $metode_pembayaran === 'Transfer' ? 'text-blue-700' : 'text-slate-600' }}">Transfer Rekening Admin (Rekber)</p>
                    <p class="text-xs text-slate-500">Uang aman ditahan Admin sampai barang diterima.</p>
                </div>
            </div>

            <button wire:click="buatPesanan" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-200 transition-all uppercase tracking-widest">
                Buat Pesanan
            </button>
        </div>
    </div>
</div>