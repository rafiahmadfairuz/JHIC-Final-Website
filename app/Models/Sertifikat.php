<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    /** @use HasFactory<\Database\Factories\SertifikatFactory> */
    use HasFactory;
    protected $fillable = ['profile_id', 'judul_prestasi', 'file_sertif'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
