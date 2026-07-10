<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpsiKustomisasi;
use App\Models\TipeOpsi;

class OpsiKustomisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OpsiKustomisasi::with('tipe_opsi')
            ->whereNotIn('id_tipe_opsi', [4, 5, 7, 8]); // Exclude Racik Sendiri types

        // Filter berdasarkan tipe opsi
        if ($request->filled('tipe_opsi')) {
            $query->where('id_tipe_opsi', $request->tipe_opsi);
        }

        $opsiKustomisasi = $query->withoutGlobalScope('urutan')->orderBy('urutan')->orderBy('id_opsi')->paginate(15)->withQueryString();
        $tipeOpsiList = TipeOpsi::whereNotIn('id_tipe_opsi', [4, 5, 7, 8])->orderBy('nama_tipe')->get();

        return view('admin.kustomisasi.opsi-kustomisasi.index', compact('opsiKustomisasi', 'tipeOpsiList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipeOpsi = TipeOpsi::whereNotIn('id_tipe_opsi', [4, 5, 7, 8])->orderBy('nama_tipe')->get();
        return view('admin.kustomisasi.opsi-kustomisasi.create', compact('tipeOpsi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tipe_opsi' => 'required|exists:tipe_opsi,id_tipe_opsi',
            'nama_opsi' => 'required|string|max:100',
            'harga_tambahan' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:0',
        ]);

        OpsiKustomisasi::create([
            'id_tipe_opsi' => $request->id_tipe_opsi,
            'nama_opsi' => $request->nama_opsi,
            'harga_tambahan' => $request->harga_tambahan,
            'is_active' => $request->boolean('is_active', true),
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.opsi-kustomisasi.index')
            ->with('success', 'Opsi kustomisasi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(OpsiKustomisasi $opsiKustomisasi)
    {
        return redirect()->route('admin.opsi-kustomisasi.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpsiKustomisasi $opsiKustomisasi)
    {
        $tipeOpsi = TipeOpsi::whereNotIn('id_tipe_opsi', [4, 5, 7, 8])->orderBy('nama_tipe')->get();
        return view('admin.kustomisasi.opsi-kustomisasi.edit', compact('opsiKustomisasi', 'tipeOpsi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OpsiKustomisasi $opsiKustomisasi)
    {
        $request->validate([
            'id_tipe_opsi' => 'required|exists:tipe_opsi,id_tipe_opsi',
            'nama_opsi' => 'required|string|max:100',
            'harga_tambahan' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $opsiKustomisasi->update([
            'id_tipe_opsi' => $request->id_tipe_opsi,
            'nama_opsi' => $request->nama_opsi,
            'harga_tambahan' => $request->harga_tambahan,
            'is_active' => $request->boolean('is_active', true),
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.opsi-kustomisasi.index')
            ->with('success', 'Opsi kustomisasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpsiKustomisasi $opsiKustomisasi)
    {
        $opsiKustomisasi->delete();

        return redirect()->route('admin.opsi-kustomisasi.index')
            ->with('success', 'Opsi kustomisasi berhasil dihapus!');
    }

    /**
     * Reorder opsi kustomisasi via AJAX (naik/turun)
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:opsi_kustomisasi,id_opsi',
            'arah' => 'required|in:up,down',
        ]);

        $item = OpsiKustomisasi::findOrFail($request->id);

        if ($request->arah === 'up') {
            // Cari item di atasnya (urutan lebih kecil, atau urutan sama tapi ID lebih kecil)
            $tukar = OpsiKustomisasi::whereNotIn('id_tipe_opsi', [4, 5, 7, 8])
                ->where(function ($q) use ($item) {
                    $q->where('urutan', '<', $item->urutan)
                      ->orWhere(function ($q2) use ($item) {
                          $q2->where('urutan', $item->urutan)
                             ->where('id_opsi', '<', $item->id_opsi);
                      });
                })
                ->orderBy('urutan', 'desc')
                ->orderBy('id_opsi', 'desc')
                ->first();
        } else {
            // Cari item di bawahnya (urutan lebih besar, atau urutan sama tapi ID lebih besar)
            $tukar = OpsiKustomisasi::whereNotIn('id_tipe_opsi', [4, 5, 7, 8])
                ->where(function ($q) use ($item) {
                    $q->where('urutan', '>', $item->urutan)
                      ->orWhere(function ($q2) use ($item) {
                          $q2->where('urutan', $item->urutan)
                             ->where('id_opsi', '>', $item->id_opsi);
                      });
                })
                ->orderBy('urutan', 'asc')
                ->orderBy('id_opsi', 'asc')
                ->first();
        }

        if ($tukar) {
            $tempUrutan = $tukar->urutan;
            $tukar->update(['urutan' => $item->urutan]);
            $item->update(['urutan' => $tempUrutan]);
        }

        return response()->json(['success' => true]);
    }
}