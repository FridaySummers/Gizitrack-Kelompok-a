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
        // 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 
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
        // PBI-13: Ambil data menu yang mau diedit
        $menu = Menu::findOrFail($id);
        
        // Arahkan ke halaman form edit
        return view('vendor.menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // PBI-13: Cari data menu lalu update semua isiannya
        $menu = Menu::findOrFail($id);
        $menu->update($request->all());

        return redirect()->route('menu.index')->with('success', 'Data menu berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // PBI-14: Cari data menu lalu hapus dari database
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}