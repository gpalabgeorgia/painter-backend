<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExhibitionHeader extends Model
{
    use HasFactory;

    protected $fillable = ['main_title', 'subtitle'];
}
