@extends('layouts.sidebar')

@section('title', 'Feedback Saya')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Feedback Saya</h2>
    <a href="{{ route('sekolah.feedbacks.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        + Tambah Feedback
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Distribusi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($feedbacks as $f)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $f->distribution ? $f->distribution->sekolah_tujuan : '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $f->catatan }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($f->created_at)->format('d M Y') }}</td>
                <td class="px-6 py-4">
                    @if($f->user_id === auth()->id())
                    <form method="POST" action="{{ route('sekolah.feedbacks.destroy', $f) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Hapus feedback?')">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada feedback</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $feedbacks->links() }}
@endsection
