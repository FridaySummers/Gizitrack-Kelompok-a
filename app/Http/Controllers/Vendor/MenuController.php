<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Validation\Rule; // Wajib ditambahkan untuk memanggil aturan Unique

class MenuController extends Controller
{
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
                // Cek agar nama menu unik, tapi batasannya hanya untuk toko (vendor) ini saja
                Rule::unique('menus', 'name')->where(function ($query) {
                    return $query->where('vendor_id', auth()->id());
                }),
            ],
            'description' => 'required|string',
            'calories' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ], [
            // Pesan error kustom jika gagal validasi
            'name.unique' => 'Nama menu ini sudah pernah Anda buat. Silakan gunakan nama lain.'
        ]);

        // Otomatisasi pengisian vendor_id dari sesi login
        $validData['vendor_id'] = auth()->id();

        Menu::create($validData);

        return redirect()->route('vendor.menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        // PBI-32: Otorisasi ketat (findOrFail dipadukan dengan pencarian vendor_id)
        $menu = Menu::where('vendor_id', auth()->id())->findOrFail($id);
        return view('vendor.menu.edit', compact('menu'));
    }

    public function update(Request $request, string $id)
    {
        // PBI-32: Otorisasi ketat sebelum update
        $menu = Menu::where('vendor_id', auth()->id())->findOrFail($id);
        
        $validData = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                // Validasi unique saat update (harus mengabaikan ID menu yang sedang diedit ini)
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

    public function destroy(string $id)
    {
        // PBI-32: Otorisasi ketat sebelum delete
        $menu = Menu::where('vendor_id', auth()->id())->findOrFail($id);
        $menu->delete();

        return redirect()->route('vendor.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}