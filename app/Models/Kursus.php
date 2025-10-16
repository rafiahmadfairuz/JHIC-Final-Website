<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    /** @use HasFactory<\Database\Factories\KursusFactory> */
    use HasFactory;
    protected $fillable = ['nama_kursus', 'mapel_id', 'guru_id', 'kelas_id', 'isi_kursus'];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
    public function kursus()
    {
        return $this->belongsTo(Kursus::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class, 'kelas_id');
    }
}
