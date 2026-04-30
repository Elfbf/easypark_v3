<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Form input OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $email = session('otp_email');

        if (!$email) {
            return response()->json(['message' => 'Sesi telah berakhir, silakan ulangi.'], 422);
        }

        $otpRecord = PasswordResetOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->latest()
            ->first();

        if (!$otpRecord || !$otpRecord->isValid()) {
            return response()->json(['message' => 'Kode OTP tidak valid atau sudah kadaluarsa.'], 422);
        }

        $otpRecord->update(['is_used' => true]);
        session(['otp_verified' => true]);

        // ✅ return JSON
        return response()->json(['message' => 'OTP valid.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $email = session('otp_email');

        if (!$email || !session('otp_verified')) {
            return response()->json(['message' => 'Sesi tidak valid, silakan ulangi.'], 422);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan.'], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        session()->forget(['otp_email', 'otp_verified']);

        // ✅ return JSON
        return response()->json(['message' => 'Password berhasil diubah.']);
    }
}
