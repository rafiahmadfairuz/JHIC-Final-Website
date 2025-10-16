<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MelamarPekerjaan extends Model
{
    /** @use HasFactory<\Database\Factories\MelamarPekerjaanFactory> */
    use HasFactory;
    protected $fillable = ['pekerjaan_id', 'pelamar_id', 'berkas_yang_dibutuhkan', 'status'];
    public function pekerjaan()
    {
        return $this->belongsTo(Pekerjaan::class);
    }
    public function pelamar()
    {
        return $this->belongsTo(User::class, 'pelamar_id');
    }
}
