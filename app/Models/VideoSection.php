<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VideoSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Превращает "public/video/file.mp4" в "video/file.mp4"
    public function getVideoUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return Str::after($value, 'public/');
    }

    // Превращает "public/img/video/cover.jpg" in "img/video/cover.jpg"
    public function getVideoCoverAttribute($value)
    {
        if (!$value) {
            return null;
        }
        return Str::after($value, 'public/');
    }
}
