<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'country',
        'region',
        'city',
        'zip_code',
        'address',
        'avatar',
        'password',
        'status',
        'warning_count',
        'is_activated',
        'activation_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [

    ];

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }

}
