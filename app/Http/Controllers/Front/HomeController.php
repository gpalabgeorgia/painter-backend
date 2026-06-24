<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Отдает файл resources/views/pages/home.blade.php
        return view('pages.home');
    }
}
