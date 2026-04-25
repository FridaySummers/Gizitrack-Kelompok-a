@extends('layouts.sidebar')

@section('title', 'Tambah Distribusi')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Distribusi</h2>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('vendor.distribusi.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Sekolah Tujuan</label>
            <input type="text" name="sekolah_tujuan" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Porsi</label>
            <input type="number" name="jumlah_porsi" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengiriman</label>
            <input type="date" name="tanggal_pengiriman" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent" required>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Simpan</button>
            <a href="{{ route('vendor.distribusi.index') }}" class="text-gray-600 hover:text-gray-800 text-sm px-4 py-2">Batal</a>
        </div>
    </form>
</div>
@endsection
