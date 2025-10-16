<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;
    protected $fillable = ['nama', 'harga', 'stok', 'gambar', 'deskripsi', 'toko_id', 'kategori_id'];
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'produk_id');
    }
}
