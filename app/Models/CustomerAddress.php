<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'region',
        'city',
        'zip_code',
        'address'
    ];

    // Обратная связь: адрес принадлежит клиенту
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
