<x-guest-layout>
    <!-- Card Container -->
    <div class="w-full max-w-md mx-auto bg-white sm:shadow-2xl sm:shadow-blue-900/10 rounded-3xl p-6 sm:p-10 border border-slate-100">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-blue-600 tracking-tight">Login</h2>
            <p class="text-sm text-slate-500 mt-2">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-sm placeholder:text-slate-400"
                    placeholder="Masukkan email...">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none text-sm placeholder:text-slate-400"
                    placeholder="Masukkan password...">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-[#5C81A6] shadow-sm focus:ring-[#5C81A6] focus:ring-offset-0 w-4 h-4 cursor-pointer" name="remember">
                    <span class="ms-2 text-sm font-medium text-slate-500 group-hover:text-slate-700 transition-colors">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-bold text-[#5C81A6] hover:text-blue-700 hover:underline transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-[#5C81A6] hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition-all active:scale-[0.98] uppercase tracking-wider text-sm">
                    Masuk
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-slate-500">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-[#5C81A6] hover:text-blue-700 hover:underline transition-colors">Daftar sekarang</a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>