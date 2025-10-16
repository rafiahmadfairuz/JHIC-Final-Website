<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgePencapaianSiswa extends Model
{
    /** @use HasFactory<\Database\Factories\BadgePencapaianSiswaFactory> */
    use HasFactory;
    protected $fillable = ['badge_pencapaian_id', 'siswa_id'];

    public function badgePencapaian()
    {
        return $this->belongsTo(BadgePencapaian::class, 'badge_pencapaian_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
