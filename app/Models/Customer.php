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

}
