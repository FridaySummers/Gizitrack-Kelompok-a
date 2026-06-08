@extends('layouts.sidebar')

@section('title', 'Edit Akun')

@section('content')
<h2 class="text-xl font-semibold text-gray-800 mb-6">Edit Akun: {{ $user->name }}</h2>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('super_admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                   @error('name') border-red-500 @else border-gray-200 @enderror">
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
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
                @foreach($roles as $role)
                    <option value="{{ $role->value }}" {{ old('role', $user->role->value) === $role->value ? 'selected' : '' }}>
                        {{ $role->label() }}
                    </option>
                @endforeach
            </select>
            @error('role')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru <span class="text-gray-400 font-normal">(kosongkan jika tidak ingin diubah)</span></label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                   @error('password') border-red-500 @else border-gray-200 @enderror">
            @error('password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent">
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit"
                    class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Simpan
            </button>
            <a href="{{ route('super_admin.users.index') }}"
               class="text-gray-600 hover:text-gray-800 text-sm px-4 py-2 mt-1">Batal</a>
        </div>
    </form>
</div>
@endsection
