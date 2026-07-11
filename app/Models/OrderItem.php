<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_title',
        'price',
    ];

    // Указываем, что позиция принадлежит заказу
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Указываем связь с самой картиной
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
