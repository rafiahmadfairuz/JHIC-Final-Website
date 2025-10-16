<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    /** @use HasFactory<\Database\Factories\MapelFactory> */
    use HasFactory;
    protected $fillable = ['nama_mapel'];

    public function kursuses()
    {
        return $this->hasMany(Kursus::class);
    }

    public function rapotSiswas()
    {
        return $this->hasMany(RapotSiswa::class);
    }
}
