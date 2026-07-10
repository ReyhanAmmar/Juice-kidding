<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketLangganan;
use App\Models\MenuJus;

class PaketLanggananController extends Controller
{
    public function index()
    {
        $pakets = PaketLangganan::with('menus')->get();
        return view('admin.paket-langganan.index', compact('pakets'));
    }

    public function create()
    {
        // Ambil semua menu jus yang bisa dikaitkan ke paket (Allowed Variants)
        $menus = MenuJus::all();
        return view('admin.paket-langganan.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
            'total_pengiriman' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gratis_ongkir' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'allowed_menus' => 'nullable|array',
            'allowed_menus.*' => 'exists:menu_jus,id_menu',
        ]);

        $paket = PaketLangganan::create([
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
            'total_pengiriman' => $request->total_pengiriman,
            'deskripsi' => $request->deskripsi,
            'gratis_ongkir' => $request->has('gratis_ongkir') ? true : false,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        if ($request->allowed_menus) {
            $paket->menus()->sync($request->allowed_menus);
        }

        return redirect()->route('admin.paket-langganan.index')->with('success', 'Paket langganan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $paket = PaketLangganan::with('menus')->findOrFail($id);
        $menus = MenuJus::all();
        $selectedMenus = $paket->menus->pluck('id_menu')->toArray();

        return view('admin.paket-langganan.edit', compact('paket', 'menus', 'selectedMenus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:50',
            'harga' => 'required|integer|min:0',
            'total_pengiriman' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gratis_ongkir' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'allowed_menus' => 'nullable|array',
            'allowed_menus.*' => 'exists:menu_jus,id_menu',
        ]);

        $paket = PaketLangganan::findOrFail($id);
        $paket->update([
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
            'total_pengiriman' => $request->total_pengiriman,
            'deskripsi' => $request->deskripsi,
            'gratis_ongkir' => $request->has('gratis_ongkir') ? true : false,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        if ($request->allowed_menus) {
            $paket->menus()->sync($request->allowed_menus);
        } else {
            $paket->menus()->detach();
        }

        return redirect()->route('admin.paket-langganan.index')->with('success', 'Paket langganan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $paket = PaketLangganan::findOrFail($id);
        $paket->menus()->detach();
        $paket->delete();

        return redirect()->route('admin.paket-langganan.index')->with('success', 'Paket langganan berhasil dihapus!');
    }
}
