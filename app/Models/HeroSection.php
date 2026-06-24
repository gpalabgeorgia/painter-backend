<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HeroSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Он автоматически превратит "public/img/hero/file.jpg" в "img/hero/file.jpg"
    public function getCenterImageAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return Str::after($value, 'public/');
    }
}
