@extends('layouts.sidebar')

@section('title', 'Tambah Distribusi')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">
        Tambah Distribusi
    </h2>

    <div class="bg-white rounded-xl border border-gray-200 shadow p-6 max-w-xl">
        
        <form method="POST" action="{{ route('vendor.distribusi.store') }}">
            @csrf

            {{-- Sekolah --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Sekolah Tujuan
                </label>
                <input 
                    type="text" 
                    name="sekolah_tujuan" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    required
                >
            </div>

            {{-- Jumlah --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Jumlah Porsi
                </label>
                <input 
                    type="number" 
                    name="jumlah_porsi" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    required
                >
            </div>

            {{-- Tanggal --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Pengiriman
                </label>
                <input 
                    type="date" 
                    name="tanggal_pengiriman" 
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    required
                >
            </div>

            {{-- BUTTON --}}
            <div class="flex items-center gap-3 mt-6">
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg"
                >
                    Simpan
                </button>

                <a 
                    href="{{ route('vendor.distribusi.index') }}" 
                    class="text-gray-600 hover:text-gray-800"
                >
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection