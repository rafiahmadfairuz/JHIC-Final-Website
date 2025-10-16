<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackPerilaku extends Model
{
    /** @use HasFactory<\Database\Factories\TrackPerilakuFactory> */
    use HasFactory;
    protected $fillable = ['siswa_id', 'guru_id', 'catatan', 'tanggal'];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
