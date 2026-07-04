<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'product_id', 'quantity'];

    // Связь с продуктом, чтобы потом легко доставать имя, цену и фото в корзине
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
