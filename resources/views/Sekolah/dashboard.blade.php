@extends('layouts.sidebar')

@section('title', 'Dashboard Sekolah')

@section('content')
<div class="mb-8 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Halo, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-gray-500 mt-1">Selamat datang kembali di panel monitoring gizi sekolah.</p>
        </div>
        <div class="flex items-center gap-2 text-sm font-medium text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full">
            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            Sistem Aktif
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded">Monitoring</span>
        </div>
        <p class="text-sm text-gray-500 font-medium">Pengiriman Aktif</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $pengirimanAktif }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Selesai</span>
        </div>
        <p class="text-sm text-gray-500 font-medium">Total Diterima</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalDiterima }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 hover:shadow-md transition">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <span class="text-xs font-medium text-orange-600 bg-orange-50 px-2 py-1 rounded">Catatan</span>
        </div>
        <p class="text-sm text-gray-500 font-medium">Total Komplain</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKomplain }}</p>
    </div>
</div>

<!-- Recent Distributions Table -->
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-800">Distribusi Terbaru</h3>
        <a href="{{ route('sekolah.distributions.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Vendor</th>
                    <th class="px-6 py-3">Menu</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($distribusiTerbaru as $d)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                        {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $d->vendor->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        {{ $d->menu->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @if($d->status === 'Dikirim')
                            <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">Dikirim</span>
                        @elseif($d->status === 'Diterima')
                            <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full border border-green-100">Diterima</span>
                        @elseif($d->status === 'Diterima Sebagian')
                            <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full border border-blue-100">Diterima Sebagian</span>
                        @else
                            <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">Kendala</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                        Belum ada data distribusi terbaru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
