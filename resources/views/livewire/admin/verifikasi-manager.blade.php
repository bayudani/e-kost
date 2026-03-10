<div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Verifikasi Pembayaran')

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 lg:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Verifikasi Pembayaran</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1 sm:mt-1.5 font-medium">Cek dan validasi bukti transfer dari pembeli sebelum diteruskan ke penjual.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="flex items-center justify-between p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs sm:text-sm font-medium">{{ session('message') }}</span>
            </div>
            <button wire:click="$set('message', null)" class="text-emerald-500 hover:text-emerald-700 transition-colors p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <!-- 🌟 Card List Section 🌟 -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 sm:gap-6">
        @forelse ($transaksis as $item)
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 flex flex-col relative group overflow-hidden">
                
                <!-- Status Top Bar -->
                <div class="px-5 py-3 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        TRX-#{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                    
                    @if($item->status_transaksi === 'Menunggu Verifikasi')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-bold rounded-md uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Perlu Cek
                        </span>
                    @elseif($item->status_transaksi === 'Diverifikasi')
                        <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-md uppercase tracking-wider">
                            Telah Diverifikasi
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-600 border border-slate-200 text-[10px] font-bold rounded-md uppercase tracking-wider">
                            {{ $item->status_transaksi }}
                        </span>
                    @endif
                </div>

                <div class="p-5 flex flex-1 gap-4">
                    <!-- Info Pembeli & Harga -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">Total Transfer</p>
                            <p class="text-2xl font-black text-blue-600 tracking-tight leading-none mb-3">Rp {{ number_format($item->barang->harga ?? 0, 0, ',', '.') }}</p>
                            
                            <div class="space-y-1.5">
                                <p class="text-xs font-medium text-slate-600 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span class="font-bold text-slate-800">{{ $item->pembeli->name ?? 'User' }}</span>
                                </p>
                                <p class="text-xs font-medium text-slate-600 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Transfer (Thumbnail) -->
                    <div class="w-24 flex flex-col items-end">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Bukti</p>
                        <div wire:click="openVerifikasi({{ $item->id }})" 
                             class="w-full aspect-[3/4] bg-slate-100 rounded-xl border border-slate-200 overflow-hidden cursor-zoom-in relative group/image shadow-sm" title="Klik untuk perbesar bukti transfer">
                            @if($item->bukti_transfer)
                                <img src="{{ asset('storage/' . $item->bukti_transfer) }}" alt="Bukti TF" class="w-full h-full object-cover transition-transform duration-500 group-hover/image:scale-110">
                                <div class="absolute inset-0 bg-blue-900/40 hidden group-hover/image:flex items-center justify-center transition-all backdrop-blur-[1px]">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Tombol Action (Bawah) -->
                <div class="p-3 border-t border-slate-100 bg-slate-50/50 flex gap-2">
                    @if($item->status_transaksi === 'Menunggu Verifikasi' && $item->bukti_transfer)
                        <button wire:click="tolak({{ $item->id }})" wire:confirm="Yakin ingin menolak bukti pembayaran ini? Pembeli akan diminta mengunggah ulang." 
                            class="flex-1 py-2.5 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-xl transition-all text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>
                        <button wire:click="terima({{ $item->id }})" wire:confirm="Yakin validasi bukti ini benar? Status akan berubah menjadi Diverifikasi."
                            class="flex-1 py-2.5 bg-emerald-600 border border-emerald-600 text-white hover:bg-emerald-700 rounded-xl transition-all text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm hover:shadow-emerald-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Terima Valid
                        </button>
                    @elseif($item->status_transaksi === 'Menunggu Pembayaran')
                        <div class="flex-1 py-2.5 text-slate-400 text-xs font-semibold text-center rounded-xl bg-slate-100 border border-slate-200 border-dashed">
                            Belum Upload Bukti
                        </div>
                    @else
                        <div class="flex-1 py-2.5 text-blue-600 text-xs font-semibold text-center rounded-xl bg-blue-50 border border-blue-100">
                            Telah Direspons
                        </div>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 sm:py-24 text-center bg-white rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0zM12 14v.01M12 10v2"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight mb-2">Belum Ada Pembayaran</h3>
                <p class="text-slate-500 font-medium text-sm">Belum ada transaksi via transfer bank yang butuh verifikasi saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($transaksis->hasPages())
        <div class="px-4 sm:px-6 py-4 border-t border-slate-100 mt-6">
            {{ $transaksis->links() }}
        </div>
    @endif

        <!-- Modal Preview Bukti Pembayaran -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 sm:p-6 z-[60]">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg flex flex-col max-h-[95dvh] sm:max-h-[90vh] animate-in fade-in zoom-in-95 duration-200 overflow-hidden">
                
                <!-- Header Modal -->
                <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/80 flex-shrink-0">
                    <div>
                        <h3 class="text-base font-bold text-slate-800">Preview Bukti Pembayaran</h3>
                        <p class="text-[11px] font-medium text-slate-500 mt-0.5">Transaksi #{{ str_pad($selected_id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <button wire:click="closeModal" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Gambar Full -->
                <div class="p-4 sm:p-6 overflow-y-auto bg-slate-100/50 flex-1 flex items-center justify-center">
                    @if($bukti_url)
                        <img src="{{ asset('storage/' . $bukti_url) }}" alt="Bukti Transfer Zoom" class="max-w-full rounded-xl shadow-sm border border-slate-200 object-contain max-h-[60vh]">
                    @else
                        <div class="text-center text-slate-400 py-12">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-sm font-medium">Gambar tidak ditemukan di server.</p>
                        </div>
                    @endif
                </div>

                <!-- Tombol Action di Modal -->
                @php 
                    $cekStatus = App\Models\Transaksi::find($selected_id)->status_transaksi ?? '';
                @endphp
                
                @if($cekStatus === 'Menunggu Verifikasi')
                    <div class="px-5 py-4 border-t border-slate-100 bg-white flex flex-col-reverse sm:flex-row justify-end gap-3 flex-shrink-0">
                        <button wire:click="tolak" wire:confirm="Tolak bukti ini dan minta pembeli upload ulang?" class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-rose-600 bg-white border border-rose-200 rounded-xl hover:bg-rose-50 transition-colors shadow-sm">
                            Tolak Bukti
                        </button>
                        <button wire:click="terima" class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Terima Valid
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

</div>