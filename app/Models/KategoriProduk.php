<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriProdukFactory> */
    use HasFactory;
    protected $fillable = ['nama'];
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
