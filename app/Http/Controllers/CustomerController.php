<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\MenuJus;
use App\Models\KategoriMenu;
use App\Models\Banner;
use App\Models\TipeOpsi;
use App\Models\OpsiKustomisasi;
use App\Models\Pesanan;
use App\Models\AlamatTersimpan;
use Midtrans\Config;
use Midtrans\Snap;

class CustomerController extends Controller
{
    public function landing()
    {
        $kategoriMenus = KategoriMenu::where('is_active', 1)->where('id_kategori', '!=', 3)->get();
        $menuTerlaris = MenuJus::with('kategori')
            ->where('id_status_stok', 1)
            ->where('id_menu', '!=', 3)
            ->inRandomOrder()->take(6)->get();
        $banners = Banner::where('is_active', 1)->get();

        $artikels = \App\Models\Artikel::with(['kategori', 'penulis'])
            ->where('id_status_artikel', 1)
            ->latest('created_at')
            ->take(3)
            ->get();

        return view('customer.landing', compact('kategoriMenus', 'menuTerlaris', 'banners', 'artikels'));
    }

    public function beranda()
    {
        $menus = MenuJus::with('kategori')->where('id_menu', '!=', 3)->get();
        $kategoriMenus = KategoriMenu::where('is_active', 1)->where('id_kategori', '!=', 3)->get();

        return view('customer.beranda', compact('menus', 'kategoriMenus'));
    }

    public function racik()
    {
        // Pastikan Kategori 3 ada (untuk constraint foreign key)
        \App\Models\KategoriMenu::firstOrCreate(
            ['id_kategori' => 3],
            ['nama_kategori' => 'Kustom / Racik Sendiri', 'is_active' => 0]
        );

        // Ambil data Jus Racik Sendiri sebagai basis
        $menuCustom = MenuJus::firstOrCreate(
            ['id_menu' => 3],
            [
                'nama_jus' => 'Racik Sendiri',
                'deskripsi' => 'Kustomisasi jus sesuai selera kamu',
                'id_kategori' => 3, // Asumsi kategori kustom
                'harga' => 0, // Harga dasar bisa 0, ditambah harga opsi
                'foto' => 'default_racik.png',
                'id_status_stok' => 1
            ]
        );

        // Ambil semua tipe opsi kustomisasi yang aktif untuk Racik Sendiri
        $tipeOpsi = TipeOpsi::with(['opsi' => function ($q) {
            $q->where('is_active', 1);
        }])->whereIn('id_tipe_opsi', [2, 3, 4, 5, 6, 7, 8, 9])->get();

        return view('customer.racik', compact('menuCustom', 'tipeOpsi'));
    }

    public function detailMenu($id)
    {
        $menu = MenuJus::with(['kategori', 'ulasan.customer'])->findOrFail($id);
        
        // Load customization options grouped by type (Exclude Racik Sendiri types)
        $tipeOpsi = TipeOpsi::with(['opsi' => function ($q) {
            $q->where('is_active', 1);
        }])->whereNotIn('id_tipe_opsi', [4, 5, 7, 8])->get();
        
        // Related products from the same category (exclude current)
        $relatedMenus = MenuJus::with('kategori')
            ->where('id_kategori', $menu->id_kategori)
            ->where('id_menu', '!=', $menu->id_menu)
            ->where('id_status_stok', 1)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('customer.detail-menu', compact('menu', 'tipeOpsi', 'relatedMenus'));
    }

    /**
     * Mengambil data kustomisasi untuk pop-up modal (AJAX)
     */
    public function getKustomisasiData($id)
    {
        $menu = MenuJus::findOrFail($id);

        // Ambil tipe opsi beserta opsi kustomisasinya yang aktif
        if ($menu->id_menu == 3) {
            // Jika ini adalah menu Racik Sendiri
            $tipeOpsi = TipeOpsi::with(['opsi' => function ($query) {
                $query->where('is_active', true);
            }])->whereIn('id_tipe_opsi', [4, 5, 7, 8])->get();
        } else {
            // Menu reguler, sembunyikan opsi Racik Sendiri
            $tipeOpsi = TipeOpsi::with(['opsi' => function ($query) {
                $query->where('is_active', true);
            }])->whereNotIn('id_tipe_opsi', [4, 5, 7, 8])->get();
        }

        return response()->json([
            'menu' => $menu,
            'tipe_opsi' => $tipeOpsi
        ]);
    }

    public function profil()
    {
        $user = Auth::user();
        return view('customer.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'no_hp' => 'nullable|string|max:20',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;

        if ($request->hasFile('foto_profil')) {
            // Delete old photo
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = $request->file('foto_profil')->store('profil', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success_password', 'Password berhasil diubah!');
    }

    // ========== ALAMAT ==========

    public function alamat()
    {
        $alamats = AlamatTersimpan::where('id_customer', Auth::id())->get();
        return view('customer.alamat', compact('alamats'));
    }

    public function simpanAlamat(Request $request)
    {
        $request->validate([
            'id_alamat' => 'nullable|exists:alamat_tersimpan,id_alamat',
            'label' => 'required|string|max:50',
            'alamat_lengkap' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'nama_penerima' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:30',
        ]);

        // Format alamat_lengkap dengan menyertakan nama penerima & nomor HP terdelimitasi
        $namaPenerima = $request->nama_penerima ?: Auth::user()->nama_lengkap;
        $noHp = $request->no_hp ?: Auth::user()->no_hp;
        $alamatDetail = $request->alamat_lengkap;
        
        $alamatGabungan = trim($namaPenerima) . ' | ' . trim($noHp) . ' | ' . trim($alamatDetail);

        // Jika is_utama di-check, reset alamat utama lainnya
        if ($request->is_utama) {
            AlamatTersimpan::where('id_customer', Auth::id())->update(['is_utama' => false]);
        }

        if ($request->id_alamat) {
            // Update Alamat
            $alamat = AlamatTersimpan::where('id_alamat', $request->id_alamat)
                ->where('id_customer', Auth::id())
                ->firstOrFail();
                
            $alamat->update([
                'label' => $request->label,
                'alamat_lengkap' => $alamatGabungan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_utama' => $request->is_utama ? true : false,
            ]);
            $pesan = 'Alamat berhasil diperbarui!';
        } else {
            // Create Alamat Baru
            AlamatTersimpan::create([
                'id_customer' => Auth::id(),
                'label' => $request->label,
                'alamat_lengkap' => $alamatGabungan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'is_utama' => $request->is_utama ? true : false,
            ]);
            $pesan = 'Alamat berhasil ditambahkan!';
        }

        if ($request->wantsJson() || $request->ajax()) {
            $alamats = AlamatTersimpan::where('id_customer', Auth::id())->latest()->get();
            return response()->json([
                'success' => true,
                'message' => $pesan,
                'alamats' => $alamats
            ]);
        }

        return back()->with('success', $pesan);
    }

    public function hapusAlamat(Request $request, $id)
    {
        $alamat = AlamatTersimpan::where('id_alamat', $id)->where('id_customer', Auth::id())->firstOrFail();
        $alamat->delete();

        if ($request->wantsJson() || $request->ajax()) {
            $alamats = AlamatTersimpan::where('id_customer', Auth::id())->latest()->get();
            return response()->json([
                'success' => true,
                'message' => 'Alamat berhasil dihapus!',
                'alamats' => $alamats
            ]);
        }

        return back()->with('success', 'Alamat berhasil dihapus!');
    }

    // ========== KERANJANG ==========

    public function keranjang()
    {
        $keranjang = \App\Models\Keranjang::with(['menu', 'opsi.opsi'])
            ->where('id_customer', Auth::id())
            ->get();
            
        $subtotal = $keranjang->sum('subtotal');
        
        return view('customer.keranjang', compact('keranjang', 'subtotal'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|exists:menu_jus,id_menu',
            'jumlah' => 'required|integer|min:1',
            'opsi' => 'nullable|array' // Array of id_opsi
        ]);

        $idCustomer = Auth::id();
        $idMenu = $request->id_menu;
        $jumlahBaru = (int) $request->jumlah;
        $opsiDipilih = $request->opsi ? array_map('intval', $request->opsi) : [];
        sort($opsiDipilih); // Urutkan ID opsi agar perbandingannya konsisten

        // 1. Ambil semua item keranjang milik customer untuk menu tersebut
        $keranjangExist = \App\Models\Keranjang::with('opsi')
            ->where('id_customer', $idCustomer)
            ->where('id_menu', $idMenu)
            ->get();

        $itemDitemukan = null;

        // 2. Cari apakah ada item dengan opsi kustomisasi yang sama persis
        foreach ($keranjangExist as $item) {
            $opsiItem = $item->opsi->pluck('id_opsi')->toArray();
            sort($opsiItem);

            if ($opsiItem === $opsiDipilih) {
                $itemDitemukan = $item;
                break;
            }
        }

        $menu = \App\Models\MenuJus::findOrFail($idMenu);
        $hargaTotalOpsi = 0;
        if (!empty($opsiDipilih)) {
            $hargaTotalOpsi = \App\Models\OpsiKustomisasi::whereIn('id_opsi', $opsiDipilih)->sum('harga_tambahan');
        }
        $hargaSatuan = $menu->harga + $hargaTotalOpsi;

        if ($itemDitemukan) {
            // Jika ditemukan kombinasi yang sama, akumulasikan jumlahnya
            $itemDitemukan->jumlah += $jumlahBaru;
            $itemDitemukan->subtotal = $hargaSatuan * $itemDitemukan->jumlah;
            $itemDitemukan->save();
        } else {
            // Jika tidak ada yang sama, buat item keranjang baru
            $keranjang = \App\Models\Keranjang::create([
                'id_customer' => $idCustomer,
                'id_menu' => $idMenu,
                'jumlah' => $jumlahBaru,
                'subtotal' => $hargaSatuan * $jumlahBaru
            ]);

            if (!empty($opsiDipilih)) {
                foreach ($opsiDipilih as $id_opsi) {
                    \App\Models\KeranjangOpsi::create([
                        'id_keranjang' => $keranjang->id_keranjang,
                        'id_opsi' => $id_opsi
                    ]);
                }
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Berhasil ditambahkan ke keranjang']);
        }

        return redirect()->route('customer.keranjang')->with('success', 'Berhasil ditambahkan ke keranjang');
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate(['jumlah' => 'required|integer|min:1']);
        $keranjang = \App\Models\Keranjang::where('id_keranjang', $id)->where('id_customer', Auth::id())->firstOrFail();
        
        $harga_satuan = $keranjang->subtotal / $keranjang->jumlah;
        $keranjang->jumlah = $request->jumlah;
        $keranjang->subtotal = $harga_satuan * $request->jumlah;
        $keranjang->save();

        return response()->json(['success' => true, 'subtotal' => $keranjang->subtotal]);
    }

    public function removeFromCart($id)
    {
        $keranjang = \App\Models\Keranjang::where('id_keranjang', $id)->where('id_customer', Auth::id())->firstOrFail();
        $keranjang->opsi()->delete();
        $keranjang->delete();

        return response()->json(['success' => true]);
    }

    // ========== CHECKOUT ==========

    public function checkout()
    {
        $keranjang = \App\Models\Keranjang::with(['menu', 'opsi.opsi'])
            ->where('id_customer', Auth::id())
            ->get();
            
        if ($keranjang->isEmpty()) {
            return redirect()->route('customer.keranjang')->withErrors('Keranjang Anda kosong.');
        }

        $subtotal = $keranjang->sum('subtotal');
        $alamats = AlamatTersimpan::where('id_customer', Auth::id())->get();
        $konfigurasi = \App\Models\KonfigurasiDelivery::first();

        return view('customer.checkout', compact('keranjang', 'subtotal', 'alamats', 'konfigurasi'));
    }

    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'tipe_pesanan' => 'required|in:1,2',
            'id_alamat' => 'nullable|exists:alamat_tersimpan,id_alamat',
            'alamat_lengkap' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $keranjang = \App\Models\Keranjang::with(['menu', 'opsi.opsi'])
            ->where('id_customer', Auth::id())
            ->get();

        if ($keranjang->isEmpty()) {
            return response()->json([
                'success' => false,
                'error' => 'Keranjang Anda kosong.'
            ], 422);
        }

        // Tentukan tipe pesanan dan alamat
        $alamat = null;
        $alamatSnapshot = null;
        $jarakKm = null;
        $ongkosKirim = 0;
        $tipePesanan = intval($request->tipe_pesanan);

        if ($tipePesanan == 2) {
            $konfigurasi = \App\Models\KonfigurasiDelivery::first();
            $tokoLat = $konfigurasi->latitude_toko ?? -6.200000;
            $tokoLng = $konfigurasi->longitude_toko ?? 106.816666;
            $maxRadius = $konfigurasi->radius_maks_km ?? 7.0;
            $tarif0_3 = $konfigurasi->tarif_0_3km ?? 5000;
            $tarif3_7 = $konfigurasi->tarif_3_7km ?? 7000;

            if ($request->id_alamat) {
                $alamat = AlamatTersimpan::where('id_alamat', $request->id_alamat)
                    ->where('id_customer', Auth::id())
                    ->first();
                if (!$alamat) {
                    return response()->json(['success' => false, 'error' => 'Alamat tidak ditemukan.'], 422);
                }
            } else {
                if (!$request->alamat_lengkap || !$request->latitude || !$request->longitude) {
                    return response()->json(['success' => false, 'error' => 'Data alamat pengiriman tidak lengkap.'], 422);
                }
                // Simpan alamat baru agar tersimpan untuk berikutnya
                $alamat = AlamatTersimpan::create([
                    'id_customer' => Auth::id(),
                    'label' => 'Alamat Pengiriman Baru',
                    'alamat_lengkap' => $request->alamat_lengkap,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'is_utama' => false,
                ]);
            }

            $alamatSnapshot = $alamat->alamat_lengkap;
            $jarakKm = $this->haversine($tokoLat, $tokoLng, $alamat->latitude, $alamat->longitude);

            if ($jarakKm > $maxRadius) {
                return response()->json([
                    'success' => false,
                    'error' => 'Alamat pengiriman di luar jangkauan radius maks (' . $maxRadius . ' km).'
                ], 422);
            }

            // Hitung ongkos kirim sesuai formula backend yang aman
            if ($jarakKm <= 3) {
                $ongkosKirim = $tarif0_3;
            } else {
                $ongkosKirim = $tarif0_3;
                $excessKm = $jarakKm - 3;
                $kelipatan500m = ceil($excessKm / 0.5);
                $ongkosKirim += ($kelipatan500m * $tarif3_7);
            }
        }

        $subtotal = $keranjang->sum('subtotal');
        $totalBayar = $subtotal + $ongkosKirim;

        // Potongan Poin
        $poinDigunakan = 0;
        if ($request->has('gunakan_poin') && $request->gunakan_poin == 'on') {
            $userPoin = Auth::user()->poin ?? 0;
            $poinDigunakan = min($userPoin, $totalBayar);
            $totalBayar -= $poinDigunakan;
        }

        // Validasi ketersediaan stok sebelum transaksi
        foreach ($keranjang as $item) {
            if ($item->menu->stok < $item->jumlah) {
                return response()->json([
                    'success' => false,
                    'error' => 'Stok untuk ' . $item->menu->nama_jus . ' tidak mencukupi (Tersisa: ' . $item->menu->stok . ').'
                ], 422);
            }
        }

        // Generate unique order code
        $kodePesanan = 'JK-' . now()->format('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        // Mulai database transaction untuk keamanan data
        DB::beginTransaction();

        try {
            // Buat pesanan
            $pesanan = Pesanan::create([
                'kode_pesanan' => $kodePesanan,
                'id_customer' => Auth::id(),
                'id_driver' => null,
                'id_tipe_pesanan' => $tipePesanan,
                'id_slot' => null,
                'tanggal_pesan' => now()->toDateString(),
                'id_alamat' => $alamat ? $alamat->id_alamat : null,
                'alamat_snapshot' => $alamatSnapshot,
                'jarak_km' => $jarakKm ? round($jarakKm, 2) : null,
                'subtotal' => $subtotal,
                'ongkos_kirim' => $ongkosKirim,
                'total_bayar' => $totalBayar,
                'id_status_pesanan' => 1, // Baru (Menunggu Pembayaran)
                'metode_pembayaran' => 'Midtrans',
                'poin_digunakan' => $poinDigunakan,
            ]);

            if ($poinDigunakan > 0) {
                // Potong saldo poin user saat ini
                $user = Auth::user();
                $user->poin -= $poinDigunakan;
                $user->save();
            }

            // Pindahkan item keranjang ke detail_pesanan
            foreach ($keranjang as $item) {
                $hargaSatuan = $item->jumlah > 0 ? intval($item->subtotal / $item->jumlah) : $item->subtotal;
                
                $detail = \App\Models\DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_menu' => $item->id_menu,
                    'nama_menu_snapshot' => $item->menu->nama_jus,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $item->subtotal,
                ]);

                // Kurangi stok menu
                $menu = $item->menu;
                $menu->stok = max(0, $menu->stok - $item->jumlah);
                if ($menu->stok == 0) {
                    $menu->id_status_stok = 2; // Habis
                }
                $menu->save();

                // Pindahkan opsi
                if ($item->opsi && $item->opsi->count() > 0) {
                    foreach ($item->opsi as $keranjangOpsi) {
                        \App\Models\DetailPesananOpsi::create([
                            'id_detail' => $detail->id_detail,
                            'id_opsi' => $keranjangOpsi->id_opsi,
                            'nama_opsi_snapshot' => $keranjangOpsi->opsi->nama_opsi ?? '-',
                            'harga_tambahan_snapshot' => $keranjangOpsi->opsi->harga_tambahan ?? 0,
                        ]);
                    }
                }
            }

            // Catat ke riwayat status pesanan
            \App\Models\RiwayatStatusPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_status_pesanan' => 1,
                'diubah_oleh' => null,
                'catatan' => 'Pesanan baru dibuat (menunggu pembayaran Midtrans)',
            ]);

            // Kirim notifikasi awal
            \App\Models\Notifikasi::create([
                'id_user' => Auth::id(),
                'judul' => 'Pesanan Berhasil Dibuat',
                'pesan' => 'Pesanan #' . $kodePesanan . ' berhasil dibuat. Menunggu pembayaran.',
                'tipe' => 'pesanan',
                'id_pesanan' => $pesanan->id_pesanan,
                'sudah_dibaca' => false,
            ]);

            // Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
            Config::$is3ds = env('MIDTRANS_IS_3DS', true);

            $params = [
                'transaction_details' => [
                    'order_id' => $pesanan->kode_pesanan,
                    'gross_amount' => (int) $pesanan->total_bayar,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->nama_lengkap,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->no_hp ?? '',
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            // Bersihkan keranjang
            foreach ($keranjang as $item) {
                $item->opsi()->delete();
                $item->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'id_pesanan' => $pesanan->id_pesanan
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Haversine formula to calculate distance between two lat/lng coordinates
     */
    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $R = 6371; // Earth radius in km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $R * $c;
    }

    // ========== TRACKING ==========

    public function tracking(Request $request)
    {
        $query = Pesanan::with(['customer', 'detail_pesanan.menu', 'driver', 'alamat', 'riwayat_status'])
            ->where('id_customer', Auth::id());

        if ($request->has('id')) {
            $pesanan = $query->where('id_pesanan', $request->id)->firstOrFail();
        } else {
            // Get the most recent active order
            $pesanan = $query->whereNotIn('id_status_pesanan', [6, 7])
                ->latest()
                ->first();

            // If no active order, get the most recent order
            if (!$pesanan) {
                $pesanan = Pesanan::with(['customer', 'detail_pesanan.menu', 'driver', 'alamat', 'riwayat_status'])
                    ->where('id_customer', Auth::id())
                    ->latest()
                    ->first();
            }
        }

        if (!$pesanan) {
            return redirect()->route('menu')->with('info', 'Anda belum memiliki pesanan.');
        }

        // Status definitions for the tracker
        $statusList = [
            ['id' => 1, 'label' => 'Pesanan Dikonfirmasi', 'icon' => 'clipboard-check', 'desc' => 'Pesanan diterima sistem'],
            ['id' => 2, 'label' => 'Sedang Diproses', 'icon' => 'chef-hat', 'desc' => 'Pesanan sedang disiapkan dapur'],
            ['id' => 3, 'label' => 'Pesanan Siap', 'icon' => 'package-check', 'desc' => 'Pesanan siap diambil / diantar'],
        ];

        // Add delivery-specific steps
        if ($pesanan->id_tipe_pesanan == 2) {
            $statusList[] = ['id' => 4, 'label' => 'Sedang Diantar', 'icon' => 'truck', 'desc' => 'Driver sedang mengantar pesanan'];
            $statusList[] = ['id' => 5, 'label' => 'Pesanan Sampai', 'icon' => 'map-pin-check', 'desc' => 'Pesanan telah sampai di tujuan'];
        }

        $statusList[] = ['id' => 6, 'label' => 'Selesai', 'icon' => 'smile', 'desc' => 'Pesanan telah selesai'];

        return view('customer.tracking', compact('pesanan', 'statusList'));
    }

    // ========== RIWAYAT ==========

    public function riwayatPesanan()
    {
        $pesanans = Pesanan::with(['detail_pesanan.menu'])
            ->where('id_customer', Auth::id())
            ->latest()
            ->paginate(10);

        return view('customer.riwayat', compact('pesanans'));
    }

    // ========== LANGGANAN JUS MINGGUAN ==========

    public function halamanLangganan()
    {
        $pakets = \App\Models\PaketLangganan::where('is_active', true)->with('menus')->get();
        return view('customer.langganan', compact('pakets'));
    }

    public function checkoutLangganan($id)
    {
        $paket = \App\Models\PaketLangganan::with('menus')->findOrFail($id);
        $alamats = AlamatTersimpan::where('id_customer', Auth::id())->get();

        return view('customer.checkout-langganan', compact('paket', 'alamats'));
    }

    public function prosesPembelianLangganan(Request $request)
    {
        $request->validate([
            'id_paket' => 'required|exists:paket_langganan,id_paket',
            'id_alamat' => 'required|exists:alamat_tersimpan,id_alamat',
            'hari_pengiriman' => 'required|array|min:1',
            'id_menu_default' => 'required|exists:menu_jus,id_menu',
        ]);

        $paket = \App\Models\PaketLangganan::findOrFail($request->id_paket);

        // Buat data langganan baru (status prabayar Menunggu)
        $langganan = \App\Models\LanggananAktif::create([
            'id_customer' => Auth::id(),
            'id_paket' => $request->id_paket,
            'id_alamat' => $request->id_alamat,
            'hari_pengiriman' => json_encode($request->hari_pengiriman),
            'id_menu_default' => $request->id_menu_default,
            'sisa_pengiriman' => $paket->total_pengiriman,
            'status_pembayaran' => 'Menunggu',
            'is_active' => false,
        ]);

        try {
            // Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
            Config::$is3ds = env('MIDTRANS_IS_3DS', true);

            $params = [
                'transaction_details' => [
                    'order_id' => 'JK-SUB-' . $langganan->id_langganan . '-' . time(),
                    'gross_amount' => (int) $paket->harga,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->nama_lengkap,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->no_hp ?? '',
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'id_langganan' => $langganan->id_langganan
            ]);

        } catch (\Exception $e) {
            $langganan->delete(); // Hapus jika gagal memicu Midtrans
            \Log::error('Subscription Purchase Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Gagal memproses pembayaran langganan: ' . $e->getMessage()
            ], 500);
        }
    }
}