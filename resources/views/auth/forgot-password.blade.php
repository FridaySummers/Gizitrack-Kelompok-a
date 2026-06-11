<x-guest-layout>
    <div class="flex flex-col lg:flex-row min-h-screen bg-gray-50">
        {{-- Left Side: Decorative & Brand --}}
        <div class="hidden lg:flex lg:w-7/12 bg-emerald-600 p-12 flex-col justify-center relative overflow-hidden">
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
                        Pulihkan Akses Anda.
                    </h1>
                    <p class="text-xl text-emerald-50/90 font-medium leading-relaxed">
                        Lupa kata sandi? Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan tautan untuk mengatur ulang akses Anda.
                    </p>
                </div>
            </div>

            <div class="absolute bottom-12 left-12 z-10 flex items-center gap-6 text-emerald-100/60 font-black uppercase tracking-widest text-[10px]">
                <span>Logistics Security</span>
                <span class="w-1 h-1 bg-emerald-400 rounded-full"></span>
                <span>Enterprise Protocol</span>
                <span class="w-1 h-1 bg-emerald-400 rounded-full"></span>
                <span>v2.0 Stable</span>
            </div>
        </div>

        {{-- Right Side: Forgot Password Form --}}
        <div class="w-full lg:w-5/12 flex items-center justify-center p-8 lg:p-16 bg-white relative">
            <div class="w-full max-w-md">
                {{-- Mobile Brand --}}
                <div class="lg:hidden flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                        <span class="text-2xl">🥗</span>
                    </div>
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight">GiziTrack</h1>
                </div>

                <div class="mb-10">
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight uppercase">Lupa Sandi?</h2>
                    <p class="text-gray-400 mt-2 font-medium">Sistem keamanan kami akan membantu Anda kembali.</p>
                </div>

                {{-- Status --}}
                <x-auth-session-status class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 font-bold text-sm" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-2">
                        <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Alamat Email Terdaftar</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                                   class="block w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold placeholder:text-gray-300"
                                   placeholder="name@company.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="pt-2 space-y-4">
                        <button type="submit"
                                class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                            Kirim Tautan Atur Ulang
                        </button>

                        <a href="{{ route('login') }}"
                           class="flex items-center justify-center gap-2 w-full py-4 bg-gray-50 hover:bg-gray-100 text-gray-500 font-black text-xs uppercase tracking-widest rounded-2xl transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Login
                        </a>
                    </div>
                </form>
            </div>

            {{-- Decorative circles for right side --}}
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-50/50 rounded-full blur-3xl -z-0 pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-gray-50 rounded-full blur-3xl -z-0 pointer-events-none"></div>
        </div>
    </div>
</x-guest-layout>
