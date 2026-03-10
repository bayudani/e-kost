<div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto w-full">
    @section('page_title', 'Kelola Barang Saya')
    
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 lg:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Kelola Barang Saya</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1 sm:mt-1.5 font-medium">Pantau dan kelola inventaris dagangan Anda di sini.</p>
        </div>
        <button wire:click="openModal" class="w-full sm:w-auto px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Barang
        </button>
    </div>

    <!-- Alert Message -->
    @if (session()->has('message'))
        <div class="flex items-center gap-3 p-3.5 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-xs sm:text-sm font-medium shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Card Grid Section (Pengganti Tabel) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
        @forelse($barangs as $item)
            <div wire:key="barang-{{ $item->id }}" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col group hover:shadow-md transition-all duration-300">
                
                <!-- Card Image Header -->
                <div class="relative aspect-[4/3] bg-slate-50 overflow-hidden flex-shrink-0 border-b border-slate-100">
                    @if($item->foto)
                        <img src="{{ asset('storage/'.$item->foto) }}" alt="{{ $item->nama_barang }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    @endif
                    
                    <!-- Overlay Badge Status -->
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase border backdrop-blur-md shadow-sm
                            {{ $item->status === 'tersedia' 
                                ? 'bg-emerald-500/90 text-white border-emerald-400' 
                                : 'bg-rose-500/90 text-white border-rose-400' }}">
                            {{ $item->status }}
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-4 sm:p-5 flex flex-col flex-1">
                    <!-- Badges (Kategori & Kondisi) -->
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 rounded-md text-[10px] font-bold uppercase tracking-wider truncate max-w-[100px]">
                            {{ $item->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-md text-[10px] font-bold uppercase tracking-wider truncate">
                            {{ $item->kondisi_barang }}
                        </span>
                    </div>

                    <!-- Item Name & ID -->
                    <h3 class="font-bold text-slate-800 text-base sm:text-lg leading-snug mb-1 line-clamp-2" title="{{ $item->nama_barang }}">
                        {{ $item->nama_barang }}
                    </h3>
                    <p class="text-[10px] sm:text-[11px] text-slate-400 font-medium mb-4">ID: #{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}</p>

                    <!-- Price -->
                    <div class="mt-auto">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-0.5">Harga</p>
                        <p class="text-xl font-black text-blue-600 tracking-tight">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Card Footer (Actions) -->
                <div class="p-3 bg-slate-50/80 border-t border-slate-100 flex gap-2">
                    <button wire:click="editBarang({{ $item->id }})" class="flex-1 py-2.5 bg-white border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 rounded-xl transition-all text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                    <button wire:click="deleteBarang({{ $item->id }})" wire:confirm="Yakin mau hapus barang ini?" class="flex-1 py-2.5 bg-white border border-slate-200 text-slate-600 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 rounded-xl transition-all text-xs font-bold flex items-center justify-center gap-1.5 shadow-sm" title="Hapus">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <!-- Empty State memanjang penuhi grid -->
            <div class="col-span-full py-16 sm:py-24 text-center bg-white rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 tracking-tight mb-2">Belum ada barang dagangan</h3>
                <p class="text-slate-500 font-medium text-sm mb-6">Mulai jualan dengan menambahkan barang pertama Anda ke katalog.</p>
                <button wire:click="openModal" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Posting Barang Pertama
                </button>
            </div>
        @endforelse
    </div>

    <!-- Modal Form (Tetap sama seperti sebelumnya) -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4 sm:p-6 z-[60]">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl flex flex-col max-h-[90dvh] sm:max-h-[85vh] animate-in fade-in zoom-in-95 duration-200">
                
                <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 flex-shrink-0 rounded-t-2xl">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">{{ $isEditMode ? 'Edit Data Barang' : 'Posting Barang Baru' }}</h3>
                    <button wire:click="closeModal" class="p-1.5 sm:p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="overflow-y-auto custom-scrollbar p-5 sm:p-8">
                    <form wire:submit.prevent="saveBarang" class="space-y-5 sm:space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                            <div class="space-y-1.5">
                                <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nama Barang</label>
                                <input type="text" wire:model="nama_barang" class="w-full rounded-xl border-slate-200 bg-slate-50 px-3.5 py-2 sm:px-4 sm:py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Contoh: Meja Lipat Minimalis">
                                @error('nama_barang') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kategori</label>
                                <select wire:model="kategori_id" class="w-full rounded-xl border-slate-200 bg-slate-50 px-3.5 py-2 sm:px-4 sm:py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}">{{ ucfirst($k->nama_kategori) }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kondisi</label>
                                <select wire:model="kondisi_barang" class="w-full rounded-xl border-slate-200 bg-slate-50 px-3.5 py-2 sm:px-4 sm:py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baru">Baru</option>
                                    <option value="Bekas - Seperti Baru">Bekas - Seperti Baru</option>
                                    <option value="Bekas - Baik">Bekas - Baik</option>
                                    <option value="Bekas - Cukup">Bekas - Cukup</option>
                                </select>
                                @error('kondisi_barang') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Harga (Rp)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 sm:pl-4 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-sm font-medium">Rp</span>
                                    </div>
                                    <input type="number" wire:model="harga" class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 pr-3.5 py-2 sm:pr-4 sm:py-2.5 text-sm font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="0">
                                </div>
                                @error('harga') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Deskripsi Lengkap</label>
                            <textarea wire:model="deskripsi" rows="3" class="w-full rounded-xl border-slate-200 bg-slate-50 px-3.5 py-2 sm:px-4 sm:py-3 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Jelaskan spesifikasi, minus (jika ada), dan alasan dijual..."></textarea>
                            @error('deskripsi') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Foto Produk</label>
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                                <label class="flex-shrink-0 cursor-pointer w-full sm:w-auto text-center px-4 py-2 sm:py-2.5 bg-white border border-slate-200 hover:bg-slate-50 hover:border-blue-300 rounded-xl text-sm font-medium text-blue-600 transition-all shadow-sm">
                                    <span>Pilih Gambar</span>
                                    <input type="file" wire:model="foto" class="hidden" accept="image/*">
                                </label>
                                <span class="text-xs text-slate-400 truncate" wire:loading.remove wire:target="foto">
                                    @if($foto && !is_string($foto))
                                        {{ $foto->getClientOriginalName() }}
                                    @else
                                        Maksimal file 2MB (JPG/PNG)
                                    @endif
                                </span>
                                <span class="text-xs text-blue-500 font-medium animate-pulse" wire:loading wire:target="foto">Mengunggah foto...</span>
                            </div>
                            @error('foto') <span class="text-rose-500 text-xs font-medium block">{{ $message }}</span> @enderror
                            
                            @if ($foto && !is_string($foto))
                                <div class="mt-3 sm:mt-4 p-1.5 sm:p-2 bg-slate-50 rounded-xl border border-slate-100 inline-block">
                                    <img src="{{ $foto->temporaryUrl() }}" class="h-20 w-20 sm:h-24 sm:w-24 object-cover rounded-lg shadow-sm border border-slate-200">
                                </div>
                            @elseif($isEditMode && $foto)
                                <div class="mt-3 sm:mt-4 p-1.5 sm:p-2 bg-slate-50 rounded-xl border border-slate-100 inline-block">
                                    <img src="{{ asset('storage/'.$foto) }}" class="h-20 w-20 sm:h-24 sm:w-24 object-cover rounded-lg shadow-sm border border-slate-200">
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row gap-2.5 sm:gap-3 pt-5 sm:pt-6 border-t border-slate-100 mt-6 sm:mt-8">
                            <button type="button" wire:click="closeModal" class="w-full sm:flex-1 py-2.5 px-4 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold rounded-xl transition-colors text-sm">Batal</button>
                            <button type="submit" class="w-full sm:flex-1 py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all text-sm">
                                <span wire:loading.remove wire:target="saveBarang">Simpan Barang</span>
                                <span wire:loading wire:target="saveBarang" class="flex items-center justify-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>