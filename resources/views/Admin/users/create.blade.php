@extends('layouts.sidebar')

@section('title', 'Tambah Akun')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
        {{-- Header Form --}}
        <div class="p-8 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Registrasi Akun Baru</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Tambah entitas Vendor atau Sekolah ke sistem.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 text-gray-400">Nama Lengkap / Instansi</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold @error('name') border-rose-500 bg-rose-50/30 @enderror">
                    </div>
                    @error('name')
                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 text-gray-400">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold @error('email') border-rose-500 bg-rose-50/30 @enderror">
                    </div>
                    @error('email')
                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Role --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 text-gray-400">Role Akses</label>
                <select name="role" required
                        class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold @error('role') border-rose-500 bg-rose-50/30 @enderror">
                    <option value="">-- Pilih Role --</option>
                    <option value="vendor"  {{ old('role') === 'vendor'  ? 'selected' : '' }}>Vendor</option>
                    <option value="sekolah" {{ old('role') === 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                </select>
                @error('role')
                    <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Password --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 text-gray-400">Kata Sandi</label>
                    <input type="password" name="password" required
                           class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold @error('password') border-rose-500 bg-rose-50/30 @enderror">
                    @error('password')
                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 text-gray-400">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required
                           class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold">
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row gap-3">
                <button type="submit" class="flex-1 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    Daftarkan Akun
                </button>

                <a href="{{ route('admin.users.index') }}"
                   class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 font-black text-xs uppercase tracking-widest rounded-2xl transition-all text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
