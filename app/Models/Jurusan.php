<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    /** @use HasFactory<\Database\Factories\JurusanFactory> */
    use HasFactory;
    protected $fillable = ['nama_jurusan', 'gambar_jurusan'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}
