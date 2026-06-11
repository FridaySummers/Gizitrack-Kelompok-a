<section class="space-y-6">
    <header>
        <h2 class="text-sm font-black text-gray-800 uppercase tracking-tight">
            {{ __('Keamanan Akun') }}
        </h2>
        <p class="mt-1 text-[10px] font-black text-gray-400 uppercase tracking-widest leading-relaxed">
            {{ __('Gunakan kombinasi password yang kuat untuk menjaga integritas data Anda.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-2">
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" class="text-[10px] font-black uppercase tracking-widest ml-1 text-gray-400" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password" :value="__('Password Baru')" class="text-[10px] font-black uppercase tracking-widest ml-1 text-gray-400" />
            <x-text-input id="update_password_password" name="password" type="password" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>

        <div class="space-y-2">
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" class="text-[10px] font-black uppercase tracking-widest ml-1 text-gray-400" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-8 py-3 bg-slate-800 hover:bg-slate-900 text-white font-black text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-slate-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                {{ __('Ganti Password') }}
            </button>

            @if (session('status') === 'password-updated')
                 <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-emerald-600 font-bold text-xs uppercase tracking-widest"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Tersimpan') }}
                </div>
            @endif
        </div>
    </form>
</section>
