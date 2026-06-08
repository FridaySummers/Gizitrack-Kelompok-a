@extends('layouts.sidebar')

@section('title', 'All Distributions')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4 flex-wrap">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Status Semua Distribusi</h2>
        <p class="text-gray-500 mt-1">Daftar lengkap riwayat distribusi gizi sekolah.</p>
    </div>
    <a href="{{ route('admin.reports.export') }}" style="background-color: #1e293b;" class="text-white font-semibold py-2 px-5 rounded-lg text-sm inline-flex items-center justify-center shadow-md transition-all transform hover:scale-105 h-[42px]">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
        </svg>
        Export PDF
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
            <tr>
                <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                <th scope="col" class="px-6 py-4 font-semibold">Sekolah</th>
                <th scope="col" class="px-6 py-4 font-semibold">Porsi</th>
                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                <th scope="col" class="px-6 py-4 font-semibold">Feedback</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($distributions as $d)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">{{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}</td>
                <td class="px-6 py-4 text-gray-900 font-medium">{{ $d->sekolah_tujuan }}</td>
                <td class="px-6 py-4 text-gray-700 font-semibold">{{ $d->jumlah_porsi }}</td>
                <td class="px-6 py-4">
                    @if($d->status === 'Pending')
                    <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">Pending</span>
                    @elseif($d->status === 'Dikirim')
                    <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full border border-amber-100">Dikirim</span>
                    @elseif($d->status === 'Diterima')
                    <span class="bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full border border-green-100">Diterima</span>
                    @elseif($d->status === 'Diterima Sebagian')
                    <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full border border-blue-100">Diterima Sebagian</span>
                    @else
                    <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full border border-red-100">Kendala</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @forelse($d->feedbacks as $f)
                    <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-100 mb-1 last:mb-0">{{ $f->catatan }}</p>
                    @empty
                    <span class="text-gray-400 text-xs">-</span>
                    @endforelse
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-lg font-medium text-gray-500">Belum ada data distribusi</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $distributions->links() }}
@endsection
