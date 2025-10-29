<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Toko extends Model
{
    /** @use HasFactory<\Database\Factories\TokoFactory> */
    use HasFactory;

    protected $fillable = ['nama_toko', 'deskripsi'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'toko_users');
    }

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class);
    }
}
