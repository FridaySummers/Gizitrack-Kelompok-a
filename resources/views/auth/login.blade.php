<x-guest-layout>
    <div class="flex min-h-screen bg-white">
        <!-- Kolom Kiri: Branding & Visuals -->
        <div class="hidden lg:flex lg:w-7/12 bg-emerald-600 relative overflow-hidden items-center justify-center p-16">
            <!-- Dynamic Background Elements -->
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-emerald-500 rounded-full blur-3xl opacity-40 animate-pulse"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-emerald-400 rounded-full blur-3xl opacity-30"></div>
                <svg class="absolute inset-0 h-full w-full opacity-[0.03]" fill="none" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="premium-grid" width="8" height="8" patternUnits="userSpaceOnUse">
                            <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100" height="100" fill="url(#premium-grid)" />
                </svg>
            </div>

            <div class="relative z-10 max-w-xl text-center">
                <div class="inline-flex items-center justify-center w-28 h-28 bg-white/10 backdrop-blur-xl rounded-[2.5rem] mb-10 border border-white/20 shadow-2xl transform hover:rotate-6 transition-transform duration-500">
                    <span class="text-7xl">🌿</span>
                </div>
                <h1 class="text-6xl font-[900] text-white tracking-tighter mb-6 drop-shadow-sm">
                    GiziTrack
                </h1>
                <p class="text-2xl text-emerald-50/90 font-medium leading-relaxed mb-12">
                    Platform Tata Kelola Makanan Bergizi Gratis untuk Masa Depan Bangsa.
                </p>

                <div class="grid grid-cols-2 gap-8 text-left">
                    <div class="group bg-white/5 hover:bg-white/10 backdrop-blur-md p-6 rounded-[2rem] border border-white/10 transition-all duration-300">
                        <div class="w-10 h-10 bg-emerald-400/20 rounded-xl flex items-center justify-center mb-4 text-emerald-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h4 class="text-white font-bold text-lg mb-1">Terpantau</h4>
                        <p class="text-emerald-100/70 text-sm leading-snug">Monitoring distribusi secara real-time dan akurat.</p>
                    </div>
                    <div class="group bg-white/5 hover:bg-white/10 backdrop-blur-md p-6 rounded-[2rem] border border-white/10 transition-all duration-300">
                        <div class="w-10 h-10 bg-emerald-400/20 rounded-xl flex items-center justify-center mb-4 text-emerald-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h4 class="text-white font-bold text-lg mb-1">Terpercaya</h4>
                        <p class="text-emerald-100/70 text-sm leading-snug">Sistem laporan transparan dan akuntabel.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Login Form -->
        <div class="w-full lg:w-5/12 flex items-center justify-center p-8 sm:p-16 lg:p-20 relative overflow-hidden bg-white">
            <div class="w-full max-w-sm relative z-10">
                <!-- Mobile Only Branding -->
                <div class="lg:hidden flex flex-col items-center mb-10">
                    <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center mb-4 border border-emerald-100 shadow-sm">
                        <span class="text-5xl">🌿</span>
                    </div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">GiziTrack</h1>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-3">Selamat Datang</h2>
                    <p class="text-gray-500 font-medium leading-relaxed">Silakan masuk ke akun Anda untuk mengelola distribusi makanan gizi.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6 text-sm font-semibold" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-bold text-gray-700 tracking-wide ml-1">Alamat Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-emerald-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"></path></svg>
                            </div>
                            <input type="email" name="email" id="email"
                                   class="block w-full pl-12 pr-4 py-4 bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all outline-none placeholder:text-gray-400"
                                   placeholder="nama@email.com"
                                   value="{{ old('email') }}" required autofocus autocomplete="username">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold" />
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between mb-1 px-1">
                            <label for="password" class="text-sm font-bold text-gray-700 tracking-wide">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-extrabold text-emerald-600 hover:text-emerald-700 transition-colors">
                                    Lupa sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-emerald-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input type="password" name="password" id="password"
                                   class="block w-full pl-12 pr-4 py-4 bg-gray-50/50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all outline-none placeholder:text-gray-400"
                                   placeholder="••••••••"
                                   required autocomplete="current-password">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center group px-1">
                        <input id="remember_me" name="remember" type="checkbox"
                               class="w-5 h-5 text-emerald-600 border-gray-300 rounded-lg focus:ring-emerald-500/20 cursor-pointer transition-all">
                        <label for="remember_me" class="ml-3 text-sm font-semibold text-gray-500 cursor-pointer group-hover:text-gray-700 transition-colors">Ingat saya di perangkat ini</label>
                    </div>

                    <!-- Login Button -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-4 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-base rounded-xl shadow-lg shadow-emerald-200/40 transform transition-all hover:scale-[1.01] active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-emerald-500/20">
                            Masuk ke Dashboard
                        </button>
                    </div>

                    <!-- Registration Link -->
                    @if (Route::has('register'))
                        <div class="text-center pt-2">
                            <p class="text-sm font-semibold text-gray-400">
                                Belum memiliki akses?
                                <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 font-extrabold ml-1 transition-colors underline decoration-emerald-200 underline-offset-4 decoration-2">Hubungi Admin</a>
                            </p>
                        </div>
                    @endif
                </form>

                <!-- System Footer -->
                <div class="mt-20 flex flex-col items-center justify-center space-y-4">
                    <div class="h-px w-12 bg-gray-100"></div>
                    <p class="text-[10px] text-gray-300 uppercase font-black tracking-[0.2em] text-center">
                        &copy; 2026 GiziTrack System &bull; Versi 1.0
                    </p>
                </div>
            </div>

            <!-- Subtle Decorative Circles -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-50/50 rounded-full blur-3xl -z-0"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-gray-50 rounded-full blur-3xl -z-0"></div>
        </div>
    </div>
</x-guest-layout>
