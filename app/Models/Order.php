<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $fillable = ['pembeli_id', 'total', 'status'];
    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
