<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    use HasFactory;
    protected $fillable = [
        'is_active',
        'image',
        'date_range',
        'title',
        'description',
        'link',
    ];
}
