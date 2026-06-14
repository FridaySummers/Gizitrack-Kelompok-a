<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col items-center justify-center p-6">
        <div class="w-full max-w-md">
            {{-- Header/Logo --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-600 rounded-2xl shadow-lg shadow-emerald-200 mb-4 transform hover:scale-105 transition-transform">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tight">Verifikasi Keamanan</h2>
                <p class="text-xs font-bold text-rose-500 uppercase tracking-widest mt-2 px-4 py-1.5 bg-rose-50 rounded-full inline-block">
                    Area Sensitif: Konfirmasi Kata Sandi
                </p>
            </div>

            {{-- Confirmation Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden p-8">
                <div class="mb-8 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                    <p class="text-sm font-medium text-gray-600 leading-relaxed text-center">
                        {{ __('Ini adalah area aman aplikasi. Harap verifikasi ulang kata sandi Anda untuk melanjutkan tindakan ini.') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                    @csrf

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">
                            {{ __('Kata Sandi Anda') }}
                        </label>

                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-emerald-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>

                            <input id="password"
                                   class="block w-full pl-11 pr-4 py-4 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold placeholder:text-gray-300"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="••••••••" />
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                            {{ __('Konfirmasi Akses') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Footer Info --}}
            <p class="mt-8 text-center text-[10px] text-gray-400 font-black uppercase tracking-widest">
                &copy; 2026 GiziTrack System &bull; Secure Clearance Module
            </p>
        </div>
    </div>
</x-guest-layout>
