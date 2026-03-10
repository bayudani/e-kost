<div class="space-y-6 max-w-5xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Checkout')

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header -->
        <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
            <a href="{{ route('pembeli.katalog') }}" class="p-1.5 sm:p-2 -ml-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-lg sm:text-xl font-bold text-slate-800 tracking-tight">Checkout Pesanan</h2>
        </div>

        <div class="p-5 sm:p-8 space-y-8">
            
            <!-- Ringkasan Barang -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Ringkasan Barang
                </h3>
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-5 p-4 sm:p-5 bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 bg-slate-50 rounded-xl border border-slate-100 overflow-hidden flex-shrink-0">
                        @if($barang->foto)
                            <img src="{{ asset('storage/'.$barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <span class="inline-flex w-fit items-center px-2 py-1 rounded-md text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-100 uppercase tracking-wider mb-2">
                            {{ $barang->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                        <h3 class="font-bold text-slate-800 text-base sm:text-lg leading-tight mb-1">{{ $barang->nama_barang }}</h3>
                        <p class="text-[11px] sm:text-xs font-medium text-slate-500 mb-3 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Penjual: {{ $barang->user->name ?? 'Unknown' }}
                        </p>
                        <p class="text-xl sm:text-2xl text-blue-600 font-black tracking-tight mt-auto">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Pilih Metode Pembayaran -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Pilih Metode Pembayaran
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- Opsi COD -->
                    <div wire:click="$set('metode_pembayaran', 'COD')" 
                         class="relative p-4 sm:p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200 group flex flex-col gap-3
                         {{ $metode_pembayaran === 'COD' ? 'border-blue-500 bg-blue-50/50 shadow-sm' : 'border-slate-200 hover:border-blue-200 bg-white hover:bg-slate-50' }}">
                        
                        <!-- Custom Radio Button Indicator -->
                        <div class="absolute top-4 sm:top-5 right-4 sm:right-5 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors
                            {{ $metode_pembayaran === 'COD' ? 'border-blue-600' : 'border-slate-300 group-hover:border-blue-400' }}">
                            @if($metode_pembayaran === 'COD')
                                <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                            @endif
                        </div>

                        <!-- Ikon COD -->
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors
                            {{ $metode_pembayaran === 'COD' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500 group-hover:text-blue-500' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        
                        <div>
                            <p class="font-bold text-sm mb-1 {{ $metode_pembayaran === 'COD' ? 'text-blue-800' : 'text-slate-700' }}">COD (Cash On Delivery)</p>
                            <p class="text-[11px] font-medium leading-relaxed {{ $metode_pembayaran === 'COD' ? 'text-blue-600/80' : 'text-slate-500' }}">Bayar langsung di tempat saat bertemu dengan penjual.</p>
                        </div>
                    </div>

                    <!-- Opsi Transfer / Rekber -->
                    <div wire:click="$set('metode_pembayaran', 'Transfer')" 
                         class="relative p-4 sm:p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200 group flex flex-col gap-3
                         {{ $metode_pembayaran === 'Transfer' ? 'border-blue-500 bg-blue-50/50 shadow-sm' : 'border-slate-200 hover:border-blue-200 bg-white hover:bg-slate-50' }}">
                        
                        <!-- Custom Radio Button Indicator -->
                        <div class="absolute top-4 sm:top-5 right-4 sm:right-5 w-5 h-5 rounded-full border-2 flex items-center justify-center transition-colors
                            {{ $metode_pembayaran === 'Transfer' ? 'border-blue-600' : 'border-slate-300 group-hover:border-blue-400' }}">
                            @if($metode_pembayaran === 'Transfer')
                                <div class="w-2.5 h-2.5 rounded-full bg-blue-600"></div>
                            @endif
                        </div>

                        <!-- Ikon Transfer -->
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-colors
                            {{ $metode_pembayaran === 'Transfer' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500 group-hover:text-blue-500' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                        </div>
                        
                        <div>
                            <p class="font-bold text-sm mb-1 {{ $metode_pembayaran === 'Transfer' ? 'text-blue-800' : 'text-slate-700' }}">Transfer (Rekber Admin)</p>
                            <p class="text-[11px] font-medium leading-relaxed {{ $metode_pembayaran === 'Transfer' ? 'text-blue-600/80' : 'text-slate-500' }}">Uang aman ditahan oleh Admin sampai barang diterima.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-4">
                <button wire:click="buatPesanan" class="w-full py-4 sm:py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all flex items-center justify-center gap-2 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Konfirmasi & Buat Pesanan
                </button>
                <p class="text-center text-[10px] sm:text-[11px] text-slate-400 mt-4 font-medium flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7z"></path></svg>
                    Transaksi aman terlindungi oleh sistem KostPlace
                </p>
            </div>

        </div>
    </div>
</div>