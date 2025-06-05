<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;

class LapanganController extends Controller {
    public function index() {
        $lapangans = Lapangan::all();
        return view('price-list', compact('lapangans'));
    }
}

