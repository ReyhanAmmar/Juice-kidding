<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function antrianDapur()
    {
        return view('mitra.antrian-dapur');
    }

    public function pengantaranDriver()
    {
        return view('mitra.list-delivery');
    }
}