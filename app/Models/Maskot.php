<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maskot extends Model
{
    /** @use HasFactory<\Database\Factories\MaskotFactory> */
    use HasFactory;
    protected $guarded =['id'];
}
