<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Tambahkan ini

class MenuController extends Controller
{
    use AuthorizesRequests; // Tambahkan ini agar fungsi authorize() bisa jalan

    public function index()
    {
        // PBI-31: Memastikan vendor HANYA melihat menu buatannya sendiri
        $menus = Menu::where('vendor_id', auth()->id())->latest()->get(); 
        return view('vendor.menu.index', compact('menus')); 
    }

    public function create()
    {
        return view('vendor.menu.create'); 
    }

    public function store(Request $request)
    {
        // PBI-30: Validasi Unique Nama Menu berdasarkan Vendor ID
        $validData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menus', 'name')->where(function ($query) {
                    return $query->where('vendor_id', auth()->id());
                }),
            ],
            'description' => 'required|string',
            'calories' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ], [
            'name.unique' => 'Nama menu ini sudah pernah Anda buat. Silakan gunakan nama lain.'
        ]);

        $validData['vendor_id'] = auth()->id();

        Menu::create($validData);

        return redirect()->route('vendor.menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    // Ubah parameter dari string $id menjadi Menu $menu agar Policy bisa bekerja otomatis
    public function edit(Menu $menu)
    {
        // PBI-32: Gembok Otorisasi Policy untuk Edit
        $this->authorize('update', $menu);
        
        return view('vendor.menu.edit', compact('menu'));
    }

    // Ubah parameter dari string $id menjadi Menu $menu
    public function update(Request $request, Menu $menu)
    {
        // PBI-32: Gembok Otorisasi Policy sebelum Update
        $this->authorize('update', $menu);
        
        $validData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('menus', 'name')->where(function ($query) {
                    return $query->where('vendor_id', auth()->id());
                })->ignore($menu->id),
            ],
            'description' => 'required|string',
            'calories' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ], [
            'name.unique' => 'Nama menu ini sudah pernah Anda buat. Silakan gunakan nama lain.'
        ]);

        $menu->update($validData);

        return redirect()->route('vendor.menu.index')->with('success', 'Data menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        // PBI-32: Gembok Otorisasi Policy sebelum Delete
        $this->authorize('delete', $menu);
        
        $menu->delete();

        return redirect()->route('vendor.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}