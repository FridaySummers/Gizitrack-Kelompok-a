<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->get(); 
        return view('vendor.menu.index', compact('menus')); 
    }

    public function create()
    {
        return view('vendor.menu.create'); 
    }

    public function store(Request $request)
    {
        // Validasi data: Tambahkan min:0 agar harga & kalori tidak negatif
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'calories' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        Menu::create($validData);

        return redirect()->route('vendor.menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);
        return view('vendor.menu.edit', compact('menu'));
    }

    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);
        
        // PBI-13 Fix: Tambahkan validasi sebelum update
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'calories' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $menu->update($validData);

        return redirect()->route('vendor.menu.index')->with('success', 'Data menu berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('vendor.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}