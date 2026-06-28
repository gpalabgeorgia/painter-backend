<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasFactory;

    protected $fillable = [
        's1_title',
        's1_image',
        's1_subtitle',
        's1_text',

        // Поля Секции 2
        's2_image',
        's2_quote',
        's2_signature',
        's2_name',

        // Поля Секции 3
        's3_title',
        's3_logos',
        's3_text',
    ];
    protected $casts = [
        's3_logos' => 'array', // Это критически важно для корректной работы мультизагрузки!
    ];
}
