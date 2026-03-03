@section('page_title', 'Kelola Kategori')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative flex-1 p-6">
    
    <!-- Header Card & Tombol Tambah -->
    <div class="px-8 py-6 border-b border-slate-100 bg-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Kelola Kategori</h2>
            <p class="text-slate-500 text-sm mt-1">Atur kategori barang untuk KostPlace.</p>
        </div>
        
        <!-- Tombol Tambah Kategori -->
        <button wire:click="createKategori" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition flex items-center gap-2 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kategori
        </button>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="mx-8 mt-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex justify-between items-center transition-all">
            <span class="font-medium text-sm">{{ session('message') }}</span>
            <button wire:click="$set('message', null)" class="text-emerald-700 hover:text-emerald-900 font-bold">&times;</button>
        </div>
    @endif

    <!-- Table Section -->
    <div class="overflow-x-auto p-4">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 rounded-xl">
                <tr>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider rounded-l-xl w-24">ID</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Kategori</th>
                    <th class="py-4 px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center rounded-r-xl w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($kategoris as $kategori)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                        <td class="py-4 px-6 text-sm font-medium text-slate-500">#{{ $kategori->id }}</td>
                        
                        <td class="py-4 px-6">
                            <!-- Styling Badge berdasarkan jenis/nama kategori biar kekinian -->
                            @if(strtolower($kategori->nama_kategori) === 'elektronik')
                                <span class="px-3 py-1.5 text-sm font-bold rounded-lg bg-sky-100 text-sky-700 inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Elektronik
                                </span>
                            @elseif(strtolower($kategori->nama_kategori) === 'non elektronik')
                                <span class="px-3 py-1.5 text-sm font-bold rounded-lg bg-amber-100 text-amber-700 inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    Non Elektronik
                                </span>
                            @else
                                <span class="text-sm font-bold text-slate-800 capitalize">{{ $kategori->nama_kategori }}</span>
                            @endif
                        </td>

                        <td class="py-4 px-6 flex justify-center space-x-2">
                            <!-- Tombol Edit -->
                            <button wire:click="editKategori({{ $kategori->id }})" class="p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>

                            <!-- Tombol Delete -->
                            <button 
                                wire:click="deleteKategori({{ $kategori->id }})" 
                                wire:confirm="Yakin mau hapus kategori '{{ $kategori->nama_kategori }}' ini?"
                                class="p-2 text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" 
                                title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-12 text-center">
                            <p class="text-slate-500 text-sm">Belum ada data kategori.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($kategoris->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
            {{ $kategoris->links() }}
        </div>
    @endif

    <!-- ========================================== -->
    <!-- 🔥 MODAL POP-UP (TAMBAH/EDIT) 🔥 -->
    <!-- ========================================== -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden transform transition-all">
            
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800">{{ $modalTitle }}</h3>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form wire:submit.prevent="storeKategori">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kategori</label>
                        <!-- Menggunakan select option jika memang nilainya hanya Enum, kalau bisa custom string ganti jadi text input biasa -->
                        <select wire:model="nama_kategori" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="non elektronik">Non Elektronik</option>
                        </select>
                        @error('nama_kategori') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" wire:click="closeModal" class="px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center">
                        <span wire:loading.remove wire:target="storeKategori">Simpan</span>
                        <span wire:loading wire:target="storeKategori">Memproses...</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
    @endif

</div>