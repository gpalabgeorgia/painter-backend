<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['translatable_type', 'translatable_id', 'field', 'lang_code', 'value'];

    // Указываем, что модель может привязываться к любой другой сущности
    public function translatable()
    {
        return $this->morphTo();
    }
}
