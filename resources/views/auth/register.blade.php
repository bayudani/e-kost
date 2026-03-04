<x-guest-layout>
    <!-- Card Container -->
    <div class="w-full max-w-md mx-auto bg-white sm:shadow-2xl sm:shadow-blue-900/10 rounded-3xl p-6 sm:p-10 border border-slate-100">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-blue-600 tracking-tight">Registrasi</h2>
            <p class="text-sm text-slate-500 mt-2">Silakan lengkapi data untuk membuat akun.</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Username -->
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Username</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-sm placeholder:text-slate-400"
                    placeholder="Masukkan username...">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-sm placeholder:text-slate-400"
                    placeholder="Masukkan email...">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Role (Daftar Sebagai) -->
            <div>
                <label for="role" class="block text-sm font-bold text-slate-700 mb-2">Daftar Sebagai</label>
                <div class="relative">
                    <select id="role" name="role" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none appearance-none bg-white text-sm text-slate-700 font-medium">
                        <option value="" disabled selected class="text-slate-400">Pilih akun</option>
                        <option value="pembeli" {{ old('role') == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                        <option value="penjual" {{ old('role') == 'penjual' ? 'selected' : '' }}>Penjual</option>
                    </select>
                    <!-- Custom Chevron Icon -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="h-5 w-5 bg-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-sm placeholder:text-slate-400"
                    placeholder="Masukkan password...">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-sm placeholder:text-slate-400"
                    placeholder="Ulangi password...">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-[#5C81A6] hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition-all active:scale-[0.98] uppercase tracking-wider text-sm">
                    Daftar
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-slate-500">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-[#5C81A6] hover:text-blue-700 hover:underline transition-colors">Masuk di sini</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>