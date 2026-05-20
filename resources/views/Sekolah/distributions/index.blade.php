@extends('layouts.sidebar')

@section('title', 'Monitor Status Dikirim')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Monitor Status "Dikirim"</h2>
        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">Sekolah Dashboard</span>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3">Nama Vendor</th>
                    <th scope="col" class="px-6 py-3">Menu</th>
                    <th scope="col" class="px-6 py-3">Porsi</th>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($distributions as $d)
                <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                        {{ $d->vendor->name ?? 'Vendor Tidak Diketahui' }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $d->menu->name ?? 'Menu Tidak Tersedia' }}
                    </td>
                    <td class="px-6 py-4 font-semibold">
                        {{ $d->jumlah_porsi }} Porsi
                    </td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($d->tanggal_pengiriman)->format('d F Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($d->status === 'Dikirim')
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-yellow-300">
                            {{ $d->status }}
                        </span>
                        @else
                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-gray-300">
                            {{ $d->status }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($d->status === 'Dikirim')
                        <form action="{{ route('sekolah.distributions.update', $d) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="terima">
                            <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center transition-all">
                                Terima Sesuai
                            </button>
                        </form>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr class="bg-white">
                    <td colspan="5" class="px-6 py-10 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-lg">Belum ada distribusi dengan status "Dikirim"</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $distributions->links() }}
    </div>
</div>
@endsection
