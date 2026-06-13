<section class="space-y-6">
    <header>
        <h2 class="text-sm font-black text-rose-600 uppercase tracking-tight">
            {{ __('Zona Bahaya') }}
        </h2>
        <p class="mt-1 text-[10px] font-black text-gray-400 uppercase tracking-widest leading-relaxed">
            {{ __('Penghapusan akun bersifat permanen. Seluruh data distribusi dan profil Anda akan terhapus sepenuhnya.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-8 py-3 bg-rose-600 hover:bg-rose-700 text-white font-black text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-rose-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]"
    >{{ __('Hapus Akun Saya') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 space-y-6">
            @csrf
            @method('delete')

            <div>
                <h2 class="text-lg font-black text-gray-800 uppercase tracking-tight">
                    {{ __('Konfirmasi Penghapusan') }}
                </h2>
                <p class="mt-2 text-sm font-medium text-gray-500 leading-relaxed">
                    {{ __('Tindakan ini tidak dapat dibatalkan. Silakan masukkan password Anda untuk memverifikasi identitas sebelum penghapusan permanen.') }}
                </p>
            </div>

            <div class="space-y-2">
                <x-input-label for="password" value="{{ __('Password Verifikasi') }}" class="text-[10px] font-black uppercase tracking-widest ml-1 text-gray-400" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none font-bold"
                    placeholder="Password Anda..."
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                <button type="button" x-on:click="$dispatch('close')" class="px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-500 font-black text-xs uppercase tracking-widest rounded-xl transition-all">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-8 py-3 bg-rose-600 hover:bg-rose-700 text-white font-black text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-rose-200 transition-all">
                    {{ __('Ya, Hapus Permanen') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
