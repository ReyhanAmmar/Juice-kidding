<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MitraController;

Route::get('/', [CustomerController::class, 'landing'])->name('beranda');
Route::get('/menu', [CustomerController::class, 'beranda'])->name('menu');
Route::get('/menu/{id}', [CustomerController::class, 'detailMenu'])->name('menu.detail');
Route::get('/menu/{id}/kustomisasi', [CustomerController::class, 'getKustomisasiData'])->name('menu.kustomisasi');

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PaymentCallbackController;

Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.detail');
Route::post('/midtrans/callback', [PaymentCallbackController::class, 'handleNotification'])->name('midtrans.callback');

// Login & register — tanpa guest middleware agar user bisa ganti akun
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');

// Google Auth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\MenuJusController;

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Kustomisasi Menu
    Route::resource('tipe-opsi', \App\Http\Controllers\TipeOpsiController::class);
    Route::post('tipe-opsi/reorder', [\App\Http\Controllers\TipeOpsiController::class, 'reorder'])->name('tipe-opsi.reorder');
    Route::resource('opsi-kustomisasi', \App\Http\Controllers\OpsiKustomisasiController::class);
    Route::post('opsi-kustomisasi/reorder', [\App\Http\Controllers\OpsiKustomisasiController::class, 'reorder'])->name('opsi-kustomisasi.reorder');

    // CRUD Racik Sendiri (Cairan Base, Bahan, Tambahan)
    Route::resource('racik-opsi', \App\Http\Controllers\RacikOpsiController::class)->except(['show']);
    Route::post('racik-opsi/reorder', [\App\Http\Controllers\RacikOpsiController::class, 'reorder'])->name('racik-opsi.reorder');

    Route::resource('kategori', KategoriMenuController::class)->except(['show']);
    Route::resource('menu', MenuJusController::class)->except(['show']);
    Route::resource('paket-langganan', \App\Http\Controllers\PaketLanggananController::class);
    Route::resource('artikel', \App\Http\Controllers\AdminArtikelController::class);

    Route::get('/pesanan', [AdminController::class, 'pesananMasuk'])->name('pesanan');
    Route::put('/pesanan/{id_pesanan}/status', [AdminController::class, 'updateStatus'])->name('pesanan.status');
    Route::put('/pesanan/{id_pesanan}/assign-driver', [AdminController::class, 'assignDriver'])->name('pesanan.assign-driver');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::post('/langganan/generate-daily', [AdminController::class, 'generateDailySubscriptionOrders'])->name('langganan.generate');

    Route::get('/pengaturan', [AdminController::class, 'pengaturan'])->name('pengaturan');
    Route::put('/pengaturan', [AdminController::class, 'updatePengaturan'])->name('pengaturan.update');

    // CRUD Alamat Toko (dipakai oleh modal di halaman pengaturan)
    Route::post('/alamat-toko', [AdminController::class, 'alamatTokoStore'])->name('alamat-toko.store');
    Route::put('/alamat-toko/{id}', [AdminController::class, 'alamatTokoUpdate'])->name('alamat-toko.update');
    Route::delete('/alamat-toko/{id}', [AdminController::class, 'alamatTokoDestroy'])->name('alamat-toko.destroy');
});

Route::middleware(['auth', 'isCustomer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/profil', [CustomerController::class, 'profil'])->name('profil');
    Route::put('/profil', [CustomerController::class, 'updateProfil'])->name('profil.update');
    Route::put('/profil/password', [CustomerController::class, 'updatePassword'])->name('profil.password');
    Route::get('/alamat', [CustomerController::class, 'alamat'])->name('alamat');
    Route::post('/alamat', [CustomerController::class, 'simpanAlamat'])->name('alamat.simpan');
    Route::delete('/alamat/{id}', [CustomerController::class, 'hapusAlamat'])->name('alamat.hapus');
    
    Route::get('/keranjang', [CustomerController::class, 'keranjang'])->name('keranjang');
    Route::post('/keranjang/add', [CustomerController::class, 'addToCart'])->name('keranjang.add');
    Route::put('/keranjang/update/{id}', [CustomerController::class, 'updateCart'])->name('keranjang.update');
    Route::delete('/keranjang/remove/{id}', [CustomerController::class, 'removeFromCart'])->name('keranjang.remove');
    
    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/proses', [CustomerController::class, 'prosesCheckout'])->name('checkout.proses');
    
    Route::get('/tracking', [CustomerController::class, 'tracking'])->name('tracking');
    Route::get('/riwayat-pesanan', [CustomerController::class, 'riwayatPesanan'])->name('riwayat');
    
    // Rute langganan customer
    Route::get('/langganan/checkout/{id}', [CustomerController::class, 'checkoutLangganan'])->name('langganan.checkout');
    Route::post('/langganan/proses', [CustomerController::class, 'prosesPembelianLangganan'])->name('langganan.proses');
});

Route::get('/langganan', [CustomerController::class, 'halamanLangganan'])->name('langganan.index');
Route::get('/customer/racik', [CustomerController::class, 'racik'])->name('customer.racik');

Route::middleware(['auth', 'isPenjual'])->prefix('dapur')->name('dapur.')->group(function () {
    Route::get('/dashboard', [MitraController::class, 'dashboardDapur'])->name('dashboard');
    Route::get('/dashboard/json', [MitraController::class, 'dashboardDapurJson'])->name('dashboard.json');
    Route::get('/antrian', [MitraController::class, 'antrianDapur'])->name('antrian');
    Route::get('/antrian/json', [MitraController::class, 'antrianDapurJson'])->name('antrian.json');
    Route::get('/pesanan/{id_pesanan}', [MitraController::class, 'detailPesanan'])->name('pesanan.detail');
    Route::put('/update-status/{id_pesanan}', [MitraController::class, 'updateStatusPesanan'])->name('update-status');
    Route::get('/stok', [MitraController::class, 'stokDapur'])->name('stok');
    Route::put('/stok/{id_menu}/update', [MitraController::class, 'updateStok'])->name('stok.update');
    Route::get('/riwayat', [MitraController::class, 'riwayatDapur'])->name('riwayat');
    Route::get('/riwayat/json', [MitraController::class, 'riwayatDapurJson'])->name('riwayat.json');
});

Route::middleware(['auth', 'isDriver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/pengantaran', [MitraController::class, 'listDelivery'])->name('pengantaran');
    Route::put('/ambil-pesanan/{id_pesanan}', [MitraController::class, 'ambilPesanan'])->name('ambil-pesanan');
    Route::put('/selesai-antar/{id_pesanan}', [MitraController::class, 'selesaiAntar'])->name('selesai-antar');
});