<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\MenuJus;
use App\Models\RiwayatStatusPesanan;
use App\Models\Notifikasi;
use App\Models\AlamatToko;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Status label map used across admin views
     */
    private function statusMap()
    {
        return [
            1 => ['label' => 'Baru', 'color' => 'blue'],
            2 => ['label' => 'Diproses', 'color' => 'yellow'],
            3 => ['label' => 'Siap', 'color' => 'purple'],
            4 => ['label' => 'Diantar', 'color' => 'orange'],
            5 => ['label' => 'Sampai', 'color' => 'cyan'],
            6 => ['label' => 'Selesai', 'color' => 'green'],
            7 => ['label' => 'Dibatalkan', 'color' => 'red'],
        ];
    }

    public function dashboard()
    {
        // Statistik untuk Laporan Penjualan (Home Admin)
        $totalPendapatan = Pesanan::whereIn('id_status_pesanan', [6])->sum('total_bayar'); // 6 = Selesai
        $pesananSelesai = Pesanan::whereIn('id_status_pesanan', [6])->count();
        $pesananBaru = Pesanan::whereIn('id_status_pesanan', [1,2,3,4,5])->count(); // Aktif
        $totalPelanggan = User::where('id_role', 2)->count(); // 2 = Customer

        // 5 Menu Terlaris (berdasarkan Detail Pesanan yang sukses)
        $menuTerlaris = MenuJus::withSum(['detail_pesanan' => function($q) {
            $q->whereHas('pesanan', function($q2) {
                $q2->where('id_status_pesanan', 6);
            });
        }], 'jumlah')->orderByDesc('detail_pesanan_sum_jumlah')->take(5)->get();

        // 5 Pesanan Terbaru
        $pesananTerbaru = Pesanan::with(['customer'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPendapatan', 'pesananSelesai', 'pesananBaru', 'totalPelanggan',
            'menuTerlaris', 'pesananTerbaru'
        ));
    }

    // ========== KELOLA PESANAN / TRANSAKSI ==========

    public function pesananMasuk(Request $request)
    {
        $statusMap = $this->statusMap();

        $query = Pesanan::with(['customer', 'detail_pesanan.menu', 'driver', 'alamat']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('id_status_pesanan', $request->status);
        }

        // Filter by tipe pesanan
        if ($request->filled('tipe')) {
            $query->where('id_tipe_pesanan', $request->tipe);
        }

        // Search by kode pesanan or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q2) use ($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  });
            });
        }

        $pesanans = $query->latest()->paginate(10)->withQueryString();

        // Get available drivers
        $drivers = User::where('id_role', 4)->where('is_active', 1)->get();

        // Count per status for filter badges
        $statusCounts = Pesanan::selectRaw('id_status_pesanan, count(*) as total')
            ->groupBy('id_status_pesanan')
            ->pluck('total', 'id_status_pesanan');

        return view('admin.pesanan', compact('pesanans', 'statusMap', 'drivers', 'statusCounts'));
    }

    public function updateStatus(Request $request, $id_pesanan)
    {
        $request->validate([
            'status' => 'required|integer|in:1,2,3,4,5,6,7',
            'catatan' => 'nullable|string|max:255',
        ]);

        $pesanan = Pesanan::findOrFail($id_pesanan);
        $statusMap = $this->statusMap();
        $newStatus = $request->status;

        $pesanan->id_status_pesanan = $newStatus;
        $pesanan->save();

        // Record status history
        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_status_pesanan' => $newStatus,
            'diubah_oleh' => Auth::id(),
            'catatan' => $request->catatan ?? 'Status diubah ke ' . ($statusMap[$newStatus]['label'] ?? 'Unknown'),
        ]);

        // Send notification to customer
        Notifikasi::create([
            'id_user' => $pesanan->id_customer,
            'judul' => 'Status Pesanan Diperbarui',
            'pesan' => 'Pesanan #' . $pesanan->kode_pesanan . ' sekarang berstatus: ' . ($statusMap[$newStatus]['label'] ?? 'Unknown'),
            'tipe' => 'pesanan',
            'id_pesanan' => $pesanan->id_pesanan,
            'sudah_dibaca' => false,
        ]);

        return back()->with('success', 'Status pesanan berhasil diubah ke ' . ($statusMap[$newStatus]['label'] ?? 'Unknown'));
    }

    public function assignDriver(Request $request, $id_pesanan)
    {
        $request->validate([
            'id_driver' => 'required|exists:users,id_user',
        ]);

        $pesanan = Pesanan::findOrFail($id_pesanan);
        $driver = User::findOrFail($request->id_driver);

        $pesanan->id_driver = $driver->id_user;
        $pesanan->id_status_pesanan = 4; // Sedang Diantar
        $pesanan->save();

        // Record status history
        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_status_pesanan' => 4,
            'diubah_oleh' => Auth::id(),
            'catatan' => 'Driver ditugaskan: ' . $driver->nama_lengkap,
        ]);

        // Notify customer
        Notifikasi::create([
            'id_user' => $pesanan->id_customer,
            'judul' => 'Driver Ditugaskan',
            'pesan' => 'Pesanan #' . $pesanan->kode_pesanan . ' sedang diantar oleh ' . $driver->nama_lengkap,
            'tipe' => 'pesanan',
            'id_pesanan' => $pesanan->id_pesanan,
            'sudah_dibaca' => false,
        ]);

        return back()->with('success', 'Driver ' . $driver->nama_lengkap . ' berhasil ditugaskan!');
    }

    // ========== LAPORAN ==========

    public function laporan(Request $request)
    {
        if ($request->has('filter')) {
            $filter = $request->filter;
            if ($filter == 'hari-ini') {
                $startDate = Carbon::now()->toDateString();
                $endDate = Carbon::now()->toDateString();
                $start = Carbon::parse($startDate)->setTime(7, 0, 0);
                $end = Carbon::parse($endDate)->setTime(21, 0, 0);
            } elseif ($filter == 'minggu-ini') {
                $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
                $endDate = Carbon::now()->endOfWeek(Carbon::SUNDAY)->toDateString();
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
            } elseif ($filter == 'bulan-ini') {
                $startDate = Carbon::now()->startOfMonth()->toDateString();
                $endDate = Carbon::now()->endOfMonth()->toDateString();
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
            } elseif ($filter == 'tahun-ini') {
                $startDate = Carbon::now()->startOfYear()->toDateString();
                $endDate = Carbon::now()->endOfYear()->toDateString();
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
            } else {
                $startDate = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
                $endDate = $request->input('end_date', Carbon::now()->toDateString());
                $start = Carbon::parse($startDate)->startOfDay();
                $end = Carbon::parse($endDate)->endOfDay();
            }
        } else {
            $filter = '';
            $startDate = $request->input('start_date', Carbon::now()->subDays(30)->toDateString());
            $endDate = $request->input('end_date', Carbon::now()->toDateString());
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
        }

        // Key metrics
        $totalPendapatan = Pesanan::where('id_status_pesanan', 6)
            ->whereBetween('tanggal_pesan', [$start, $end])
            ->sum('total_bayar');

        $pesananSukses = Pesanan::where('id_status_pesanan', 6)
            ->whereBetween('tanggal_pesan', [$start, $end])
            ->count();

        $rataRata = $pesananSukses > 0 ? intval($totalPendapatan / $pesananSukses) : 0;

        $pesananBatal = Pesanan::where('id_status_pesanan', 7)
            ->whereBetween('tanggal_pesan', [$start, $end])
            ->count();

        // Daily revenue trend for chart
        $dailyRevenue = Pesanan::where('id_status_pesanan', 6)
            ->whereBetween('tanggal_pesan', [$start, $end])
            ->selectRaw('tanggal_pesan, SUM(total_bayar) as revenue, COUNT(*) as orders')
            ->groupBy('tanggal_pesan')
            ->orderBy('tanggal_pesan')
            ->get();

        // Tipe pesanan breakdown
        $tipePesanan = Pesanan::where('id_status_pesanan', 6)
            ->whereBetween('tanggal_pesan', [$start, $end])
            ->selectRaw('id_tipe_pesanan, COUNT(*) as total')
            ->groupBy('id_tipe_pesanan')
            ->pluck('total', 'id_tipe_pesanan');

        // Payment method breakdown
        $metodePembayaran = Pesanan::where('id_status_pesanan', 6)
            ->whereBetween('tanggal_pesan', [$start, $end])
            ->selectRaw('metode_pembayaran, COUNT(*) as total')
            ->groupBy('metode_pembayaran')
            ->pluck('total', 'metode_pembayaran');

        // Top selling menu
        $menuTerlaris = MenuJus::withSum(['detail_pesanan' => function($q) use ($start, $end) {
            $q->whereHas('pesanan', function($q2) use ($start, $end) {
                $q2->where('id_status_pesanan', 6)->whereBetween('tanggal_pesan', [$start, $end]);
            });
        }], 'jumlah')
        ->withSum(['detail_pesanan' => function($q) use ($start, $end) {
            $q->whereHas('pesanan', function($q2) use ($start, $end) {
                $q2->where('id_status_pesanan', 6)->whereBetween('tanggal_pesan', [$start, $end]);
            });
        }], 'subtotal')
        ->whereHas('detail_pesanan', function($q) use ($start, $end) {
            $q->whereHas('pesanan', function($q2) use ($start, $end) {
                $q2->where('id_status_pesanan', 6)->whereBetween('tanggal_pesan', [$start, $end]);
            });
        })
        ->orderByDesc('detail_pesanan_sum_jumlah')
        ->take(10)
        ->get();

        return view('admin.laporan', compact(
            'startDate', 'endDate', 'filter',
            'totalPendapatan', 'pesananSukses', 'rataRata', 'pesananBatal',
            'dailyRevenue', 'tipePesanan', 'metodePembayaran', 'menuTerlaris'
        ));
    }

    // ========== PENGATURAN ==========

    public function pengaturan()
    {
        $konfigurasi = \App\Models\KonfigurasiDelivery::first();
        if (!$konfigurasi) {
            $konfigurasi = \App\Models\KonfigurasiDelivery::create([
                'alamat_toko' => 'Jl. Dharmahusada No. 1, Mojo, Kec. Gubeng, Surabaya, Jawa Timur 60285',
                'radius_maks_km' => 7,
                'tarif_0_3km' => 3000,
                'tarif_3_7km' => 1000,
                'latitude_toko' => '-6.200000',
                'longitude_toko' => '106.816666'
            ]);
        }
        $alamatToko = \App\Models\AlamatToko::orderBy('is_active', 'desc')->orderBy('id_alamat_toko')->get();
        return view('admin.pengaturan', compact('konfigurasi', 'alamatToko'));
    }

    public function updatePengaturan(Request $request)
    {
        $request->validate([
            'alamat_toko' => 'required|string',
            'radius_maks_km' => 'required|numeric',
            'tarif_0_3km' => 'required|numeric',
            'tarif_3_7km' => 'required|numeric',
            'latitude_toko' => 'required|numeric',
            'longitude_toko' => 'required|numeric'
        ]);

        $konfigurasi = \App\Models\KonfigurasiDelivery::first();
        if ($konfigurasi) {
            $konfigurasi->update($request->all());
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    // ========== CRUD ALAMAT TOKO ==========

    public function alamatTokoIndex()
    {
        $alamats = AlamatToko::orderBy('is_active', 'desc')->orderBy('id_alamat_toko')->get();
        return view('admin.alamat-toko.index', compact('alamats'));
    }

    public function alamatTokoStore(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        AlamatToko::create([
            'label' => $request->label,
            'alamat_lengkap' => $request->alamat_lengkap,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.alamat-toko.index')->with('success', 'Alamat toko berhasil ditambahkan!');
    }

    public function alamatTokoUpdate(Request $request, $id)
    {
        $request->validate([
            'label' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_active' => 'nullable|boolean',
        ]);

        $alamat = AlamatToko::findOrFail($id);
        $alamat->update([
            'label' => $request->label,
            'alamat_lengkap' => $request->alamat_lengkap,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.alamat-toko.index')->with('success', 'Alamat toko berhasil diperbarui!');
    }

    public function alamatTokoDestroy($id)
    {
        AlamatToko::findOrFail($id)->delete();
        return redirect()->route('admin.alamat-toko.index')->with('success', 'Alamat toko berhasil dihapus!');
    }

    // ========== GENERATOR PESANAN LANGGANAN HARIAN ==========

    public function generateDailySubscriptionOrders()
    {
        $dayMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        
        $hariIni = $dayMap[\Carbon\Carbon::now()->format('l')];
        
        // Ambil semua langganan aktif yang memiliki sisa kuota kirim
        $langgananAktif = \App\Models\LanggananAktif::where('is_active', true)
            ->where('sisa_pengiriman', '>', 0)
            ->where('status_pembayaran', 'Lunas')
            ->get();

        $count = 0;
        
        foreach ($langgananAktif as $sub) {
            $hariKirim = json_decode($sub->hari_pengiriman, true) ?: [];
            
            // Jika hari ini dijadwalkan kirim untuk paket ini
            if (in_array($hariIni, $hariKirim)) {
                
                // Format kode pesanan khusus: JK-SUB-{id_langganan}-{sisa_pengiriman}
                $kodePesanan = 'JK-SUB-' . $sub->id_langganan . '-' . str_pad($sub->sisa_pengiriman, 2, '0', STR_PAD_LEFT);
                
                // Mencegah pembuatan ganda pesanan berkode sama pada hari yang sama
                $exist = \App\Models\Pesanan::where('kode_pesanan', $kodePesanan)->exists();
                if ($exist) {
                    continue;
                }

                // Ambil menu default pilihan customer, jika kosong gunakan jus terlaris acak
                $menu = \App\Models\MenuJus::find($sub->id_menu_default);
                if (!$menu) {
                    $menu = \App\Models\MenuJus::where('id_status_stok', 1)->where('id_menu', '!=', 3)->first();
                }
                
                if (!$menu) {
                    continue;
                }

                DB::beginTransaction();
                try {
                    // 1. Buat pesanan Rp0
                    $pesanan = \App\Models\Pesanan::create([
                        'kode_pesanan' => $kodePesanan,
                        'id_customer' => $sub->id_customer,
                        'id_driver' => null,
                        'id_tipe_pesanan' => 2, // Delivery
                        'tanggal_pesan' => \Carbon\Carbon::today()->toDateString(),
                        'id_alamat' => $sub->id_alamat,
                        'alamat_snapshot' => $sub->alamat->alamat_lengkap ?? 'Alamat Langganan',
                        'subtotal' => 0,
                        'ongkos_kirim' => 0,
                        'total_bayar' => 0,
                        'id_status_pesanan' => 1, // Baru (Antrean Dapur)
                        'metode_pembayaran' => 'Langganan'
                    ]);

                    // 2. Tambah detail menu jus
                    \App\Models\DetailPesanan::create([
                        'id_pesanan' => $pesanan->id_pesanan,
                        'id_menu' => $menu->id_menu,
                        'nama_menu_snapshot' => $menu->nama_jus . ' (Paket Langganan)',
                        'jumlah' => 1,
                        'harga_satuan' => 0,
                        'subtotal' => 0
                    ]);

                    // 3. Catat riwayat status
                    \App\Models\RiwayatStatusPesanan::create([
                        'id_pesanan' => $pesanan->id_pesanan,
                        'id_status_pesanan' => 1,
                        'diubah_oleh' => null,
                        'catatan' => 'Pesanan langganan harian otomatis dibuat untuk hari ' . $hariIni,
                    ]);

                    // 4. Kirim notifikasi ke customer
                    \App\Models\Notifikasi::create([
                        'id_user' => $sub->id_customer,
                        'judul' => 'Pesanan Langganan Dikirim Hari Ini',
                        'pesan' => 'Jus default ' . $menu->nama_jus . ' sedang disiapkan oleh Dapur untuk pengiriman hari ' . $hariIni . '.',
                        'tipe' => 'pesanan',
                        'id_pesanan' => $pesanan->id_pesanan,
                        'sudah_dibaca' => false,
                    ]);

                    // 5. Kurangi kuota sisa pengiriman
                    $sub->sisa_pengiriman -= 1;
                    if ($sub->sisa_pengiriman <= 0) {
                        $sub->is_active = false;
                    }
                    $sub->save();

                    DB::commit();
                    $count++;

                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::error('Gagal generate pesanan langganan #' . $sub->id_langganan . ': ' . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Berhasil membuat ' . $count . ' pesanan langganan harian untuk hari ' . $hariIni . '!');
    }
}