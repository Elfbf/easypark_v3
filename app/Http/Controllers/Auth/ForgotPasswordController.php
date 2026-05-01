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

        // Meta info untuk email
        $meta = [
            'ip'    => $request->ip(),
            'time'  => now()->timezone('Asia/Jakarta')->format('d M Y, H:i') . ' WIB',
            'email' => $this->maskEmail($user->email),
        ];

        Mail::to($user->email)->send(new OtpMail($otp, $user->name, $meta));

        session(['otp_email' => $user->email]);

        return response()->json(['message' => 'OTP berhasil dikirim.']);
    }

    // Sensor email → e***@gmail.com
    private function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email);
        $masked = substr($local, 0, 1) . str_repeat('*', max(3, strlen($local) - 1));
        return $masked . '@' . $domain;
    }
}