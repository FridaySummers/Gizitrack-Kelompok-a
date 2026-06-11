<section class="space-y-6">
    <header>
        <h2 class="text-sm font-black text-gray-800 uppercase tracking-tight">
            {{ __('Update Identitas') }}
        </h2>
        <p class="mt-1 text-[10px] font-black text-gray-400 uppercase tracking-widest">
            {{ __("Perbarui detail profil akun dan alamat korespondensi Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- NAME -->
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-[10px] font-black uppercase tracking-widest ml-1 text-gray-400" />
                <x-text-input
                    id="name"
                    name="name"
                    type="text"
                    class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold"
                    :value="old('name', $user->name)"
                    required
                    autofocus
                    autocomplete="name"
                />
                <x-input-error class="mt-1" :messages="$errors->get('name')" />
            </div>

            <!-- EMAIL (READONLY) -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Alamat Email')" class="text-[10px] font-black uppercase tracking-widest ml-1 text-gray-400" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        class="block w-full pl-11 pr-4 py-3 bg-gray-100 border border-gray-200 text-gray-400 text-sm rounded-xl cursor-not-allowed font-medium"
                        :value="old('email', $user->email)"
                        readonly
                    />
                </div>
            </div>
        </div>

        <!-- NO TELEPON -->
        <div class="space-y-2">
            <x-input-label for="no_hp" :value="__('Nomor Telepon / WhatsApp')" class="text-[10px] font-black uppercase tracking-widest ml-1 text-gray-400" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <x-text-input
                    id="no_hp"
                    name="no_hp"
                    type="text"
                    class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold"
                    :value="old('no_hp', $user->no_hp)"
                    autocomplete="tel"
                    placeholder="Contoh: 08123456789"
                />
            </div>
            <x-input-error class="mt-1" :messages="$errors->get('no_hp')" />
        </div>

        <!-- ALAMAT -->
        <div class="space-y-2">
            <x-input-label for="alamat" :value="__('Alamat Lengkap Operasional')" class="text-[10px] font-black uppercase tracking-widest ml-1 text-gray-400" />
            <textarea
                id="alamat"
                name="alamat"
                class="block w-full p-4 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-medium placeholder:text-gray-300"
                rows="3"
                placeholder="Masukkan alamat lengkap kantor/sekolah..."
            >{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error class="mt-1" :messages="$errors->get('alamat')" />
        </div>

        <!-- BUTTON -->
        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-emerald-600 font-bold text-xs uppercase tracking-widest animate-pulse"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ __('Data Berhasil Disinkronkan') }}
                </div>
            @endif
        </div>
    </form>
</section>
