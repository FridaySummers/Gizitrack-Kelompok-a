@extends('layouts.sidebar')

@section('title', 'Riwayat Pengiriman Harian')

@section('content')

{{-- Date Picker --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Pelacakan Pengiriman</h2>
        <p class="text-sm text-gray-500 mt-1">Pantau progres pengiriman makanan harian ke sekolah tujuan</p>
    </div>

    <div class="flex items-center gap-2">
        {{-- Tombol Kemarin --}}
        <a href="{{ route('vendor.distribusi.riwayat', ['tanggal' => \Carbon\Carbon::parse($tanggal)->subDay()->toDateString()]) }}"
           class="p-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition text-gray-500 hover:text-gray-700"
           title="Hari sebelumnya">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        {{-- Date Input --}}
        <form id="dateForm" method="GET" action="{{ route('vendor.distribusi.riwayat') }}">
            <input type="date" name="tanggal" value="{{ $tanggal }}"
                   onchange="document.getElementById('dateForm').submit()"
                   class="rounded-lg border-gray-200 text-sm text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 px-3 py-2">
        </form>

        {{-- Tombol Hari Ini --}}
        <a href="{{ route('vendor.distribusi.riwayat', ['tanggal' => now()->toDateString()]) }}"
           class="px-3 py-2 rounded-lg text-sm font-medium transition
                  {{ $tanggal === now()->toDateString() ? 'bg-emerald-500 text-white' : 'border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Hari Ini
        </a>

        {{-- Tombol Besok --}}
        <a href="{{ route('vendor.distribusi.riwayat', ['tanggal' => \Carbon\Carbon::parse($tanggal)->addDay()->toDateString()]) }}"
           class="p-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition text-gray-500 hover:text-gray-700"
           title="Hari berikutnya">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>

{{-- Tanggal Label --}}
<div class="mb-6">
    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700">
        📅 {{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
    </span>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    {{-- Total Pengiriman --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Kirim</p>
                <p class="text-xl font-bold text-gray-800">{{ $summary['total_pengiriman'] }}</p>
            </div>
        </div>
    </div>

    {{-- Total Porsi --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Porsi</p>
                <p class="text-xl font-bold text-gray-800">{{ number_format($summary['total_porsi']) }}</p>
            </div>
        </div>
    </div>

    {{-- Diterima --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Diterima</p>
                <p class="text-xl font-bold text-emerald-600">{{ $summary['diterima'] }}</p>
            </div>
        </div>
    </div>

    {{-- Di Perjalanan --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-sky-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Di Perjalanan</p>
                <p class="text-xl font-bold text-sky-600">{{ $summary['di_perjalanan'] }}</p>
            </div>
        </div>
    </div>

    {{-- Kendala --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500">Kendala</p>
                <p class="text-xl font-bold text-red-600">{{ $summary['kendala'] }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Pelacakan --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sekolah Tujuan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Porsi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Update</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
            @forelse($distribusis as $index => $d)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>

                <td class="px-6 py-4">
                    <span class="text-sm font-medium text-gray-800">{{ $d->sekolah_tujuan }}</span>
                </td>

                <td class="px-6 py-4">
                    <span class="text-sm text-gray-700 font-medium">{{ number_format($d->jumlah_porsi) }}</span>
                    <span class="text-xs text-gray-400 ml-1">porsi</span>

                    @if($d->requestChanges->count() > 0)
                        @php $lastChange = $d->requestChanges->last(); @endphp
                        <div class="mt-1 flex items-center gap-1">
                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs px-2 py-0.5 rounded-full" title="Alasan: {{ $lastChange->alasan }}">
                                📝 <s>{{ $lastChange->jumlah_porsi_awal }}</s> → {{ $lastChange->jumlah_porsi_baru }}
                            </span>
                        </div>
                    @endif
                </td>

                <td class="px-6 py-4">
                    @if($d->status === 'Pending')
                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Pending
                        </span>

                    @elseif(in_array($d->status, ['Dikirim', 'Di Perjalanan']))
                        <span class="inline-flex items-center gap-1 bg-sky-50 text-sky-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                            {{ $d->status }}
                        </span>

                    @elseif($d->status === 'Diterima')
                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Diterima
                        </span>

                    @elseif($d->status === 'Diterima Sebagian')
                        <span class="inline-flex items-center gap-1 bg-orange-50 text-orange-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                            Diterima Sebagian
                        </span>

                    @elseif($d->status === 'Kendala')
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                            Kendala
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 text-sm text-gray-500">
                    @if($d->last_updated)
                        {{ \Carbon\Carbon::parse($d->last_updated)->format('H:i') }}
                    @else
                        {{ $d->updated_at->format('H:i') }}
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-sm text-gray-500 font-medium">Tidak ada pengiriman pada tanggal ini</p>
                        <p class="text-xs text-gray-400 mt-1">Pilih tanggal lain atau cek kembali nanti</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Progress Bar --}}
@if($summary['total_pengiriman'] > 0)
<div class="mt-6 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
    <h3 class="text-sm font-medium text-gray-700 mb-3">Progres Pengiriman Hari Ini</h3>
    <div class="flex rounded-full overflow-hidden h-3 bg-gray-100">
        @if($summary['diterima'] > 0)
        <div class="bg-emerald-500 transition-all duration-500" style="width: {{ ($summary['diterima'] / $summary['total_pengiriman']) * 100 }}%"
             title="Diterima: {{ $summary['diterima'] }}"></div>
        @endif
        @if($summary['di_perjalanan'] > 0)
        <div class="bg-sky-500 transition-all duration-500" style="width: {{ ($summary['di_perjalanan'] / $summary['total_pengiriman']) * 100 }}%"
             title="Di Perjalanan: {{ $summary['di_perjalanan'] }}"></div>
        @endif
        @if($summary['pending'] > 0)
        <div class="bg-amber-400 transition-all duration-500" style="width: {{ ($summary['pending'] / $summary['total_pengiriman']) * 100 }}%"
             title="Pending: {{ $summary['pending'] }}"></div>
        @endif
        @if($summary['kendala'] > 0)
        <div class="bg-red-500 transition-all duration-500" style="width: {{ ($summary['kendala'] / $summary['total_pengiriman']) * 100 }}%"
             title="Kendala: {{ $summary['kendala'] }}"></div>
        @endif
    </div>
    <div class="flex gap-4 mt-2 text-xs text-gray-500">
        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span> Diterima</span>
        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-sky-500"></span> Di Perjalanan</span>
        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-400"></span> Pending</span>
        <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-500"></span> Kendala</span>
    </div>
</div>
@endif

@endsection
