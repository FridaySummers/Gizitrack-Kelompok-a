@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h1 class="page-title" style="margin-bottom: 0;">Kelola Profil Pengguna</h1>
    <a href="{{ route('profiles.create') }}" class="btn btn-success">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5v14"/></svg>
        Tambah Profil Baru
    </a>
</div>

<div class="card" style="padding: 0;">
    @if($profiles->isEmpty())
        <div style="text-align: center; padding: 4rem 0;">
            <p style="color: var(--text-muted);">Belum ada data profil. Silakan tambah baru.</p>
        </div>
    @else
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid var(--border); background: #f8fafc;">
                    <th style="text-align: left; padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase;">User</th>
                    <th style="text-align: left; padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase;">Email</th>
                    <th style="text-align: left; padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase;">Telepon</th>
                    <th style="text-align: right; padding: 1rem 1.5rem; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profiles as $profile)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 1rem 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: #eff6ff; color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">
                                    {{ substr($profile->name, 0, 1) }}
                                </div>
                                <span style="font-weight: 500;">{{ $profile->name }}</span>
                            </div>
                        </td>
                        <td style="padding: 1rem 1.5rem; color: var(--text-muted);">{{ $profile->email }}</td>
                        <td style="padding: 1rem 1.5rem; color: var(--text-muted);">{{ $profile->phone ?? '-' }}</td>
                        <td style="padding: 1rem 1.5rem; text-align: right;">
                            <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                <a href="{{ route('profiles.show', $profile) }}" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.75rem;">Detail</a>
                                <a href="{{ route('profiles.edit', $profile) }}" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; border-color: rgba(59, 130, 246, 0.2); color: var(--primary);">Edit</a>
                                <form action="{{ route('profiles.destroy', $profile) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; border-color: rgba(239, 68, 68, 0.2); color: var(--danger);" onclick="return confirm('Hapus profil ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
