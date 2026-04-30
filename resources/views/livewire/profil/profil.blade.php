<div class="space-y-6 max-w-4xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Profil Saya')

    <!-- Header Section -->
    <div class="mb-8">
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight">Profil Saya</h2>
        <p class="text-sm font-medium text-slate-500 mt-1">Kelola informasi data diri dan rekening pencairan Anda.</p>
    </div>

    <!-- Alert Success -->
    @if (session()->has('message'))
        <div class="flex items-center gap-3 p-4 mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm font-medium shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-slate-100 flex items-center gap-4 bg-slate-50/50">
            <div class="h-16 w-16 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-2xl shadow-inner border border-blue-200">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">{{ auth()->user()->name }}</h3>
                <span class="inline-flex mt-1 px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-200 text-slate-600">
                    Role: {{ auth()->user()->role }}
                </span>
            </div>
        </div>

        <form wire:submit.prevent="simpanProfil" class="p-6 sm:p-8 space-y-8">
            
            <!-- SECTION 1: Informasi Dasar -->
            <div>
                <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informasi Dasar
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors">
                        @error('name') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Email (Tidak bisa diubah)</label>
                        <input type="email" wire:model="email" disabled class="w-full rounded-xl border-slate-200 bg-slate-100 text-slate-500 px-4 py-2.5 text-sm cursor-not-allowed opacity-80">
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- SECTION 2: Info Rekening & Kontak -->
            <div>
                <div class="flex justify-between items-end mb-4">
                    <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Data Kontak
                    </h4>
                    @if(auth()->user()->role === 'penjual')
                        <span class="text-[10px] font-bold text-rose-500 uppercase tracking-widest bg-rose-50 px-2 py-0.5 rounded border border-rose-100">* Wajib untuk Penjual</span>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-6">
                    <!-- Baris 1 -->
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nomor WhatsApp / HP</label>
                        <input type="text" wire:model="no_hp" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Contoh: 08123456789">
                        @error('no_hp') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    @if(auth()->user()->role === 'penjual')
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nama Bank / E-Wallet</label>
                        <input type="text" wire:model="nama_bank" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Contoh: BCA / DANA / GoPay">
                        @error('nama_bank') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Baris 2 -->
                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nomor Rekening</label>
                        <input type="text" wire:model="no_rekening" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors font-mono tracking-wider" placeholder="Masukkan no rekening Anda">
                        @error('no_rekening') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Atas Nama (Pemilik Rekening)</label>
                        <input type="text" wire:model="atas_nama" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Sesuai dengan buku tabungan">
                        @error('atas_nama') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all text-sm flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="simpanProfil">Simpan Perubahan</span>
                    <span wire:loading wire:target="simpanProfil" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>