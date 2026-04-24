<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Katalog Menu Makanan
            </h2>
            <a href="{{ route('vendor.menu.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow">
                + Tambah Menu Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border p-3 text-left">Nama Menu</th>
                                <th class="border p-3 text-left">Deskripsi</th>
                                <th class="border p-3 text-left">Kalori</th>
                                <th class="border p-3 text-left">Harga</th>
                                <th class="border p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus as $m)
                            <tr>
                                <td class="border p-3 font-semibold">{{ $m->name }}</td>
                                <td class="border p-3 text-gray-600">{{ $m->description ?? '-' }}</td>
                                <td class="border p-3">{{ $m->calories }} kcal</td>
                                <td class="border p-3">Rp {{ number_format($m->price, 0, ',', '.') }}</td>
                                <td class="border p-3">
                                    <div style="display: flex; justify-content: center; gap: 8px; align-items: center;">
                                        <a href="{{ route('vendor.menu.edit', $m->id) }}" 
                                           style="background-color: #eab308; color: white; padding: 6px 16px; border-radius: 5px; font-weight: bold; text-decoration: none; display: block; text-align: center;">
                                            Edit
                                        </a>

                                        <form action="{{ route('vendor.menu.destroy', $m->id) }}" method="POST" style="margin: 0; display: block;" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background-color: #dc2626; color: white; padding: 6px 16px; border-radius: 5px; font-weight: bold; border: none; cursor: pointer;">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="border p-3 text-center italic text-gray-500">Belum ada menu.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>