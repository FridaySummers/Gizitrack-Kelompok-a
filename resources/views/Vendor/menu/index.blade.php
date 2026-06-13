@extends('layouts.sidebar')

@section('title', 'Menu Saya')

@section('content')
<div class="mb-8 p-8 bg-white rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between gap-4 flex-wrap transition-all duration-300 hover:shadow-md">
    <div>
        <h2 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Katalog Menu</h2>
        <p class="text-gray-500 mt-1 font-medium text-sm">Kelola daftar menu makanan sehat untuk distribusi sekolah.</p>
    </div>

    <a href="{{ route('vendor.menu.create') }}"
       class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-2.5 px-6 rounded-xl text-xs uppercase tracking-widest inline-flex items-center gap-2 shadow-lg shadow-emerald-200/50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Menu Baru
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-[10px] text-gray-400 uppercase bg-gray-50/80 font-black tracking-widest">
                <tr>
                    <th scope="col" class="px-8 py-4">Nama Menu</th>
                    <th scope="col" class="px-8 py-4">Deskripsi Nutrisi</th>
                    <th scope="col" class="px-8 py-4 text-center">Energi</th>
                    <th scope="col" class="px-8 py-4">Harga Satuan</th>
                    <th scope="col" class="px-8 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($menus as $m)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <span class="text-gray-800 font-black group-hover:text-emerald-600 transition-colors">{{ $m->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-gray-500 font-medium line-clamp-1 max-w-xs">{{ $m->description ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 text-[10px] font-black uppercase tracking-widest rounded-lg border border-blue-100">
                            {{ $m->calories }} kcal
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <p class="text-gray-800 font-black">Rp {{ number_format($m->price, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-8 py-5 text-center">
                        <div class="flex justify-center items-center gap-3">
                            <a href="{{ route('vendor.menu.edit', $m->id) }}"
                               dusk="edit-menu-{{ $m->id }}"
                               class="p-2.5 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-sm border border-blue-100 group-hover:scale-110"
                               title="Edit Menu">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>

                            <form method="POST" action="{{ route('vendor.menu.destroy', $m->id) }}" onsubmit="return confirm('Yakin ingin menghapus menu ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        dusk="delete-menu-{{ $m->id }}"
                                        class="p-2.5 text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm border border-rose-100 group-hover:scale-110"
                                        title="Hapus Menu">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <p class="text-lg font-bold text-gray-500 tracking-tight">Belum ada menu terdaftar.</p>
                            <a href="{{ route('vendor.menu.create') }}" class="mt-4 text-emerald-600 font-black text-xs uppercase tracking-widest hover:underline">Tambah Menu Pertama Anda →</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
