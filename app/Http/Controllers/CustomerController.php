<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuJus;

class CustomerController extends Controller
{
    public function landing()
    {
        return view('customer.landing');
    }

    public function beranda()
    {
        $menus = MenuJus::with('kategori')->get();
        
        return view('customer.beranda', compact('menus'));
    }

    public function keranjang()
    {
        return view('customer.keranjang');
    }

    public function checkout()
    {
        return view('customer.checkout');
    }

    public function tracking()
    {
        return view('customer.tracking');
    }
}