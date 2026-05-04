@extends('layouts.app')

@section('content')
    <div style="max-width: 700px; margin: 0 auto;">
        <h1 class="page-title">Tambah Profil Baru</h1>

        <div class="card">
            <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.875rem;">Masukkan detail informasi profil
                di bawah ini.</p>

            <form action="{{ route('profiles.store') }}" method="POST">
                @csrf

                <div>
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name" placeholder="Contoh: Adlan Mantep" value="{{ old('name') }}"
                        required>
                    @error('name') <small style="color: var(--danger);">{{ $message }}</small> @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" placeholder="email@example.com"
                            value="{{ old('email') }}" required>
                        @error('email') <small style="color: var(--danger);">{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" name="phone" id="phone" placeholder="0857..." value="{{ old('phone') }}">
                    </div>
                </div>

                <div>
                    <label for="avatar_url">URL Foto Profil (Opsional)</label>
                    <input type="url" name="avatar_url" id="avatar_url" placeholder="https://..."
                        value="{{ old('avatar_url') }}">
                </div>

                <div>
                    <label for="bio">Biografi Singkat</label>
                    <textarea name="bio" id="bio" rows="4"
                        placeholder="Ceritakan sedikit tentang Anda...">{{ old('bio') }}</textarea>
                </div>

                <div
                    style="display: flex; gap: 1rem; margin-top: 1rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                    <button type="submit" class="btn btn-success" style="flex: 1; justify-content: center;">Simpan
                        Profil</button>
                    <a href="{{ route('profiles.index') }}" class="btn btn-outline"
                        style="flex: 1; justify-content: center;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection