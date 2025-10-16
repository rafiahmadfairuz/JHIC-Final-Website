<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenjualController extends Controller
{
    public function index()
    {
         return view("kwu.penjual.produk");
    }

    public function showProduk()
    {
        return view("kwu.penjual.produk");
    }
    public function showOrder()
    {
        return view("kwu.penjual.pesanan");
    }
}
