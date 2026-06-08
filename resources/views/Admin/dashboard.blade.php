@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-8 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Halo {{ auth()->user()->role->label() }}! 🛡️</h2>
            <p class="text-gray-500 mt-1">Pantau seluruh ekosistem distribusi gizi sekolah secara real-time.</p>
        </div>
        <div class="flex items-center gap-2 text-sm font-medium text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full">
            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            Sistem Terpusat Aktif
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">Logistik</span>
        </div>
        <p class="text-sm text-gray-500 font-medium">Total Distribusi</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalDistribusi }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-1 4h1m2-8v2m0 2v2m0-2h2m-2 0H9"></path></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Partner</span>
        </div>
        <p class="text-sm text-gray-500 font-medium">Total Vendor</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalVendor }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354v4.512c0 .158-.05.31-.145.428l-3.428 4.285c-.285.356-.428.802-.428 1.27v.513c0 .802-.65 1.454-1.454 1.454H6.5c-.802 0-1.454-.65-1.454-1.454V14.86c0-.468.143-.914.428-1.27l3.428-4.285c.095-.118.145-.27.145-.428V4.354a1.5 1.5 0 011.5-1.5h2.854a1.5 1.5 0 011.5 1.5z"></path></svg>
            </div>
            <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded">Instansi</span>
        </div>
        <p class="text-sm text-gray-500 font-medium">Total Sekolah</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalSekolah }}</p>
    </div>
</div>

<!-- Recent Distributions -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-800">Distribusi Terbaru Seluruh Wilayah</h3>
        <a href="{{ route('admin.distributions.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Sekolah Tujuan</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Porsi</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($distribusiTerbaru as $d)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">{{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-gray-900 font-bold">{{ $d->sekolah_tujuan }}</td>
                    <td class="px-6 py-4 text-center text-gray-700 font-bold">{{ $d->jumlah_porsi }}</td>
                    <td class="px-6 py-4">
                        @if($d->status === 'Pending')
                        <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">Pending</span>
                        @elseif($d->status === 'Dikirim')
                        <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">Dikirim</span>
                        @elseif($d->status === 'Diterima')
                        <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full border border-green-100">Diterima</span>
                        @elseif($d->status === 'Komplain')
                        <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">Komplain</span>
                        @else
                        <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">Kendala</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-lg font-medium text-gray-500">Belum ada data distribusi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
