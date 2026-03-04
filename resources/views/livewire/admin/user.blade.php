@section('page_title', 'Kelola Pengguna')

<!-- PERBAIKAN: Hapus p-6 di wrapper utama karena di dalam sudah ada px dan py masing-masing -->
<div class="bg-white md:rounded-2xl shadow-sm md:border border-slate-200 overflow-hidden relative flex-1 mb-6">
    
    <!-- Header Card -->
    <!-- PERBAIKAN: Padding disesuaikan untuk mobile (px-4 py-4) dan desktop (md:px-8 md:py-6) -->
    <div class="px-4 md:px-8 py-4 md:py-6 border-b border-slate-100 bg-white flex flex-col sm:flex-row justify-between sm:items-center gap-2">
        <div>
            <h2 class="text-xl font-extrabold text-slate-800">Kelola Pengguna</h2>
            <p class="text-slate-500 text-xs md:text-sm mt-1">Manajemen akses Admin, Penjual, dan Pembeli.</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <!-- PERBAIKAN: Margin disesuaikan untuk mobile -->
        <div class="mx-4 md:mx-8 mt-4 md:mt-6 p-3 md:p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex justify-between items-center transition-all">
            <span class="font-medium text-xs md:text-sm">{{ session('message') }}</span>
            <button wire:click="$set('message', null)" class="text-emerald-700 hover:text-emerald-900 font-bold ml-4">&times;</button>
        </div>
    @endif

    <!-- Table Section -->
    <!-- PERBAIKAN: overflow-x-auto wajib untuk tabel, padding disesuaikan -->
    <div class="overflow-x-auto w-full px-4 md:px-8 py-4">
        <table class="w-full text-left border-collapse min-w-[600px]"> <!-- min-w memaksa tabel bisa di-scroll di HP -->
            <thead class="bg-slate-50 rounded-xl">
                <tr>
                    <!-- PERBAIKAN: Tambah whitespace-nowrap agar teks tidak turun ke bawah/kegencet -->
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider rounded-l-xl whitespace-nowrap">ID</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Nama Pengguna</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Email</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider whitespace-nowrap">Role</th>
                    <th class="py-3 md:py-4 px-4 md:px-6 text-xs font-bold text-slate-400 uppercase tracking-wider text-center rounded-r-xl whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-200">
                        <td class="py-3 md:py-4 px-4 md:px-6 text-sm font-medium text-slate-500 whitespace-nowrap">#{{ $user->id }}</td>
                        <td class="py-3 md:py-4 px-4 md:px-6 whitespace-nowrap">
                            <span class="text-sm font-bold text-slate-800">{{ $user->name }}</span>
                        </td>
                        <td class="py-3 md:py-4 px-4 md:px-6 whitespace-nowrap">
                            <span class="text-sm text-slate-500">{{ $user->email }}</span>
                        </td>
                        <td class="py-3 md:py-4 px-4 md:px-6 whitespace-nowrap">
                            <!-- Badge Role -->
                            <span class="px-3 py-1.5 text-[10px] md:text-xs font-bold rounded-lg 
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $user->role === 'penjual' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $user->role === 'pembeli' ? 'bg-emerald-100 text-emerald-700' : '' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 md:py-4 px-4 md:px-6 flex justify-center space-x-2 whitespace-nowrap">
                            <!-- Tombol Edit -->
                            <button wire:click="editUser({{ $user->id }})" class="p-1.5 md:p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>

                            <!-- Tombol Delete -->
                            <button 
                                wire:click="deleteUser({{ $user->id }})" 
                                wire:confirm="Yakin mau hapus data user ini?"
                                class="p-1.5 md:p-2 text-red-500 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" 
                                title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-10 md:py-12 text-center">
                            <p class="text-slate-500 text-sm">Belum ada data user.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="px-4 md:px-8 py-4 border-t border-slate-100 bg-slate-50">
            {{ $users->links() }}
        </div>
    @endif

    <!-- ========================================== -->
    <!-- 🔥 MODAL POP-UP EDIT USER 🔥 -->
    <!-- ========================================== -->
    @if($isEditModalOpen)
    <!-- PERBAIKAN: p-4 di background agar modal tidak nempel di pinggir layar HP -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity p-4">
        <!-- mx-auto dan max-w memastikan modal responsif -->
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden transform transition-all">
            
            <!-- Header Modal -->
            <div class="px-4 md:px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="text-base md:text-lg font-bold text-slate-800">Edit Data Pengguna</h3>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Body Modal (Form) -->
            <form wire:submit.prevent="updateUser">
                <div class="p-4 md:p-6 space-y-4">
                    
                    <!-- Input Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2">
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Input Email -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                        <input type="email" wire:model="email" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2">
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Select Role -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Role Akun</label>
                        <select wire:model="role" class="w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-3 py-2">
                            <option value="pembeli">Pembeli</option>
                            <option value="penjual">Penjual</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                </div>

                <!-- Footer Modal -->
                <div class="px-4 md:px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col-reverse sm:flex-row justify-end gap-2 md:gap-3">
                    <button type="button" wire:click="closeModal" class="w-full sm:w-auto px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition text-center">
                        Batal
                    </button>
                    <!-- Tombol submit -->
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition flex items-center justify-center">
                        <span wire:loading.remove wire:target="updateUser">Simpan Perubahan</span>
                        <span wire:loading wire:target="updateUser">Menyimpan...</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
    @endif

</div>