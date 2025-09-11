<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'user_id', 'products', 'total_price', 'status'];

    protected $casts = [
        'products' => 'array', // automatically cast JSON to array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($orders) {

            $orders->order_number = 'OR' . rand(1000, 9999);
        });
    }
}
