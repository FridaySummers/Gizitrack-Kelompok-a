@extends('layouts.sidebar')

@section('title', 'Edit Distribusi')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-lg font-semibold mb-4">Edit Distribusi</h2>

    <!-- 🔥 TAMBAHAN KODE BUAT NAMPILIN PESAN ERROR VALIDASI 🔥 -->
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 text-sm rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- ==================================================== -->

    <form action="{{ route('vendor.distribusi.update', $distribusi->id) }}" method="POST"
          x-data="{ porsiAwal: {{ $distribusi->jumlah_porsi }}, porsiBaru: {{ $distribusi->jumlah_porsi }} }">
        @csrf
        @method('PUT')

        <!-- Tanggal -->
        <div class="mb-4">
            <label class="block text-sm mb-1">Tanggal Pengiriman</label>
            <input type="date" name="tanggal_pengiriman"
                value="{{ $distribusi->tanggal_pengiriman }}"
                class="w-full border rounded px-3 py-2">
        </div>

        <!-- Sekolah -->
        <div class="mb-4">
            <label class="block text-sm mb-1">Sekolah Tujuan</label>
            <input type="text" name="sekolah_tujuan"
                value="{{ $distribusi->sekolah_tujuan }}"
                class="w-full border rounded px-3 py-2">
        </div>

        <!-- Porsi -->
        <div class="mb-4">
            <label class="block text-sm mb-1">Jumlah Porsi</label>
            <input type="number" name="jumlah_porsi"
                value="{{ $distribusi->jumlah_porsi }}"
                x-model="porsiBaru"
                class="w-full border rounded px-3 py-2">

            <!-- Indikator perubahan porsi -->
            <div x-show="porsiAwal != porsiBaru" x-cloak
                 class="mt-2 flex items-center gap-2 text-sm">
                <span class="text-gray-500">Porsi awal:</span>
                <span class="font-medium text-gray-700" x-text="porsiAwal"></span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
                <span class="font-medium text-emerald-600" x-text="porsiBaru"></span>
            </div>
        </div>

        <!-- Alasan Perubahan (muncul saat porsi berubah) -->
        <div x-show="porsiAwal != porsiBaru" x-cloak class="mb-4">
            <label class="block text-sm mb-1 text-amber-700 font-medium">
                ⚠️ Alasan Perubahan Porsi
            </label>
            <textarea name="alasan_perubahan" rows="3"
                placeholder="Contoh: Selisih persiapan, bahan baku kurang 20 porsi"
                class="w-full border border-amber-300 rounded px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500 bg-amber-50">{{ old('alasan_perubahan') }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Perubahan porsi akan tercatat sebagai histori</p>
        </div>

        <!-- Status -->
        <div class="mb-4">
            <label class="block text-sm mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2">
                <option {{ $distribusi->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option {{ $distribusi->status == 'Di Perjalanan' ? 'selected' : '' }}>Di Perjalanan</option>

                <option {{ $distribusi->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                <option {{ $distribusi->status == 'Diterima Sebagian' ? 'selected' : '' }}>Diterima Sebagian</option>
                <option {{ $distribusi->status == 'Kendala' ? 'selected' : '' }}>Kendala</option>
            </select>
        </div>

        <!-- Button -->
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>

            <a href="{{ route('vendor.distribusi.index') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
