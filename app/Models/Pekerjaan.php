<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    /** @use HasFactory<\Database\Factories\PekerjaanFactory> */
    use HasFactory;
    protected $fillable = ['admin_bkk_id', 'perusahaan_id', 'judul', 'deskripsi', 'syarat', 'batas', 'lokasi', 'poster', 'status'];
    public function adminBkk()
    {
        return $this->belongsTo(User::class, 'admin_bkk_id');
    }
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
    public function pelamar()
    {
        return $this->hasMany(MelamarPekerjaan::class);
    }
}
