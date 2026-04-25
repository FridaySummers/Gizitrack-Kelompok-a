@extends('layouts.sidebar')

@section('title', 'Tambah Menu')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Menu</h2>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('vendor.menu.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Menu</label>
            <input type="text" name="name" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kalori</label>
                <input type="number" name="calories" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                <input type="number" name="price" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent" required>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Simpan</button>
            <a href="{{ route('vendor.menu.index') }}" class="text-gray-600 hover:text-gray-800 text-sm px-4 py-2">Batal</a>
        </div>
    </form>
</div>
@endsection
