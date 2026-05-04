@extends('layouts.app')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <h1 class="page-title">Edit Profil</h1>

    <div class="card">
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.875rem;">Perbarui informasi profil untuk <strong>{{ $profile->name }}</strong>.</p>

        <form action="{{ route('profiles.update', $profile) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $profile->name) }}" required>
                @error('name') <small style="color: var(--danger);">{{ $message }}</small> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label for="email">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $profile->email) }}" required>
                    @error('email') <small style="color: var(--danger);">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $profile->phone) }}">
                </div>
            </div>

            <div>
                <label for="avatar_url">URL Foto Profil (Opsional)</label>
                <input type="url" name="avatar_url" id="avatar_url" value="{{ old('avatar_url', $profile->avatar_url) }}">
            </div>

            <div>
                <label for="bio">Biografi Singkat</label>
                <textarea name="bio" id="bio" rows="4">{{ old('bio', $profile->bio) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 1rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">Perbarui Profil</button>
                <a href="{{ route('profiles.index') }}" class="btn btn-outline" style="flex: 1; justify-content: center;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
