<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Order;
use App\Models\Produk;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\KategoriProduk;

class KwuController extends Controller
{
    public function showBeranda()
    {
        return view("kwu.landing.index");
    }

    public function showDashboard()
    {
        $totalProduk = Produk::count();
        $totalKategori = KategoriProduk::count();
        $totalOrder = Order::count();
        $totalToko = Toko::count();

        $latestProduk = Produk::with('kategori', 'toko')->latest()->take(5)->get();
        $latestOrder = Order::with('pembeli')->latest()->take(5)->get();

        return view('kwu.dashboard.index', compact(
            'totalProduk',
            'totalKategori',
            'totalOrder',
            'totalToko',
            'latestProduk',
            'latestOrder'
        ));
    }

    public function showToko()
    {
        $tokos = Toko::paginate(10);
        return view("kwu.dashboard.toko", ['tokos' => $tokos]);
    }

    public function showKategoriproduk()
    {
        return view("kwu.dashboard.kategori-produk");
    }

    public function showOrderproduk(Request $request)
    {
        $query = Order::with(['pembeli', 'items.produk']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);
        return view("kwu.dashboard.order", ['orders' => $orders]);
    }

    public function showDetailproduk($id)
    {
        $produk = Produk::with(['toko', 'kategori'])->findOrFail($id);

        return view("kwu.landing.detail-produk", ['produk' => $produk]);
    }

    public function showDetailtoko($id)
    {
        $toko = Toko::with('produks')->findOrFail($id);

        return view("kwu.landing.detail-toko", ['toko' => $toko]);
    }

    public function showProfil()
    {
        $user = auth()->user();

        $orders = Order::with(['items.produk'])
            ->where('pembeli_id', $user->id)
            ->get();

        return view("kwu.landing.detail-profil", ['orders' => $orders]);
    }

    public function checkout(Request $request, Produk $produk)
    {
        $request->validate([
            'qty' => 'required|integer|min:1'
        ]);

        $qty = $request->qty;

        if ($produk->stok < $qty) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $total = $produk->harga * $qty;

        $order = Order::create([
            // 'pembeli_id' => auth()->id(),
            'pembeli_id' => 1,
            'total' => $total,
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'produk_id' => $produk->id,
            'qty' => $qty,
        ]);

        $produk->decrement('stok', $qty);

        return redirect()->route('landing.kwu.transaksi', $order->id)->with('success', 'Pesanan berhasil dibuat!');
    }

    public function showTransaksi($id)
    {
        $order = Order::with(['items.produk'])
            ->where('pembeli_id', 1)
            ->findOrFail($id);

        return view('kwu.landing.transaksi', compact('order'));
    }


}
