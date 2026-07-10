<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\MenuJus;
use App\Models\RiwayatStatusPesanan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class MitraController extends Controller
{
    public function dashboardDapur()
    {
        $today = \Carbon\Carbon::today();

        // Counts
        $jumlahBaru = Pesanan::where('id_status_pesanan', 1)->count();
        $jumlahDiproses = Pesanan::where('id_status_pesanan', 2)->count();
        $jumlahSiap = Pesanan::where('id_status_pesanan', 3)->count();
        $jumlahSelesaiHariIni = Pesanan::whereIn('id_status_pesanan', [3, 4, 5, 6])
            ->whereDate('created_at', $today)
            ->count();

        // Kanban columns — full order objects grouped by status
        $pesananBaru = Pesanan::with(['customer', 'detail_pesanan.menu', 'detail_pesanan.opsi.opsi'])
            ->where('id_status_pesanan', 1)->orderBy('created_at', 'asc')->get();

        $pesananDiproses = Pesanan::with(['customer', 'detail_pesanan.menu', 'detail_pesanan.opsi.opsi'])
            ->where('id_status_pesanan', 2)->orderBy('updated_at', 'asc')->get();

        $pesananSiap = Pesanan::with(['customer', 'detail_pesanan.menu', 'detail_pesanan.opsi.opsi'])
            ->where('id_status_pesanan', 3)->orderBy('updated_at', 'asc')->get();

        return view('mitra.dashboard', compact(
            'jumlahBaru', 'jumlahDiproses', 'jumlahSiap', 'jumlahSelesaiHariIni',
            'pesananBaru', 'pesananDiproses', 'pesananSiap'
        ));
    }

    public function dashboardDapurJson()
    {
        $today = \Carbon\Carbon::today();

        $jumlahBaru = Pesanan::where('id_status_pesanan', 1)->count();
        $jumlahDiproses = Pesanan::where('id_status_pesanan', 2)->count();
        $jumlahSiap = Pesanan::where('id_status_pesanan', 3)->count();
        $jumlahSelesaiHariIni = Pesanan::whereIn('id_status_pesanan', [3, 4, 5, 6])
            ->whereDate('created_at', $today)->count();

        $pesananBaru = Pesanan::with(['customer', 'detail_pesanan.menu', 'detail_pesanan.opsi.opsi'])
            ->where('id_status_pesanan', 1)->orderBy('created_at', 'asc')->get();
        $pesananDiproses = Pesanan::with(['customer', 'detail_pesanan.menu', 'detail_pesanan.opsi.opsi'])
            ->where('id_status_pesanan', 2)->orderBy('updated_at', 'asc')->get();
        $pesananSiap = Pesanan::with(['customer', 'detail_pesanan.menu', 'detail_pesanan.opsi.opsi'])
            ->where('id_status_pesanan', 3)->orderBy('updated_at', 'asc')->get();

        $columns = [
            'baru' => view('mitra.partials.dapur-column', ['orders' => $pesananBaru, 'status' => 1, 'label' => 'Pesanan Baru', 'icon' => 'bell-ring', 'color' => 'blue', 'count' => $jumlahBaru])->render(),
            'diproses' => view('mitra.partials.dapur-column', ['orders' => $pesananDiproses, 'status' => 2, 'label' => 'Sedang Diproses', 'icon' => 'chef-hat', 'color' => 'amber', 'count' => $jumlahDiproses])->render(),
            'siap' => view('mitra.partials.dapur-column', ['orders' => $pesananSiap, 'status' => 3, 'label' => 'Siap Diambil', 'icon' => 'package-check', 'color' => 'purple', 'count' => $jumlahSiap])->render(),
        ];

        return response()->json([
            'success' => true,
            'counts' => [
                'baru' => $jumlahBaru,
                'diproses' => $jumlahDiproses,
                'siap' => $jumlahSiap,
                'selesaiHariIni' => $jumlahSelesaiHariIni,
                'total' => $jumlahBaru + $jumlahDiproses + $jumlahSiap,
            ],
            'columns' => $columns,
        ]);
    }

    public function antrianDapur()
    {
        // Ambil pesanan berstatus 1 (Baru) atau 2 (Diproses)
        $pesanan = Pesanan::with(['detail_pesanan.menu', 'detail_pesanan.opsi.opsi', 'customer'])
            ->whereIn('id_status_pesanan', [1, 2])
            ->orderBy('id_status_pesanan', 'asc')
            ->orderBy('id_pesanan', 'asc')
            ->get();

        return view('mitra.antrian-dapur', compact('pesanan'));
    }

    public function antrianDapurJson()
    {
        $pesanan = Pesanan::with(['detail_pesanan.menu', 'detail_pesanan.opsi.opsi', 'customer'])
            ->whereIn('id_status_pesanan', [1, 2])
            ->orderBy('id_status_pesanan', 'asc')
            ->orderBy('id_pesanan', 'asc')
            ->get();

        $html = view('mitra.partials.dapur-cards', compact('pesanan'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $pesanan->count(),
        ]);
    }

    public function detailPesanan($id_pesanan)
    {
        $pesanan = Pesanan::with(['customer', 'detail_pesanan.menu', 'detail_pesanan.opsi.opsi', 'alamat'])
            ->findOrFail($id_pesanan);

        $html = view('mitra.partials.dapur-modal-detail', compact('pesanan'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    public function updateStatusPesanan(Request $request, $id_pesanan)
    {
        $request->validate([
            'status' => 'required|integer|in:2,3',
        ]);

        $pesanan = Pesanan::findOrFail($id_pesanan);
        $newStatus = $request->status;

        $pesanan->id_status_pesanan = $newStatus;
        $pesanan->save();

        // Catat riwayat status pesanan
        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_status_pesanan' => $newStatus,
            'diubah_oleh' => Auth::id(),
            'catatan' => $newStatus == 2 ? 'Pesanan mulai disiapkan di dapur.' : 'Pesanan selesai diracik oleh dapur.',
        ]);

        // Kirim notifikasi ke pelanggan
        $judulNotif = $newStatus == 2 ? 'Pesanan Sedang Diproses' : 'Pesanan Siap disajikan';
        $pesanNotif = $newStatus == 2 
            ? 'Jus pesanan #' . $pesanan->kode_pesanan . ' sedang disiapkan di dapur.'
            : 'Jus pesanan #' . $pesanan->kode_pesanan . ' telah selesai diracik ' . ($pesanan->id_tipe_pesanan == 1 ? 'dan siap diambil!' : 'dan siap diantar!');

        Notifikasi::create([
            'id_user' => $pesanan->id_customer,
            'judul' => $judulNotif,
            'pesan' => $pesanNotif,
            'tipe' => 'pesanan',
            'id_pesanan' => $pesanan->id_pesanan,
            'sudah_dibaca' => false,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui!',
                'id_status_pesanan' => $newStatus
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function stokDapur()
    {
        // Ambil semua menu jus
        $menus = MenuJus::with('kategori')->get();
        return view('mitra.stok', compact('menus'));
    }

    public function updateStok(Request $request, $id_menu)
    {
        $request->validate([
            'stok' => 'required|integer|min:0',
        ]);

        $menu = MenuJus::findOrFail($id_menu);
        $menu->stok = intval($request->stok);

        // Status otomatis: 1 = Tersedia (stok > 0), 2 = Habis (stok == 0)
        $newStatus = $menu->stok > 0 ? 1 : 2;
        $menu->id_status_stok = $newStatus;
        $menu->save();

        $statusText = $newStatus == 1 ? 'Tersedia' : 'Habis';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Stok menu ' . $menu->nama_jus . ' diperbarui menjadi ' . $menu->stok . ' (' . $statusText . ')!',
                'stok' => $menu->stok,
                'id_status_stok' => $newStatus,
                'status_text' => $statusText
            ]);
        }

        return back()->with('success', 'Stok menu ' . $menu->nama_jus . ' diperbarui!');
    }

    public function riwayatDapur()
    {
        $today = \Carbon\Carbon::today();

        $riwayat = Pesanan::with(['detail_pesanan.menu', 'riwayat_status', 'customer'])
            ->whereIn('id_status_pesanan', [3, 4, 5, 6])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $riwayat->getCollection()->transform(function ($pesanan) {
            $mulaiProses = $pesanan->riwayat_status->where('id_status_pesanan', 2)->first();
            $selesaiProses = $pesanan->riwayat_status->whereIn('id_status_pesanan', [3, 6])->first();

            $durasi = null;
            if ($mulaiProses && $selesaiProses) {
                $durasi = \Carbon\Carbon::parse($mulaiProses->created_at)->diffInMinutes(\Carbon\Carbon::parse($selesaiProses->created_at));
            }

            $pesanan->durasi_menit = $durasi;
            return $pesanan;
        });

        $totalHariIni = Pesanan::whereIn('id_status_pesanan', [3, 4, 5, 6])
            ->whereDate('updated_at', $today)
            ->count();

        return view('mitra.riwayat-dapur', compact('riwayat', 'totalHariIni'));
    }

    public function riwayatDapurJson()
    {
        $riwayat = Pesanan::with(['detail_pesanan.menu', 'riwayat_status', 'customer'])
            ->whereIn('id_status_pesanan', [3, 4, 5, 6])
            ->orderBy('updated_at', 'desc')
            ->take(20)
            ->get()
            ->map(function ($pesanan) {
                $mulaiProses = $pesanan->riwayat_status->where('id_status_pesanan', 2)->first();
                $selesaiProses = $pesanan->riwayat_status->whereIn('id_status_pesanan', [3, 6])->first();
                $durasi = null;
                if ($mulaiProses && $selesaiProses) {
                    $durasi = \Carbon\Carbon::parse($mulaiProses->created_at)->diffInMinutes(\Carbon\Carbon::parse($selesaiProses->created_at));
                }
                $pesanan->durasi_menit = $durasi;
                return $pesanan;
            });

        $html = view('mitra.partials.riwayat-list', compact('riwayat'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $riwayat->count(),
        ]);
    }

    public function pengantaranDriver()
    {
        return view('mitra.list-delivery');
    }

    public function listDelivery()
    {
        $idDriver = Auth::id();

        // 1. Antrean Delivery (Status 3, tipe 2, id_driver NULL)
        $antrean = Pesanan::with(['customer', 'alamat', 'detail_pesanan.menu'])
            ->where('id_tipe_pesanan', 2)
            ->where('id_status_pesanan', 3)
            ->whereNull('id_driver')
            ->orderBy('id_pesanan', 'asc')
            ->get();

        // 2. Pengantaran Aktif (Status 4, id_driver driver yang login)
        $aktif = Pesanan::with(['customer', 'alamat', 'detail_pesanan.menu'])
            ->where('id_driver', $idDriver)
            ->where('id_status_pesanan', 4)
            ->orderBy('id_pesanan', 'asc')
            ->get();

        // 3. Riwayat Pengantaran (Status 5 / 6, id_driver driver saat ini)
        $riwayat = Pesanan::with(['customer', 'detail_pesanan.menu'])
            ->where('id_driver', $idDriver)
            ->whereIn('id_status_pesanan', [5, 6])
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        return view('mitra.list-delivery', compact('antrean', 'aktif', 'riwayat'));
    }

    public function ambilPesanan(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        if ($pesanan->id_driver !== null) {
            return response()->json(['success' => false, 'message' => 'Pesanan sudah diambil oleh driver lain!']);
        }

        $pesanan->id_driver = Auth::id();
        $pesanan->id_status_pesanan = 4; // Diantar
        $pesanan->save();

        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_status_pesanan' => 4,
            'diubah_oleh' => Auth::id(),
            'catatan' => 'Pesanan siap diantar dan telah diambil oleh driver.'
        ]);

        Notifikasi::create([
            'id_user' => $pesanan->id_customer,
            'judul' => 'Pesanan Sedang Diantar',
            'pesan' => 'Pesanan #' . $pesanan->kode_pesanan . ' sedang dalam perjalanan menuju lokasi Anda!',
            'tipe' => 'pesanan',
            'id_pesanan' => $pesanan->id_pesanan,
            'sudah_dibaca' => false,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil diambil!']);
        }

        return back()->with('success', 'Pesanan berhasil diambil!');
    }

    public function selesaiAntar(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        if ($pesanan->id_driver != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak. Anda bukan driver pesanan ini.']);
        }

        $pesanan->id_status_pesanan = 6; // Selesai
        $pesanan->save();

        // Catat riwayat — pesanan sampai (5) lalu selesai (6)
        $riwayat5 = RiwayatStatusPesanan::where('id_pesanan', $pesanan->id_pesanan)
            ->where('id_status_pesanan', 5)->first();
        if (!$riwayat5) {
            RiwayatStatusPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_status_pesanan' => 5,
                'diubah_oleh' => Auth::id(),
                'catatan' => 'Pesanan telah sampai ke alamat customer.',
            ]);
        }

        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_status_pesanan' => 6,
            'diubah_oleh' => Auth::id(),
            'catatan' => 'Pesanan telah diantarkan sampai ke alamat customer.'
        ]);

        Notifikasi::create([
            'id_user' => $pesanan->id_customer,
            'judul' => 'Pesanan Selesai',
            'pesan' => 'Pesanan #' . $pesanan->kode_pesanan . ' telah selesai diantar. Selamat menikmati!',
            'tipe' => 'pesanan',
            'id_pesanan' => $pesanan->id_pesanan,
            'sudah_dibaca' => false,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pengantaran sukses!']);
        }

        return back()->with('success', 'Pengantaran berhasil diselesaikan!');
    }
}