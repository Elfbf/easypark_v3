<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Form input email
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
        ]);

        $input = $request->email;

        // Cari user by email atau NIM
        $user = User::where('email', $input)
            ->orWhere('nim_nip', $input)
            ->first();

        if (!$user) {
            return response()->json([
                'errors' => ['email' => ['Email atau NIM tidak ditemukan dalam sistem.']]
            ], 422);
        }

        // Hapus OTP lama
        PasswordResetOtp::where('email', $user->email)->delete();

        // Buat OTP baru
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::create([
            'email'      => $user->email,
            'otp'        => $otp,
            'expired_at' => now()->addMinutes(10),
            'is_used'    => false,
        ]);

        Mail::to($user->email)->send(new OtpMail($otp, $user->name));

        session(['otp_email' => $user->email]);

        return response()->json(['message' => 'OTP berhasil dikirim.']);
    }
}
