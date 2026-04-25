@extends('layouts.sidebar')

@section('title', 'Tulis Feedback')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Tulis Feedback</h2>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('sekolah.feedbacks.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Distribusi</label>
            <select name="distribution_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent" required>
                <option value="">Pilih distribusi...</option>
                @foreach($distributions as $d)
                <option value="{{ $d->id }}">{{ $d->sekolah_tujuan }} - {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
            <textarea name="catatan" rows="4" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent" placeholder="Tulis feedback..." required></textarea>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Simpan</button>
            <a href="{{ route('sekolah.feedbacks.index') }}" class="text-gray-600 hover:text-gray-800 text-sm px-4 py-2">Batal</a>
        </div>
    </form>
</div>
@endsection
