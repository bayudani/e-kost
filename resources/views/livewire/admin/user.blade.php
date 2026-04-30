<div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Kelola Pengguna')

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 lg:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Kelola Pengguna</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1 sm:mt-1.5 font-medium">Pantau data akun Admin, Penjual, dan Pembeli yang terdaftar.</p>
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

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                <thead class="bg-slate-50/80 border-b border-slate-200">
                    <tr class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="px-4 sm:px-6 py-3 sm:py-4 w-20">ID</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Pengguna</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Email</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4">Role Akses</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr wire:key="user-{{ $user->id }}" class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-slate-400">
                                #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 flex items-center gap-3 sm:gap-4">
                                <!-- Avatar Inisial -->
                                <div class="h-9 w-9 sm:h-10 sm:w-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center font-bold text-slate-600 shadow-inner border border-slate-200 flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-semibold text-slate-800 text-sm">{{ $user->name }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <span class="text-sm font-medium text-slate-500">{{ $user->email }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <!-- Badge Role -->
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] sm:text-[11px] font-bold uppercase tracking-wider border shadow-sm
                                    {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-200' : '' }}
                                    {{ $user->role === 'penjual' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                    {{ $user->role === 'pembeli' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center justify-center gap-1.5 sm:gap-2">
                                    <!-- Tombol Detail (Mata) -->
                                    <button wire:click="viewUser({{ $user->id }})" class="p-1.5 sm:p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <!-- Tombol Delete -->
                                    <button wire:click="deleteUser({{ $user->id }})" wire:confirm="Yakin mau hapus data user ini secara permanen?" class="p-1.5 sm:p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 sm:px-6 py-12 sm:py-16 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-1 sm:mb-2">
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-medium text-xs sm:text-sm">Belum ada data pengguna yang terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    @if($isViewModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4 sm:p-6 z-[60]">
            <!-- Modal Content -->
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md flex flex-col animate-in fade-in zoom-in-95 duration-200">
                
                <!-- Header Modal -->
                <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">Detail Pengguna</h3>
                    <button wire:click="closeModal" class="p-1.5 sm:p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Body Modal (Read Only) -->
                <div class="p-5 sm:p-6 space-y-6">
                    
                    <!-- Basic Info -->
                    <div class="flex items-center gap-4 mb-2">
                        <div class="h-14 w-14 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black text-xl shadow-inner border border-blue-200 flex-shrink-0">
                            {{ strtoupper(substr($name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-800">{{ $name }}</h4>
                            <span class="inline-flex mt-0.5 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200">
                                Role: {{ $role }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Email Terdaftar</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $email }}</p>
                        </div>
                    </div>

                    <!-- Jika Penjual, tampilkan data rekening -->
                    @if($role === 'penjual')
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 mb-3 flex items-center gap-2 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Data Pencairan / Rekening
                            </h4>
                            
                            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden divide-y divide-slate-100">
                                <div class="p-3.5 flex flex-col">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nomor WhatsApp/HP</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $no_hp ?: 'Belum diisi' }}</span>
                                </div>
                                <div class="p-3.5 flex flex-col">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Bank / E-Wallet</span>
                                    <span class="text-sm font-semibold text-slate-800">{{ $nama_bank ?: 'Belum diisi' }}</span>
                                </div>
                                <div class="p-3.5 flex flex-col bg-slate-50">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nomor Rekening</span>
                                    <span class="text-base font-mono font-bold text-blue-600 tracking-wider">{{ $no_rekening ?: 'Belum diisi' }}</span>
                                </div>
                                <div class="p-3.5 flex flex-col">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Atas Nama</span>
                                    <span class="text-sm font-bold text-slate-800 uppercase">{{ $atas_nama ?: 'Belum diisi' }}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Footer Modal (Tutup) -->
                <div class="px-5 py-4 border-t border-slate-100 bg-slate-50/80 rounded-b-2xl">
                    <button type="button" wire:click="closeModal" class="w-full py-2.5 px-4 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold rounded-xl transition-colors text-sm shadow-sm">
                        Tutup Jendela
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>