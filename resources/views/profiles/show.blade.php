@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="page-title" style="margin-bottom: 0;">Detail Profil</h1>
        <a href="{{ route('profiles.index') }}" class="btn btn-outline">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Kembali
        </a>
    </div>

    <div class="card">
        <div style="display: flex; flex-wrap: wrap; gap: 2.5rem; align-items: flex-start;">
            <div style="flex: 0 0 150px; display: flex; flex-direction: column; align-items: center;">
                <div style="width: 120px; height: 120px; border-radius: 16px; background: #eff6ff; color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 3rem; border: 1px solid var(--border);">
                    {{ substr($profile->name, 0, 1) }}
                </div>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <div style="margin-bottom: 2rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.25rem;">{{ $profile->name }}</h2>
                    <p style="color: var(--text-muted);">{{ $profile->email }}</p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <h4 style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Nomor Telepon</h4>
                        <p style="font-weight: 500;">{{ $profile->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <h4 style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Tanggal Bergabung</h4>
                        <p style="font-weight: 500;">{{ $profile->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <h4 style="color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Biografi</h4>
                    <p style="line-height: 1.6; color: var(--text-main);">{{ $profile->bio ?? 'Tidak ada biografi.' }}</p>
                </div>

                <div style="display: flex; gap: 1rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                    <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-primary">Edit Profil</a>
                    <form action="{{ route('profiles.destroy', $profile) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline" style="border-color: rgba(239, 68, 68, 0.2); color: var(--danger);" onclick="return confirm('Hapus profil ini?')">Hapus Profil</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
