<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /** @use HasFactory<\Database\Factories\ProfileFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'nama_lengkap', 'foto', 'kelas', 'angkatan', 'alamat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
