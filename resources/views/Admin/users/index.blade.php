@extends('layouts.sidebar')

@section('title', 'Kelola Akun')

@section('content')
<div class="mb-8 p-8 bg-white rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between gap-4 flex-wrap">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola Akun Vendor & Sekolah</h2>
        <p class="text-gray-500 mt-1 font-medium">Manajemen akses dan profil entitas dalam ekosistem GiziTrack.</p>
    </div>

    <a href="{{ route('admin.users.create') }}"
       class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-2.5 px-6 rounded-xl text-sm inline-flex items-center gap-2 shadow-lg shadow-emerald-200/50 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Akun Baru
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50/80 font-bold">
                <tr>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Nama Pengguna</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Alamat Email</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Role Akses</th>
                    <th scope="col" class="px-8 py-4 whitespace-nowrap">Terdaftar Pada</th>
                    <th scope="col" class="px-8 py-4 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/50 transition-colors group">
                    <td class="px-8 py-5 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center font-bold text-gray-400 text-xs">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-gray-900 font-bold group-hover:text-emerald-600 transition-colors">
                                    {{ $user->name }}
                                </p>
                                @if($user->id === auth()->id())
                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Akun Anda</span>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td class="px-8 py-5 whitespace-nowrap font-medium">
                        {{ $user->email }}
                    </td>

                    <td class="px-8 py-5 whitespace-nowrap">
                        @if($user->role->value === 'admin')
                            <span class="inline-flex items-center bg-blue-50 text-blue-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-blue-100">Admin</span>
                        @elseif($user->role->value === 'vendor')
                            <span class="inline-flex items-center bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-emerald-100">Vendor</span>
                        @else
                            <span class="inline-flex items-center bg-purple-50 text-purple-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full border border-purple-100">Sekolah</span>
                        @endif
                    </td>

                    <td class="px-8 py-5 whitespace-nowrap font-medium text-gray-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>

                    <td class="px-8 py-5 text-center">
                        @if($user->id === auth()->id())
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Locked</span>
                        @else
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                   title="Edit Akun">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                            title="Hapus Akun">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-16 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354v4.512c0 .158-.05.31-.145.428l-3.428 4.285c-.285.356-.428.802-.428 1.27v.513c0 .802-.65 1.454-1.454 1.454H6.5c-.802 0-1.454-.65-1.454-1.454V14.86c0-.468.143-.914.428-1.27l3.428-4.285c.095-.118.145-.27.145-.428V4.354a1.5 1.5 0 011.5-1.5h2.854a1.5 1.5 0 011.5 1.5z"></path></svg>
                            </div>
                            <p class="text-lg font-bold text-gray-500 tracking-tight">Belum ada akun terdaftar.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="px-8 py-6 border-t border-gray-100 bg-gray-50/30">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
