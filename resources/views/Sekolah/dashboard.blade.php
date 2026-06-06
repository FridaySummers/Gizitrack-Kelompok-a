@extends('layouts.sidebar')

@section('title', 'Dashboard')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Selamat Datang, Sekolah!</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('sekolah.distributions.index') }}" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:border-emerald-200 transition">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div>
                <h3 class="font-medium text-gray-800">Status Pengiriman</h3>
                <p class="text-sm text-gray-500">Lihat dan konfirmasi penerimaan makanan</p>
            </div>
        </div>
    </a>
    
    <a href="#" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:border-emerald-200 transition">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
            </div>
            <div>
                <h3 class="font-medium text-gray-800">Feedback Saya</h3>
                <p class="text-sm text-gray-500">Kirim feedback untuk pengiriman</p>
            </div>
        </div>
    </a>
</div>
@endsection