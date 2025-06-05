<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('layouts.home'); // Pastikan ini sesuai dengan file di views/home.blade.php
    }
}
