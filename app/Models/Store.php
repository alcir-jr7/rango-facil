<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /** @use HasFactory<\Database\Factories\StoreFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'image',
        'is_open',
        'auto_confirm_orders',
        'owner_id',
    ];

    /**
     * Get the owner of the store.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
     public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }
}
