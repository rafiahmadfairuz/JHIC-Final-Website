<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapotSiswa extends Model
{
    /** @use HasFactory<\Database\Factories\RapotSiswaFactory> */
    use HasFactory;
    protected $fillable = ['mapel_id', 'siswa_id', 'nilai'];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
