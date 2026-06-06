@extends('layouts.sidebar')

@section('title', 'Tambah Akun')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Akun Vendor / Sekolah</h2>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                   @error('name') border-red-500 @else border-gray-200 @enderror">
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                   @error('email') border-red-500 @else border-gray-200 @enderror">
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
            <select name="role"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                    @error('role') border-red-500 @else border-gray-200 @enderror">
                <option value="">-- Pilih Role --</option>
                <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                <option value="vendor"  {{ old('role') === 'vendor'  ? 'selected' : '' }}>Vendor</option>
                <option value="sekolah" {{ old('role') === 'sekolah' ? 'selected' : '' }}>Sekolah</option>
            </select>
            @error('role')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                   @error('password') border-red-500 @else border-gray-200 @enderror">
            @error('password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Simpan
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="text-gray-600 hover:text-gray-800 text-sm px-4 py-2 mt-1">Batal</a>
        </div>
    </form>
</div>
@endsection
