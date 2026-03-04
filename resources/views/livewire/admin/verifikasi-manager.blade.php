@section('page_title', 'Verifikasi Pembayaran')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative flex-1 p-6">
    
    <!-- Header Card -->
    <div class="px-8 py-6 border-b border-slate-100 bg-white flex justify-between items-center">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Verifikasi Pembayaran</h2>
            <p class="text-slate-500 text-sm mt-1">Cek dan validasi bukti transfer dari pembeli.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="mx-8 mt-6 p-4 bg-indigo-50 border border-indigo-200 text-indigo-700 rounded-xl flex justify-between items-center transition-all">
            <span class="font-medium text-sm">{{ session('message') }}</span>
            <button wire:click="$set('message', null)" class="text-indigo-700 hover:text-indigo-900 font-bold">&times;</button>
        </div>
    @endif

    <!-- 🌟 Card List Section (Gantiin Table) 🌟 -->
    <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 bg-slate-50/50">
        @forelse ($transaksis as $item)
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                
                <div class="flex justify-between items-start mb-4">
                    <!-- Data Teks (Kiri) -->
                    <div class="space-y-4 flex-1">
                        <div>
                            <p class="text-xs text-slate-500 font-medium">ID transaksi</p>
                            <p class="text-sm font-bold text-slate-800">{{ $item->id }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Pembeli</p>
                            <p class="text-sm font-bold text-slate-800">{{ $item->pembeli->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Jumlah</p>
                            <p class="text-sm font-bold text-blue-600">Rp {{ number_format($item->barang->harga ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex gap-6">
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Tanggal</p>
                                <p class="text-sm font-medium text-slate-800">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('Y-m-d') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 font-medium">Status</p>
                                <p class="text-sm font-bold {{ $item->status_transaksi === 'Menunggu Pembayaran' ? 'text-amber-500' : 'text-emerald-500' }}">
                                    {{ $item->status_transaksi === 'Menunggu Pembayaran' ? 'Menunggu' : $item->status_transaksi }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bukti TF (Kanan) -->
                    <div class="w-28 ml-4 flex flex-col items-end">
                        <p class="text-xs text-slate-500 font-medium mb-1">Bukti Transfer</p>
                        <!-- Klik gambar buat buka modal zoom -->
                        <div class="w-24 h-24 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden cursor-pointer relative group" wire:click="openVerifikasi({{ $item->id }})" title="Klik untuk perbesar">
                            @if($item->bukti_transfer)
                                <img src="{{ asset('storage/' . $item->bukti_transfer) }}" alt="Bukti" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/30 hidden group-hover:flex items-center justify-center transition-all">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tombol Action (Langsung di Card) -->
                <div class="mt-2 pt-4 border-t border-slate-100 flex gap-3">
                    @if($item->status_transaksi === 'Menunggu Pembayaran' && $item->bukti_transfer)
                        <button wire:click="terima({{ $item->id }})" class="flex-1 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Terima
                        </button>
                        <button wire:click="tolak({{ $item->id }})" wire:confirm="Yakin mau tolak bukti pembayaran ini?" class="flex-1 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg transition-colors flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>
                    @elseif($item->status_transaksi !== 'Menunggu Pembayaran')
                        <span class="flex-1 py-2 bg-slate-100 text-slate-400 text-sm font-semibold rounded-lg text-center border border-slate-200">Selesai Diproses</span>
                    @else
                        <span class="flex-1 py-2 bg-slate-100 text-slate-400 text-sm font-semibold rounded-lg text-center border border-slate-200">Belum ada bukti</span>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center">
                <p class="text-slate-500 text-sm">Belum ada transaksi via transfer nih.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($transaksis->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $transaksis->links() }}
        </div>
    @endif

    <!-- ========================================== -->
    <!-- 🔥 MODAL ZOOM BUKTI TRANSFER 🔥 -->
    <!-- ========================================== -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden transform transition-all">
            
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800">Preview Bukti Pembayaran</h3>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6">
                <div class="w-full h-80 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden flex items-center justify-center">
                    @if($bukti_url)
                        <img src="{{ asset('storage/' . $bukti_url) }}" alt="Bukti Transfer" class="w-full h-full object-contain">
                    @else
                        <span class="text-slate-400 text-sm">Gambar tidak ditemukan</span>
                    @endif
                </div>
            </div>

            <!-- Tombol Action di Modal -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button wire:click="tolak" wire:confirm="Yakin mau ditolak?" class="px-6 py-2.5 text-sm font-bold text-white bg-red-500 rounded-xl hover:bg-red-600 transition">
                    Tolak
                </button>
                <button wire:click="terima" class="px-6 py-2.5 text-sm font-bold text-white bg-emerald-500 rounded-xl hover:bg-emerald-600 transition">
                    Terima Transaksi
                </button>
            </div>

        </div>
    </div>
    @endif

</div>