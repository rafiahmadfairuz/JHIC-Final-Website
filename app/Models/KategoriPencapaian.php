<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPencapaian extends Model
{
    /** @use HasFactory<\Database\Factories\KategoriPencapaianFactory> */
    use HasFactory;
    protected $fillable = ['nama_pencapaian'];

    public function badgePencapaian()
    {
        return $this->hasMany(BadgePencapaian::class);
    }
}
