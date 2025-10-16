<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    /** @use HasFactory<\Database\Factories\KelasFactory> */
    use HasFactory;
    protected $fillable = ['tingkat', 'jurusan_id', 'urutan_kelas'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
}
