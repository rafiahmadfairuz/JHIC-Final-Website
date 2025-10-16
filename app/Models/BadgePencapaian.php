<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgePencapaian extends Model
{
    /** @use HasFactory<\Database\Factories\BadgePencapaianFactory> */
    use HasFactory;
    protected $fillable = ['nama_pencapaian', 'syarat', 'kategori_pencapaian_id', 'gambar'];
    protected $casts = [
        'syarat' => 'array',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPencapaian::class, 'kategori_pencapaian_id');
    }

    public function badgeSiswa()
    {
        return $this->hasMany(BadgePencapaianSiswa::class);
    }
    public function kategoriPencapaian()
    {
        return $this->belongsTo(KategoriPencapaian::class, 'kategori_pencapaian_id');
    }
}
