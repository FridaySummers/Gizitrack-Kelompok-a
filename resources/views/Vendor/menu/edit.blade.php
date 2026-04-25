<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Menu: {{ $menu->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('vendor.menu.update', $menu->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Menu</label>
                        <input type="text" name="name" value="{{ $menu->name }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" rows="3" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>{{ $menu->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Total Kalori (kcal)</label>
                        <input type="number" name="calories" value="{{ $menu->calories }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                        <input type="number" name="price" value="{{ $menu->price }}" class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none" required>
                    </div>

                    <div class="flex items-center">
                        <button type="submit" 
                                style="background-color: #eab308 !important; color: white !important; font-weight: bold; padding: 10px 25px; border-radius: 8px; border: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin-right: 15px;">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('vendor.menu.index') }}" style="color: #6b7280; text-decoration: none; font-weight: 600; font-size: 14px;">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>