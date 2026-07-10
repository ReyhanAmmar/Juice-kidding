<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\KategoriArtikel;

use App\Models\Artikel;

class AdminArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikels = Artikel::with(['kategori', 'penulis'])->latest()->paginate(10);
        return view('admin.artikel.index', compact('artikels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriArtikel::all();
        return view('admin.artikel.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'id_kategori_artikel' => 'required|exists:kategori_artikel,id_kategori_artikel',
            'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048',
            'ringkasan' => 'required',
            'konten' => 'required',
            'id_status_artikel' => 'required|in:1,2'
        ]);

        $data = $request->all();
        $data['id_penulis'] = Auth::id();
        $data['slug'] = Str::slug($request->judul);
        $data['dilihat'] = 0;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/artikel'), $filename);
            $data['thumbnail'] = $filename;
        } else {
            $data['thumbnail'] = 'default.png';
        }

        Artikel::create($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil ditambahkan!');
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
        $artikel = Artikel::findOrFail($id);
        $kategoris = KategoriArtikel::all();
        return view('admin.artikel.edit', compact('artikel', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul' => 'required|max:255',
            'id_kategori_artikel' => 'required|exists:kategori_artikel,id_kategori_artikel',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ringkasan' => 'required',
            'konten' => 'required',
            'id_status_artikel' => 'required|in:1,2'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/artikel'), $filename);
            
            // Delete old file if not default
            if ($artikel->thumbnail && $artikel->thumbnail != 'default.png' && file_exists(public_path('uploads/artikel/' . $artikel->thumbnail))) {
                unlink(public_path('uploads/artikel/' . $artikel->thumbnail));
            }
            
            $data['thumbnail'] = $filename;
        }

        $artikel->update($data);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $artikel = Artikel::findOrFail($id);
        
        if ($artikel->thumbnail && $artikel->thumbnail != 'default.png' && file_exists(public_path('uploads/artikel/' . $artikel->thumbnail))) {
            unlink(public_path('uploads/artikel/' . $artikel->thumbnail));
        }

        $artikel->delete();
        
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
