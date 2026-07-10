<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\KategoriArtikel;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList = KategoriArtikel::all();
        
        $query = Artikel::with(['kategori', 'penulis'])
            ->where('id_status_artikel', 1);

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('id_kategori_artikel', $request->kategori);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $artikels = $query->latest('created_at')->paginate(9)->withQueryString();

        // Ambil artikel paling baru sebagai featured jika ada di halaman pertama tanpa filter
        $featured = null;
        if ($artikels->currentPage() == 1 && !$request->has('kategori') && !$request->has('search')) {
            $featured = $artikels->first();
            // Optional: Shift the first item off the collection so it doesn't repeat
            // Tapi untuk paginasi, lebih baik kita biarkan saja atau gunakan offset yang lebih kompleks.
            // Untuk kesederhanaan, kita bisa biarkan saja atau buang dari view.
        }

        return view('customer.artikel.index', compact('artikels', 'kategoriList', 'featured'));
    }

    public function show($slug)
    {
        $artikel = Artikel::with(['kategori', 'penulis'])
            ->where('slug', $slug)
            ->where('id_status_artikel', 1)
            ->firstOrFail();

        // Increment view count
        $artikel->increment('dilihat');

        $related = Artikel::with('kategori')
            ->where('id_kategori_artikel', $artikel->id_kategori_artikel)
            ->where('id_artikel', '!=', $artikel->id_artikel)
            ->where('id_status_artikel', 1)
            ->latest('created_at')
            ->take(3)
            ->get();

        return view('customer.artikel.detail', compact('artikel', 'related'));
    }
}
