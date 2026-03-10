<div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Kelola Transaksi')

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 lg:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 sm:gap-5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Kelola Transaksi</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1 sm:mt-1.5 font-medium">Pantau semua aktivitas transaksi (COD & Transfer) di KostPlace.</p>
        </div>
        
        <!-- Search Input Premium -->
        <div class="relative w-full md:w-72">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" 
                class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all" 
                placeholder="Cari ID / Produk / User...">
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <!-- min-w memaksa tabel tetap lebar di HP biar isinya gak kegencet -->
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[900px]">
                <thead class="bg-slate-50/80 border-b border-slate-200">
                    <tr class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="px-4 sm:px-6 py-3 sm:py-4 w-24">ID TRX</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Produk</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Pihak Terlibat</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Metode & Harga</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Status</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-right">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksis as $item)
                        <tr wire:key="trx-admin-{{ $item->id }}" class="hover:bg-slate-50/80 transition-colors group">
                            
                            <!-- Kolom ID -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md border border-slate-200">
                                    #{{ $item->id }}
                                </span>
                            </td>
                            
                            <!-- Kolom Produk -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <span class="text-sm font-semibold text-slate-800">{{ $item->barang->nama_barang ?? 'Barang Dihapus' }}</span>
                            </td>

                            <!-- Kolom Pihak Terlibat (Pembeli -> Penjual) -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="font-medium text-slate-400 w-12">Dari:</span>
                                        <span class="font-bold text-blue-700">{{ $item->pembeli->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs">
                                        <span class="font-medium text-slate-400 w-12">Ke:</span>
                                        <span class="font-bold text-emerald-700">{{ $item->penjual->name ?? 'Unknown' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kolom Metode & Harga -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-sm font-black text-slate-800 tracking-tight">Rp {{ number_format($item->barang->harga ?? 0, 0, ',', '.') }}</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider {{ $item->metode_pembayaran === 'Transfer' ? 'text-indigo-500' : 'text-slate-500' }}">
                                        {{ $item->metode_pembayaran }}
                                    </span>
                                </div>
                            </td>

                            <!-- Kolom Status -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                @php
                                    $statusColors = [
                                        'Menunggu Pembayaran' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'Menunggu Verifikasi' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'Diverifikasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'Diproses' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'Dibatalkan' => 'bg-rose-50 text-rose-700 border-rose-200',
                                    ];
                                    
                                    $badgeClass = $statusColors[$item->status_transaksi] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                    
                                    // Sederhanakan teks untuk tampilan tabel
                                    $displayStatus = $item->status_transaksi;
                                    if(in_array($item->status_transaksi, ['Menunggu Pembayaran', 'Menunggu Verifikasi'])) $displayStatus = 'Menunggu';
                                    if($item->status_transaksi === 'Diverifikasi') $displayStatus = 'Diproses';
                                @endphp
                                
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] sm:text-[11px] font-bold uppercase tracking-wider border shadow-sm {{ $badgeClass }}">
                                    {{ $displayStatus }}
                                </span>
                            </td>

                            <!-- Kolom Tanggal -->
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-right">
                                <span class="text-[11px] sm:text-xs text-slate-500 font-medium">
                                    {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}
                                </span>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 sm:px-6 py-12 sm:py-16 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-1 sm:mb-2">
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-800 tracking-tight">
                                        {{ $search ? 'Transaksi tidak ditemukan' : 'Belum Ada Transaksi' }}
                                    </h3>
                                    <p class="text-slate-500 font-medium text-xs sm:text-sm">
                                        {{ $search ? 'Coba gunakan kata kunci pencarian yang lain.' : 'Sistem belum mencatat adanya transaksi.' }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($transaksis->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>
</div>