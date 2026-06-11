<x-guest-layout>
    <div class="flex flex-col lg:flex-row min-h-screen bg-gray-50">
        {{-- Left Side: Decorative & Brand --}}
        <div class="hidden lg:flex lg:w-5/12 bg-emerald-600 p-12 flex-col justify-center relative overflow-hidden">
            {{-- Abstract Shapes --}}
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-emerald-500 rounded-full opacity-50 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-emerald-700 rounded-full opacity-30 blur-3xl"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10 animate-fade-in">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30 shadow-xl">
                        <span class="text-3xl">🥗</span>
                    </div>
                    <span class="text-2xl font-black text-white tracking-tight uppercase">GiziTrack</span>
                </div>

                <div class="max-w-md">
                    <h1 class="text-6xl font-black text-white tracking-tighter mb-6 drop-shadow-sm leading-[1.1]">
                        Bergabunglah Sekarang.
                    </h1>
                    <p class="text-xl text-emerald-50/90 font-medium leading-relaxed">
                        Mulai perjalanan Anda dalam mengelola distribusi gizi sekolah yang lebih transparan dan efisien.
                    </p>
                </div>
            </div>

            <div class="absolute bottom-12 left-12 z-10 flex items-center gap-6 text-emerald-100/60 font-black uppercase tracking-widest text-[10px]">
                <span>Ecosystem Growth</span>
                <span class="w-1 h-1 bg-emerald-400 rounded-full"></span>
                <span>Verified Partners</span>
                <span class="w-1 h-1 bg-emerald-400 rounded-full"></span>
                <span>v2.0 Stable</span>
            </div>
        </div>

        {{-- Right Side: Register Form --}}
        <div class="w-full lg:w-7/12 flex items-center justify-center p-8 lg:p-16 bg-white relative overflow-y-auto">
            <div class="w-full max-w-2xl py-12">
                {{-- Mobile Brand --}}
                <div class="lg:hidden flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                        <span class="text-2xl">🥗</span>
                    </div>
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight uppercase">GiziTrack</h1>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight uppercase">Registrasi Akun</h2>
                    <p class="text-gray-400 mt-2 font-medium">Lengkapi data di bawah untuk mendaftarkan entitas Anda.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap / Instansi</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                       class="block w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold placeholder:text-gray-300"
                                       placeholder="Nama Anda">
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-2">
                            <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Alamat Email</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                                       class="block w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold placeholder:text-gray-300"
                                       placeholder="email@example.com">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>
                    </div>

                    <!-- No Telepon -->
                    <div class="space-y-2">
                        <label for="no_hp" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Nomor Telepon Aktif</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input id="no_hp" type="text" name="no_hp" :value="old('no_hp')" required autocomplete="tel"
                                   class="block w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold placeholder:text-gray-300"
                                   placeholder="Contoh: 08123456789">
                        </div>
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Kata Sandi</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   class="block w-full px-4 py-4 bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label for="password_confirmation" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Konfirmasi Sandi</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="block w-full px-4 py-4 bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <div class="pt-2 space-y-4">
                        <button type="submit"
                                class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                            Buat Akun Sekarang
                        </button>

                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-400">
                                Sudah memiliki akun?
                                <a href="{{ route('login') }}" class="text-emerald-600 font-black uppercase tracking-widest text-xs ml-1 hover:underline">Masuk Di Sini</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Decorative circles --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-50/50 rounded-full blur-3xl -z-0 pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-gray-50 rounded-full blur-3xl -z-0 pointer-events-none"></div>
        </div>
    </div>
</x-guest-layout>
