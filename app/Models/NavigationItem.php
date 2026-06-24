<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    use HasFactory;

    // Разрешаем массовое заполнение для всех полей таблицы
    protected $guarded = [];
}
