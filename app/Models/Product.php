<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
     use HasFactory;

      protected $fillable = [
        'store_id',
        'name',
        'description',
        'image_path',
        'price',
        'min_price',
    ];
}
