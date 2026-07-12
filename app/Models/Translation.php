<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'lang_code', 'value'];

    // Переводы у нас хранятся строками, но для Filament v2 нам
    // будет проще работать, если мы сделаем связь
    public function values()
    {
        return $this->hasMany(Translation::class, 'key', 'key');
    }
}
