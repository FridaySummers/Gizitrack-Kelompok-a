@extends('layouts.sidebar')

@section('title', 'Kelola Akun')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Kelola Akun Vendor & Sekolah</h2>
    <a href="{{ route('admin.users.create') }}"
       class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        + Tambah Akun
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full divide-y divide-gray-100">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $user)
            <tr>
                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $user->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    @if($user->role === 'admin')
                        <span class="bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">Admin</span>
                    @elseif($user->role === 'vendor')
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-medium px-2.5 py-1 rounded-full">Vendor</span>
                    @else
                        <span class="bg-purple-50 text-purple-700 text-xs font-medium px-2.5 py-1 rounded-full">Sekolah</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}"
                              onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->name }}?');"
                              class="inline-block">
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
                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada akun vendor atau sekolah</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
