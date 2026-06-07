<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- NAME -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- EMAIL (READONLY) -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full bg-gray-100 cursor-not-allowed" 
                :value="old('email', $user->email)" 
                readonly
            />
            <p class="text-xs text-gray-500 mt-1">Email tidak dapat diubah. Hubungi Administrator jika perlu penyesuaian.</p>
        </div>

        <!-- NO TELEPON (BARU) -->
        <div>
            <x-input-label for="no_hp" :value="__('No Telepon')" />
            <x-text-input 
                id="no_hp" 
                name="no_hp" 
                type="number" 
                class="mt-1 block w-full" 
                :value="old('no_hp', $user->no_hp)" 
                autocomplete="tel"
                placeholder="Masukkan nomor telepon"
            />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
        </div>

        <!-- ALAMAT (BARU) -->
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <textarea 
                id="alamat" 
                name="alamat" 
                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                rows="3"
                placeholder="Masukkan alamat lengkap"
            >{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <!-- BUTTON -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >
                    {{ __('Profile berhasil diperbarui!') }}
                </p>
            @endif
        </div>
    </form>
</section>