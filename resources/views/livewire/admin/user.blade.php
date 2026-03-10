<div class="space-y-4 sm:space-y-6 max-w-7xl mx-auto w-full p-4 sm:p-6 lg:p-8">
    @section('page_title', 'Kelola Pengguna')

    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5 sm:p-6 lg:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-5">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800 tracking-tight">Kelola Pengguna</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1 sm:mt-1.5 font-medium">Manajemen akses dan data akun Admin, Penjual, dan Pembeli.</p>
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
                                    <!-- Tombol Edit -->
                                    <button wire:click="editUser({{ $user->id }})" class="p-1.5 sm:p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <!-- Tombol Delete -->
                                    <button wire:click="deleteUser({{ $user->id }})" wire:confirm="Yakin mau hapus data user ini secara permanen?" class="p-1.5 sm:p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus">
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

    <!-- ========================================== -->
    <!-- 🔥 MODAL POP-UP EDIT USER 🔥 -->
    <!-- ========================================== -->
    @if($isEditModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4 sm:p-6 z-[60]">
            <!-- Modal Content -->
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md flex flex-col animate-in fade-in zoom-in-95 duration-200">
                
                <!-- Header Modal -->
                <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                    <h3 class="text-base sm:text-lg font-bold text-slate-800">Edit Data Pengguna</h3>
                    <button wire:click="closeModal" class="p-1.5 sm:p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Body Modal (Form) -->
                <div class="p-5 sm:p-6">
                    <form wire:submit.prevent="updateUser" class="space-y-4 sm:space-y-5">
                        
                        <!-- Input Nama -->
                        <div class="space-y-1.5">
                            <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="w-full rounded-xl border-slate-200 bg-slate-50 px-3.5 py-2 sm:px-4 sm:py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="Masukkan nama pengguna">
                            @error('name') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Input Email -->
                        <div class="space-y-1.5">
                            <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Email Akun</label>
                            <input type="email" wire:model="email" class="w-full rounded-xl border-slate-200 bg-slate-50 px-3.5 py-2 sm:px-4 sm:py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors" placeholder="email@contoh.com">
                            @error('email') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Select Role -->
                        <div class="space-y-1.5">
                            <label class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-wider">Role Akses</label>
                            <select wire:model="role" class="w-full rounded-xl border-slate-200 bg-slate-50 px-3.5 py-2 sm:px-4 sm:py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors cursor-pointer">
                                <option value="pembeli">Pembeli</option>
                                <option value="penjual">Penjual</option>
                                <option value="admin">Admin</option>
                            </select>
                            @error('role') <span class="text-rose-500 text-xs font-medium">{{ $message }}</span> @enderror
                        </div>

                        <!-- Footer Modal (Buttons) -->
                        <div class="flex flex-col-reverse sm:flex-row gap-2.5 sm:gap-3 pt-5 sm:pt-6 mt-6 sm:mt-8 border-t border-slate-100">
                            <button type="button" wire:click="closeModal" class="w-full sm:flex-1 py-2.5 px-4 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-semibold rounded-xl transition-colors text-sm">
                                Batal
                            </button>
                            <button type="submit" class="w-full sm:flex-1 py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md hover:shadow-blue-500/20 transition-all text-sm flex justify-center items-center gap-2">
                                <span wire:loading.remove wire:target="updateUser">Simpan Perubahan</span>
                                <span wire:loading wire:target="updateUser" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif
</div>