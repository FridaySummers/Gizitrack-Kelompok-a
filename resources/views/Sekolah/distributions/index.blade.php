@extends('layouts.sidebar')

@section('title', 'Distributions')

@section('content')
@if(session('success'))
<div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg p-4">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded-lg p-4">
    {{ session('error') }}
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
            @forelse($distributions as $d)
            <tr>
                <td class="px-6 py-4 text-sm text-gray-700">{{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d M Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $d->sekolah_tujuan }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">{{ $d->jumlah_porsi }}</td>
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
                <td class="px-6 py-4">
                    @if($d->status === 'Terkirim')
                    <button type="button" onclick="document.getElementById('confirm-form-{{ $d->id }}').style.display = 'block'; this.style.display = 'none';" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg mr-1">
                        Konfirmasi
                    </button>
                    <button type="button" onclick="document.getElementById('catatan-form-{{ $d->id }}').style.display = 'block'; this.style.display = 'none';" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg">
                        Catatan
                    </button>

                    <form id="confirm-form-{{ $d->id }}" action="{{ route('sekolah.distributions.update', $d) }}" method="POST" style="display: none; margin-top: 8px;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="terima">
                        <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg mr-2">Ya, Konfirmasi</button>
                        <button type="button" onclick="document.getElementById('confirm-form-{{ $d->id }}').style.display = 'none'; document.querySelector('button[onclick*='confirm-form-{{ $d->id }}']').style.display = 'inline-block'" class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-medium px-3 py-1.5 rounded-lg">Batal</button>
                    </form>

                    <form id="catatan-form-{{ $d->id }}" action="{{ route('sekolah.distributions.update', $d) }}" method="POST" style="display: none; margin-top: 8px;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="action" value="terima_catatan">
                        <textarea name="catatan" placeholder="Jelaskan catatan..." class="w-full border border-gray-200 rounded-lg p-2 text-sm mb-2" rows="2" required></textarea>
                        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg mr-2">Simpan</button>
                        <button type="button" onclick="document.getElementById('catatan-form-{{ $d->id }}').style.display = 'none'; document.querySelector('button[onclick*='catatan-form-{{ $d->id }}']').style.display = 'inline-block'" class="bg-gray-400 hover:bg-gray-500 text-white text-xs font-medium px-3 py-1.5 rounded-lg">Batal</button>
                    </form>
                    @else
                    <span class="text-gray-400 text-sm">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $distributions->links() }}
@endsection
