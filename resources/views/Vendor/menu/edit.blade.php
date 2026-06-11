@extends('layouts.sidebar')

@section('title', 'Edit Menu')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
        {{-- Header Form --}}
        <div class="p-8 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Edit Katalog Menu</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Identitas: {{ $menu->name }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('vendor.menu.update', $menu->id) }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Menu --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Label Menu Utama</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <input type="text" name="name" value="{{ old('name', $menu->name) }}"
                           class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-bold @error('name') border-rose-500 bg-rose-50/30 @enderror">
                </div>
                @error('name')
                    <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Detail Nutrisi & Komposisi</label>
                <textarea name="description" rows="4"
                          class="block w-full p-4 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-medium placeholder:text-gray-300 @error('description') border-rose-500 bg-rose-50/30 @enderror">{{ old('description', $menu->description) }}</textarea>
                @error('description')
                    <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kalori --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Kandungan Energi (kcal)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <input type="number" name="calories" value="{{ old('calories', $menu->calories) }}"
                               class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-black @error('calories') border-rose-500 bg-rose-50/30 @enderror">
                    </div>
                    @error('calories')
                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Harga Satuan (IDR)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-emerald-600 font-bold">
                            Rp
                        </div>
                        <input type="number" name="price" value="{{ old('price', $menu->price) }}"
                               class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none font-black @error('price') border-rose-500 bg-rose-50/30 @enderror">
                    </div>
                    @error('price')
                        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="pt-6 flex flex-col sm:flex-row gap-3">
                <button type="submit" dusk="update-menu" class="flex-1 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-widest rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                    Konfirmasi Update
                </button>

                <a href="{{ route('vendor.menu.index') }}"
                   class="px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-500 font-black text-xs uppercase tracking-widest rounded-2xl transition-all text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
