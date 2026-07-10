<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Midtrans\Notification;
use Midtrans\Config;

class PaymentCallbackController extends Controller
{
    public function handleNotification(Request $request)
    {
        // Konfigurasi server key Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);

        try {
            $notifikasi = new Notification();
            
            $statusTransaksi = $notifikasi->transaction_status;
            $tipePembayaran = $notifikasi->payment_type;
            $kodePesanan = $notifikasi->order_id;
            $fraudStatus = $notifikasi->fraud_status;

            // Cek apakah ini transaksi langganan
            if (str_starts_with($kodePesanan, 'JK-SUB-')) {
                $parts = explode('-', $kodePesanan);
                $idLangganan = count($parts) > 2 ? $parts[2] : null;
                
                $langganan = \App\Models\LanggananAktif::with('paket')->find($idLangganan);
                if (!$langganan) {
                    return response()->json(['message' => 'Langganan tidak ditemukan'], 404);
                }

                $statusPembayaran = 'Menunggu';
                $isActive = false;

                if ($statusTransaksi == 'settlement' || ($statusTransaksi == 'capture' && $fraudStatus != 'challenge')) {
                    $statusPembayaran = 'Lunas';
                    $isActive = true;
                } else if ($statusTransaksi == 'deny' || $statusTransaksi == 'expire' || $statusTransaksi == 'cancel') {
                    $statusPembayaran = 'Batal';
                    $isActive = false;
                }

                $langganan->update([
                    'status_pembayaran' => $statusPembayaran,
                    'is_active' => $isActive
                ]);

                // Kirim notifikasi ke customer
                \App\Models\Notifikasi::create([
                    'id_user' => $langganan->id_customer,
                    'judul' => 'Langganan Aktif',
                    'pesan' => 'Pembayaran lunas! Paket langganan ' . $langganan->paket->nama_paket . ' Anda kini aktif.',
                    'tipe' => 'notifikasi',
                    'sudah_dibaca' => false,
                ]);

                return response()->json(['success' => true]);
            }

            $pesanan = Pesanan::where('kode_pesanan', $kodePesanan)->first();

            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            // Inisialisasi status default
            $idStatusPesanan = $pesanan->id_status_pesanan;
            $catatan = '';
            $isBaruLunas = false;

            if ($statusTransaksi == 'capture') {
                if ($tipePembayaran == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $idStatusPesanan = 1; // Baru (Challenge)
                        $catatan = 'Pembayaran kartu kredit berstatus challenge';
                    } else {
                        $idStatusPesanan = 2; // Diproses (Sukses)
                        $catatan = 'Pembayaran kartu kredit sukses dan lunas';
                        if ($pesanan->id_status_pesanan == 1) $isBaruLunas = true;
                    }
                }
            } else if ($statusTransaksi == 'settlement') {
                $idStatusPesanan = 2; // Diproses (Lunas)
                $catatan = 'Pembayaran berhasil diselesaikan (settlement)';
                if ($pesanan->id_status_pesanan == 1) $isBaruLunas = true;
            } else if ($statusTransaksi == 'pending') {
                $idStatusPesanan = 1; // Baru (Menunggu Pembayaran)
                $catatan = 'Pembayaran berstatus pending (menunggu)';
            } else if ($statusTransaksi == 'deny' || $statusTransaksi == 'expire' || $statusTransaksi == 'cancel') {
                $idStatusPesanan = 7; // Dibatalkan
                $catatan = 'Pembayaran dibatalkan/kadaluarsa (status: ' . $statusTransaksi . ')';
                
                // Refund poin jika pesanan dibatalkan dan poin pernah digunakan
                if ($pesanan->id_status_pesanan != 7 && $pesanan->poin_digunakan > 0) {
                    $customer = $pesanan->customer;
                    if ($customer) {
                        $customer->poin += $pesanan->poin_digunakan;
                        $customer->save();
                    }
                }
            }

            // Update status pesanan dan metode pembayaran
            $pesanan->update([
                'id_status_pesanan' => $idStatusPesanan,
                'metode_pembayaran' => 'Midtrans (' . ucwords(str_replace('_', ' ', $tipePembayaran)) . ')'
            ]);

            // Beri poin cashback 1% dari subtotal jika baru saja lunas
            if ($isBaruLunas) {
                $customer = $pesanan->customer;
                if ($customer && $pesanan->subtotal > 0) {
                    $poinEarned = intval($pesanan->subtotal * 0.01);
                    if ($poinEarned > 0) {
                        $customer->poin += $poinEarned;
                        $customer->save();

                        \App\Models\Notifikasi::create([
                            'id_user' => $pesanan->id_customer,
                            'judul' => 'Cashback Poin!',
                            'pesan' => 'Hore! Anda mendapatkan cashback ' . number_format($poinEarned, 0, ',', '.') . ' Poin dari pesanan #' . $kodePesanan,
                            'tipe' => 'notifikasi',
                            'sudah_dibaca' => false,
                        ]);
                    }
                }
            }

            // Catat ke riwayat status pesanan
            \App\Models\RiwayatStatusPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_status_pesanan' => $idStatusPesanan,
                'diubah_oleh' => null, // Diubah otomatis oleh webhook sistem
                'catatan' => $catatan ?: 'Status diperbarui otomatis oleh sistem Midtrans',
            ]);

            // Kirim notifikasi ke customer
            \App\Models\Notifikasi::create([
                'id_user' => $pesanan->id_customer,
                'judul' => 'Status Pembayaran Diperbarui',
                'pesan' => 'Status pembayaran untuk pesanan #' . $kodePesanan . ' kini: ' . ($idStatusPesanan == 2 ? 'Lunas (Diproses)' : 'Menunggu / Batal'),
                'tipe' => 'pesanan',
                'id_pesanan' => $pesanan->id_pesanan,
                'sudah_dibaca' => false,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Kesalahan Callback Midtrans: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
