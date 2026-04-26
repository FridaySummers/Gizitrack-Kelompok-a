@extends('layouts.sidebar')

@section('title', 'Edit Menu')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Edit Menu: {{ $menu->name }}</h2>
</div>

<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 max-w-xl">
    <form method="POST" action="{{ route('vendor.menu.update', $menu->id) }}">
        @csrf
        @method('PUT') <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Menu</label>
            <input type="text" name="name" value="{{ old('name', $menu->name) }}" 
                   class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent 
                   @error('name') border-red-500 @else border-gray-200 @enderror">
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="3" 
                      class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                      @error('description') border-red-500 @else border-gray-200 @enderror">{{ old('description', $menu->description) }}</textarea>
            @error('description')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kalori</label>
                <input type="number" name="calories" value="{{ old('calories', $menu->calories) }}" 
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                       @error('calories') border-red-500 @else border-gray-200 @enderror">
                @error('calories')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                <input type="number" name="price" value="{{ old('price', $menu->price) }}" 
                       class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-400 focus:border-transparent
                       @error('price') border-red-500 @else border-gray-200 @enderror">
                @error('price')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition">Update Menu</button>
            <a href="{{ route('vendor.menu.index') }}" class="text-gray-600 hover:text-gray-800 text-sm px-4 py-2 mt-1">Batal</a>
        </div>
    </form>
</div>
@endsection