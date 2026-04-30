<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $activeUsers = User::where('is_active', true)->count();

        return view('landing.index', compact('activeUsers'));
    }
}