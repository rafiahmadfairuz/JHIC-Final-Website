<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    /** @use HasFactory<\Database\Factories\PerusahaanFactory> */
    use HasFactory;
    protected $fillable = ['nama', 'alamat', 'jenis_perusahaan'];
    public function pekerjaan()
    {
        return $this->hasMany(Pekerjaan::class);
    }
}
