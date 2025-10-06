<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ColorProduct extends Model
{
    use HasFactory;
    protected $table = 'color_product';

    protected $fillable = [
        'product_id',
        'color_id',
    ];
}
