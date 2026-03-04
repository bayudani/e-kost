@section('page_title', 'Katalog Barang')

<div class="space-y-6 flex-1 p-6">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-slate-800 uppercase italic">Kelola Barang Saya</h2>
            <p class="text-slate-500 text-sm mt-1">Pantau dan kelola inventaris dagangan anda di sini.</p>
        </div>
        <button wire:click="openModal" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-100 transition-all uppercase tracking-widest flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Barang
        </button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl font-bold text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table Barang -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <th class="px-6 py-4">Produk</th>
                    <th class="px-6 py-4">Kondisi</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($barangs as $item)
                    <tr wire:key="barang-{{ $item->id }}" class="hover:bg-slate-50/50 transition-all">
                        <td class="px-6 py-4 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden">
                                <img src="{{ asset('storage/'.$item->foto) }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">{{ $item->nama_barang }}</p>
                                <p class="text-[10px] text-slate-400 uppercase font-black">ID #{{ $item->id }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-slate-500 uppercase">{{ $item->kondisi_barang }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-black text-blue-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <!-- Badge Status sesuai req: tersedia / terjual -->
                            <span class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-tighter
                                {{ $item->status === 'tersedia' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex justify-center gap-2">
                            <button wire:click="editBarang({{ $item->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button wire:click="deleteBarang({{ $item->id }})" wire:confirm="Yakin mau hapus barang ini?" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold uppercase text-xs italic">Belum ada barang dagangan nih.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <h3 class="text-xl font-black text-slate-800 uppercase italic">{{ $isEditMode ? 'Edit Barang' : 'Posting Barang Baru' }}</h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>

                <form wire:submit.prevent="saveBarang" class="p-8 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase">Nama Barang</label>
                            <input type="text" wire:model="nama_barang" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 font-medium" placeholder="Contoh: Meja Lipat Minimalis">
                            @error('nama_barang') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase">Kategori</label>
                            <select wire:model="kategori_id" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 font-medium">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ ucfirst($k->nama_kategori) }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase">Kondisi</label>
                            <select wire:model="kondisi_barang" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 font-medium">
                                <option value="">Pilih Kondisi</option>
                                <option value="Baru">Baru</option>
                                <option value="Bekas - Seperti Baru">Bekas - Seperti Baru</option>
                                <option value="Bekas - Baik">Bekas - Baik</option>
                                <option value="Bekas - Cukup">Bekas - Cukup</option>
                            </select>
                            @error('kondisi_barang') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase">Harga (Rp)</label>
                            <input type="number" wire:model="harga" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 font-black text-blue-600" placeholder="0">
                            @error('harga') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Deskripsi</label>
                        <textarea wire:model="deskripsi" rows="3" class="w-full rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 font-medium" placeholder="Jelaskan kondisi barang lu secara detail..."></textarea>
                        @error('deskripsi') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase">Foto Barang</label>
                        <input type="file" wire:model="foto" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('foto') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    @if ($foto)
                        <div class="flex flex-col items-center">
                            <p class="text-[10px] font-black text-blue-400 uppercase mb-2">Pratinjau Foto:</p>
                            <img src="{{ $foto->temporaryUrl() }}" class="h-32 rounded-lg shadow-md">
                        </div>
                    @endif

                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="closeModal" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black rounded-xl uppercase tracking-widest">Batal</button>
                        <button type="submit" class="flex-1 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg shadow-blue-100 uppercase tracking-widest">
                            <span wire:loading.remove>Simpan Barang</span>
                            <span wire:loading>Memproses...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>