<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    /** @use HasFactory<\Database\Factories\JawabanSiswaFactory> */
    use HasFactory;
    protected $fillable = ['soal_id', 'siswa_id', 'jawaban_dipilih', 'nilai'];

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
