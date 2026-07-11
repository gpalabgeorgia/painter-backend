<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение для адреса и статуса
    protected $fillable = [
        'customer_id',
        'delivery_address',
        'status',
    ];

    /**
     * Связь: Заказ принадлежит конкретному покупателю
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
