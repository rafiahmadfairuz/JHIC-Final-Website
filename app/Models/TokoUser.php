<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokoUser extends Model
{
    /** @use HasFactory<\Database\Factories\TokoUserFactory> */
    use HasFactory;
    protected $fillable = ['toko_id', 'user_id'];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
