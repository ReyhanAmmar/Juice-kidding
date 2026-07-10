<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpsiKustomisasi;
use App\Models\TipeOpsi;

class RacikOpsiController extends Controller
{
    /**
     * Tipe opsi yang termasuk fitur Racik Sendiri
     */
    const TIPE_RACIK = [4, 5, 7, 8]; // Cairan Base, Bahan, Tambahan, Ukuran Cup

    /**
     * Display a listing of all Racik Sendiri options grouped by tipe.
     */
    public function index()
    {
        $tipeOpsi = TipeOpsi::with(['opsi' => function ($q) {
            $q->orderBy('urutan')->orderBy('id_opsi');
        }])
            ->whereIn('id_tipe_opsi', self::TIPE_RACIK)
            ->orderBy('urutan')
            ->get();

        return view('admin.kustomisasi.racik-opsi.index', compact('tipeOpsi'));
    }

    /**
     * Show the form for creating a new option.
     */
    public function create()
    {
        $tipeOpsi = TipeOpsi::whereIn('id_tipe_opsi', self::TIPE_RACIK)->orderBy('urutan')->get();
        return view('admin.kustomisasi.racik-opsi.create', compact('tipeOpsi'));
    }

    /**
     * Store a newly created option.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tipe_opsi' => 'required|in:4,5,7,8|exists:tipe_opsi,id_tipe_opsi',
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

        return redirect()->route('admin.racik-opsi.index')
            ->with('success', 'Opsi Racik Sendiri berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified option.
     */
    public function edit($id)
    {
        $opsi = OpsiKustomisasi::findOrFail($id);
        if (!in_array($opsi->id_tipe_opsi, self::TIPE_RACIK)) {
            return redirect()->route('admin.racik-opsi.index')->with('error', 'Opsi tidak valid.');
        }
        $tipeOpsi = TipeOpsi::whereIn('id_tipe_opsi', self::TIPE_RACIK)->orderBy('urutan')->get();
        return view('admin.kustomisasi.racik-opsi.edit', compact('opsi', 'tipeOpsi'));
    }

    /**
     * Update the specified option.
     */
    public function update(Request $request, $id)
    {
        $opsi = OpsiKustomisasi::findOrFail($id);
        if (!in_array($opsi->id_tipe_opsi, self::TIPE_RACIK)) {
            return redirect()->route('admin.racik-opsi.index')->with('error', 'Opsi tidak valid.');
        }

        $request->validate([
            'id_tipe_opsi' => 'required|in:4,5,7,8|exists:tipe_opsi,id_tipe_opsi',
            'nama_opsi' => 'required|string|max:100',
            'harga_tambahan' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:0',
        ]);

        $opsi->update([
            'id_tipe_opsi' => $request->id_tipe_opsi,
            'nama_opsi' => $request->nama_opsi,
            'harga_tambahan' => $request->harga_tambahan,
            'is_active' => $request->boolean('is_active', true),
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.racik-opsi.index')
            ->with('success', 'Opsi Racik Sendiri berhasil diperbarui!');
    }

    /**
     * Remove the specified option.
     */
    public function destroy($id)
    {
        $opsi = OpsiKustomisasi::findOrFail($id);
        if (!in_array($opsi->id_tipe_opsi, self::TIPE_RACIK)) {
            return redirect()->route('admin.racik-opsi.index')->with('error', 'Opsi tidak valid.');
        }
        $opsi->delete();

        return redirect()->route('admin.racik-opsi.index')
            ->with('success', 'Opsi Racik Sendiri berhasil dihapus!');
    }

    /**
     * Reorder via AJAX (naik/turun)
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:opsi_kustomisasi,id_opsi',
            'arah' => 'required|in:up,down',
        ]);

        $item = OpsiKustomisasi::findOrFail($request->id);

        if ($request->arah === 'up') {
            $tukar = OpsiKustomisasi::whereIn('id_tipe_opsi', self::TIPE_RACIK)
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
            $tukar = OpsiKustomisasi::whereIn('id_tipe_opsi', self::TIPE_RACIK)
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