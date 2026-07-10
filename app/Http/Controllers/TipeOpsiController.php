<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipeOpsi;
use App\Models\OpsiKustomisasi;

class TipeOpsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipeOpsi = TipeOpsi::withCount('opsi')
            ->whereNotIn('id_tipe_opsi', [4, 5, 7, 8]) // Exclude Racik Sendiri types
            ->withoutGlobalScope('urutan')
            ->orderBy('urutan')
            ->orderBy('id_tipe_opsi')
            ->paginate(10);
        return view('admin.kustomisasi.tipe-opsi.index', compact('tipeOpsi'));
    }

    /**
     * Reorder tipe opsi via AJAX (naik/turun)
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tipe_opsi,id_tipe_opsi',
            'arah' => 'required|in:up,down',
        ]);

        $item = TipeOpsi::findOrFail($request->id);

        if ($request->arah === 'up') {
            // Cari item di atasnya (urutan lebih kecil, atau urutan sama tapi ID lebih kecil)
            $tukar = TipeOpsi::where(function ($q) use ($item) {
                    $q->where('urutan', '<', $item->urutan)
                      ->orWhere(function ($q2) use ($item) {
                          $q2->where('urutan', $item->urutan)
                             ->where('id_tipe_opsi', '<', $item->id_tipe_opsi);
                      });
                })
                ->orderBy('urutan', 'desc')
                ->orderBy('id_tipe_opsi', 'desc')
                ->first();
        } else {
            // Cari item di bawahnya (urutan lebih besar, atau urutan sama tapi ID lebih besar)
            $tukar = TipeOpsi::where(function ($q) use ($item) {
                    $q->where('urutan', '>', $item->urutan)
                      ->orWhere(function ($q2) use ($item) {
                          $q2->where('urutan', $item->urutan)
                             ->where('id_tipe_opsi', '>', $item->id_tipe_opsi);
                      });
                })
                ->orderBy('urutan', 'asc')
                ->orderBy('id_tipe_opsi', 'asc')
                ->first();
        }

        if ($tukar) {
            $tempUrutan = $tukar->urutan;
            $tukar->update(['urutan' => $item->urutan]);
            $item->update(['urutan' => $tempUrutan]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kustomisasi.tipe-opsi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tipe' => 'required|string|max:50|unique:tipe_opsi,nama_tipe',
            'wajib_pilih' => 'nullable|boolean',
            'pilih_banyak' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:0',
        ]);

        TipeOpsi::create([
            'nama_tipe' => $request->nama_tipe,
            'wajib_pilih' => $request->boolean('wajib_pilih'),
            'pilih_banyak' => $request->boolean('pilih_banyak'),
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.tipe-opsi.index')
            ->with('success', 'Tipe opsi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TipeOpsi $tipeOpsi)
    {
        return redirect()->route('admin.tipe-opsi.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TipeOpsi $tipeOpsi)
    {
        return view('admin.kustomisasi.tipe-opsi.edit', compact('tipeOpsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipeOpsi $tipeOpsi)
    {
        $request->validate([
            'nama_tipe' => 'required|string|max:50|unique:tipe_opsi,nama_tipe,' . $tipeOpsi->id_tipe_opsi . ',id_tipe_opsi',
            'wajib_pilih' => 'nullable|boolean',
            'pilih_banyak' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $tipeOpsi->update([
            'nama_tipe' => $request->nama_tipe,
            'wajib_pilih' => $request->boolean('wajib_pilih'),
            'pilih_banyak' => $request->boolean('pilih_banyak'),
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.tipe-opsi.index')
            ->with('success', 'Tipe opsi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipeOpsi $tipeOpsi)
    {
        // Cek apakah tipe opsi masih memiliki opsi kustomisasi
        if ($tipeOpsi->opsi()->count() > 0) {
            return back()->with('error', 'Tipe opsi tidak bisa dihapus karena masih memiliki opsi kustomisasi!');
        }

        $tipeOpsi->delete();

        return redirect()->route('admin.tipe-opsi.index')
            ->with('success', 'Tipe opsi berhasil dihapus!');
    }
}