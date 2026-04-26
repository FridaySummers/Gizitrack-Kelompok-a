@extends('layouts.sidebar')

@section('title', 'Menu Saya')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Menu Saya</h2>
    <a href="{{ route('vendor.menu.create') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        + Tambah Menu
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deskripsi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kalori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($menus as $m)
            <tr>
                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $m->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $m->description ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $m->calories }} kcal</td>
                <td class="px-6 py-4 text-sm text-gray-600">Rp {{ number_format($m->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('vendor.menu.edit', $m->id) }}" 
                           class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            Edit
                        </a>

                        <form method="POST" action="{{ route('vendor.menu.destroy', $m->id) }}" onsubmit="return confirm('Yakin mau hapus menu ini?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada menu</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection