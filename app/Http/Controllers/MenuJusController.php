<?php

namespace App\Http\Controllers;

use App\Models\MenuJus;
use App\Models\KategoriMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuJusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = MenuJus::with('kategori')->orderBy('id_menu', 'desc')->paginate(10);
        return view('admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriMenu::where('is_active', 1)->get();
        return view('admin.menu.form', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jus' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori_menu,id_kategori',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'estimasi_kalori' => 'nullable|integer',
            'id_status_stok' => 'required|integer|in:1,2',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        MenuJus::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu Jus berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = MenuJus::findOrFail($id);
        $kategoris = KategoriMenu::where('is_active', 1)->get();
        return view('admin.menu.form', compact('menu', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_jus' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori_menu,id_kategori',
            'harga' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'estimasi_kalori' => 'nullable|integer',
            'id_status_stok' => 'required|integer|in:1,2',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $menu = MenuJus::findOrFail($id);
        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
                Storage::disk('public')->delete($menu->foto);
            }
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu Jus berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = MenuJus::findOrFail($id);
        
        if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
            Storage::disk('public')->delete($menu->foto);
        }
        
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu Jus berhasil dihapus!');
    }
}
