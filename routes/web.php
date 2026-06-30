<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MitraController;

Route::get('/', [CustomerController::class, 'landing'])->name('beranda');
Route::get('/menu', [CustomerController::class, 'beranda'])->name('menu');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/kelola-menu', [AdminController::class, 'kelolaMenu'])->name('kelola-menu');
    Route::post('/kelola-menu', [AdminController::class, 'storeMenu'])->name('menu.store');
    Route::put('/kelola-menu/{id}', [AdminController::class, 'updateMenu'])->name('menu.update');
    Route::delete('/kelola-menu/{id}', [AdminController::class, 'destroyMenu'])->name('menu.destroy');
    
    Route::get('/pesanan', [AdminController::class, 'pesananMasuk'])->name('pesanan');
    
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
});

Route::middleware(['auth', 'isCustomer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/profil', [CustomerController::class, 'profil'])->name('profil');
    Route::get('/alamat', [CustomerController::class, 'alamat'])->name('alamat');
    
    Route::get('/keranjang', [CustomerController::class, 'keranjang'])->name('keranjang');
    Route::post('/keranjang/add', [CustomerController::class, 'addToCart'])->name('keranjang.add');
    
    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/proses', [CustomerController::class, 'prosesCheckout'])->name('checkout.proses');
    
    Route::get('/tracking', [CustomerController::class, 'tracking'])->name('tracking');
    Route::get('/riwayat-pesanan', [CustomerController::class, 'riwayatPesanan'])->name('riwayat');
});

Route::middleware(['auth', 'isPenjual'])->prefix('dapur')->name('dapur.')->group(function () {
    Route::get('/antrian', [MitraController::class, 'antrianDapur'])->name('antrian');
    Route::put('/update-status/{id_pesanan}', [MitraController::class, 'updateStatusPesanan'])->name('update-status');
});

Route::middleware(['auth', 'isDriver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/pengantaran', [MitraController::class, 'listDelivery'])->name('pengantaran');
    Route::put('/ambil-pesanan/{id_pesanan}', [MitraController::class, 'ambilPesanan'])->name('ambil-pesanan');
    Route::put('/selesai-antar/{id_pesanan}', [MitraController::class, 'selesaiAntar'])->name('selesai-antar');
});