<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    protected static function booted()
    {
        static::creating(function ($product) {
            // Example: automatically assign a SKU
            $product->product_id = 'P' . rand(10000, 99999);
        });
    }
}
