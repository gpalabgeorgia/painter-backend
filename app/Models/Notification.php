<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'title', 'message', 'type', 'is_read', 'parent_id', 'sender'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
