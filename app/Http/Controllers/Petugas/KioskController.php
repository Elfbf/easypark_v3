<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class KioskController extends Controller
{
    public function index(): View
    {
        return view('petugas.kiosk.index');
    }
}