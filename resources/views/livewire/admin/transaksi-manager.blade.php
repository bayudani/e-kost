@section('page_title', 'Kelola Transaksi')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative flex-1 p-6">
    
    <!-- Header Card & Search Bar -->
    <div class="px-8 py-6 border-b border-slate-100 bg-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Kelola Transaksi</h2>
            <p class="text-slate-500 text-sm mt-1">Pantau semua aktivitas transaksi (COD & Transfer) di KostPlace.</p>
        </div>
        
        <!-- Search Input Kekinian -->
        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl leading-5 bg-slate-50 hover:bg-white focus:bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 sm:text-sm transition duration-200" placeholder="Cari No TRX / Produk...">
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 rounded-xl">
                <tr>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider rounded-l-xl">ID</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Produk</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Pembeli</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Penjual</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Harga</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Metode</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider rounded-r-xl">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($transaksis as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                        
                        <!-- Kolom ID -->
                        <td class="py-4 px-6 text-sm font-bold text-blue-600">
                            {{ $item->id }}
                        </td>
                        
                        <!-- Kolom Produk -->
                        <td class="py-4 px-6">
                            <span class="text-sm font-bold text-slate-800">{{ $item->barang->nama_barang ?? 'Barang Dihapus' }}</span>
                        </td>

                        <!-- Kolom Pembeli -->
                        <td class="py-4 px-6">
                            <span class="text-sm font-medium text-slate-700">{{ $item->pembeli->name ?? '-' }}</span>
                        </td>

                        <!-- Kolom Penjual -->
                        <td class="py-4 px-6">
                            <span class="text-sm font-medium text-slate-700">{{ $item->penjual->name ?? '-' }}</span>
                        </td>

                        <!-- Kolom Harga -->
                        <td class="py-4 px-6">
                            <span class="text-sm font-bold text-slate-800">Rp {{ number_format($item->barang->harga ?? 0, 0, ',', '.') }}</span>
                        </td>

                        <!-- Kolom Metode -->
                        <td class="py-4 px-6">
                            @if($item->metode_pembayaran === 'Transfer')
                                <span class="px-3 py-1 text-xs font-bold rounded-md bg-indigo-100 text-indigo-700">Transfer</span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-md bg-slate-100 text-slate-700">COD</span>
                            @endif
                        </td>

                        <!-- Kolom Status -->
                        <td class="py-4 px-6">
                            @if($item->status_transaksi === 'Menunggu Pembayaran')
                                <span class="px-3 py-1.5 text-xs font-bold rounded-lg bg-amber-100 text-amber-700 whitespace-nowrap">Menunggu</span>
                            @elseif($item->status_transaksi === 'Diverifikasi' || $item->status_transaksi === 'Diproses')
                                <span class="px-3 py-1.5 text-xs font-bold rounded-lg bg-blue-100 text-blue-700 whitespace-nowrap">Diproses</span>
                            @elseif($item->status_transaksi === 'Selesai')
                                <span class="px-3 py-1.5 text-xs font-bold rounded-lg bg-emerald-100 text-emerald-700 whitespace-nowrap">Selesai</span>
                            @else
                                <span class="px-3 py-1.5 text-xs font-bold rounded-lg bg-slate-100 text-slate-700 whitespace-nowrap">{{ $item->status_transaksi }}</span>
                            @endif
                        </td>

                        <!-- Kolom Tanggal -->
                        <td class="py-4 px-6">
                            <span class="text-sm text-slate-500 font-medium whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</span>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-16 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-slate-500 font-medium text-sm">Belum ada riwayat transaksi sama sekali nih.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($transaksis->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $transaksis->links() }}
        </div>
    @endif

</div>