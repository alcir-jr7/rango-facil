<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProductCategory;
use App\Models\CartItem;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'description',
        'image_path',
        'price',
        'min_price',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
