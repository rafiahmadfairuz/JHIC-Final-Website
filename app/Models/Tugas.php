<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    /** @use HasFactory<\Database\Factories\TugasFactory> */
    use HasFactory;
    protected $fillable = ['kursus_id', 'nama_tugas', 'batas_pengumpulan'];
    protected $casts = [
        'batas_pengumpulan' => 'datetime',
    ];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class);
    }

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }

    public function mapel()
    {
        return $this->hasOneThrough(Mapel::class, Kursus::class, 'id', 'id', 'kursus_id', 'mapel_id');
    }
}
