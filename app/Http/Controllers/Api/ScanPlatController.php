<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ScanPlatController extends Controller
{
    // Python kirim ke sini
    public function terima(Request $request)
    {
        $token = "KIOSK-PLAT"; // token fixed
        $plat = $request->plat;

        $history = Cache::get('plat_history_' . $token, []);
        array_push($history, $plat);
        if (count($history) > 5) array_shift($history);
        Cache::put('plat_history_' . $token, $history, 60);

        $counts = array_count_values($history);
        arsort($counts);
        $best = array_key_first($counts);
        $bestCount = $counts[$best];

        return response()->json([
            "status" => $bestCount >= 3 ? "confident" : "collecting",
            "plat" => $best,
            "muncul" => $bestCount,
        ]);
    }
}