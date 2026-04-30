@extends('layouts.sidebar')

@section('title', 'Distributions')

@section('content')
<div class="mb-4 flex justify-end">
    <a href="{{ route('vendor.distribusi.create') }}" 
       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg inline-flex items-center gap-2">
        + Input Pengiriman Baru
    </a>
</div>

@if(session('success'))
<div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sekolah</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Porsi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">
            @forelse($distribusis as $d)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-700">
                    {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}
                </td>

                <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $d->sekolah_tujuan }}
                </td>

                <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $d->jumlah_porsi }}
                </td>

                <td class="px-6 py-4">
                    @if($d->status === 'Pending')
                        <span class="bg-amber-50 text-amber-700 text-xs font-medium px-2.5 py-1 rounded-full">Pending</span>
                    @elseif(in_array($d->status, ['Di Perjalanan','Terkirim']))
                        <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">{{ $d->status }}</span>
                    @elseif($d->status === 'Diterima')
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-full">Diterima</span>
                    @elseif($d->status === 'Diterima Sebagian')
                        <span class="bg-orange-50 text-orange-700 text-xs font-medium px-2.5 py-1 rounded-full">Diterima Sebagian</span>
                    @else
                        <span class="bg-red-50 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">Kendala</span>
                    @endif
                </td>

                <!-- 🔥 AKSI -->
                <td class="px-6 py-4 text-sm flex gap-2">
                    
                    <!-- EDIT -->
                    <a href="{{ route('vendor.distribusi.edit', $d->id) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                        Edit
                    </a>

                    <!-- DELETE -->
                    <form action="{{ route('vendor.distribusi.destroy', $d->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin mau hapus?')" 
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                    Belum ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $distribusis->links() }}
</div>

@endsection