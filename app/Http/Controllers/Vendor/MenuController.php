<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::latest()->get(); 
        return view('vendor.menu.index', compact('menus')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.menu.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data biar aman
        $validData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'calories' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        // Simpan data yang sudah divalidasi saja (token otomatis tersaring)
        Menu::create($validData);

        return redirect()->route('vendor.menu.index')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::findOrFail($id);
        return view('vendor.menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::findOrFail($id);
        
        // PBI-13: Update semua data kecuali _token dan _method dari form
        $menu->update($request->except(['_token', '_method']));

        // Redirectnya dikembalikan ke vendor.menu.index
        return redirect()->route('vendor.menu.index')->with('success', 'Data menu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('vendor.menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}