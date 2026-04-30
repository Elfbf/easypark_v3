<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password — EasyPark</title>
</head>

<body style="margin:0;padding:0;background:#F5F7FC;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F5F7FC;padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:520px;">

                    {{-- Header --}}
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#0E2F7A,#1A4BAD);
                                   border-radius:20px 20px 0 0;padding:32px 40px;text-align:center;">
                            <div
                                style="font-size:22px;font-weight:800;color:#ffffff;
                                        letter-spacing:-0.5px;">
                                🅿 EasyPark
                            </div>
                            <div style="font-size:12px;color:rgba(255,255,255,0.65);margin-top:4px;">
                                Sistem Manajemen Parkir — Polije Bondowoso
                            </div>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="background:#ffffff;padding:36px 40px;">

                            <p style="font-size:15px;font-weight:700;color:#181D35;margin:0 0 8px;">
                                Halo, {{ $name }} 👋
                            </p>

                            <p style="font-size:13.5px;color:#4A5175;line-height:1.7;margin:0 0 24px;">
                                Kami menerima permintaan reset password untuk akun EasyPark kamu.
                                Gunakan kode OTP berikut untuk melanjutkan proses pemulihan akun.
                            </p>

                            {{-- OTP Box --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:16px;">
                                <tr>
                                    <td align="center">
                                        <div
                                            style="display:inline-block;background:#E8F0FB;
                                                    border:2px dashed #3B6FD4;border-radius:16px;
                                                    padding:20px 40px;text-align:center;">
                                            <div
                                                style="font-size:11px;font-weight:600;color:#8A93AE;
                                                        text-transform:uppercase;letter-spacing:2px;
                                                        margin-bottom:10px;">
                                                Kode OTP Kamu
                                            </div>
                                            <div
                                                style="font-size:42px;font-weight:800;
                                                        color:#1A4BAD;letter-spacing:14px;
                                                        font-family:monospace;padding:0 8px;">
                                                {{ $otp }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            {{-- Auto-fill button --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/forgot-password?otp=' . $otp) }}"
                                            style="display:inline-block;background:#0E2F7A;
                                                   color:#ffffff;font-size:14px;font-weight:700;
                                                   padding:12px 28px;border-radius:10px;
                                                   text-decoration:none;letter-spacing:0.01em;">
                                            Isi OTP Otomatis →
                                        </a>
                                        <p style="font-size:11px;color:#8A93AE;margin:8px 0 0;">
                                            atau ketik kode di atas secara manual
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Warning --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:24px;">
                                <tr>
                                    <td
                                        style="background:#FFFAEB;border:1px solid #FDE68A;
                                               border-radius:10px;padding:12px 16px;">
                                        <p
                                            style="font-size:12.5px;color:#B54708;
                                                  line-height:1.6;margin:0;">
                                            ⚠️ Kode ini hanya berlaku selama <strong>10 menit</strong>
                                            dan hanya bisa digunakan <strong>satu kali</strong>.
                                            Jangan bagikan kode ini kepada siapapun.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Info --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:24px;">
                                <tr>
                                    <td
                                        style="background:#F5F7FC;border:1px solid #EBEEF5;
                                               border-radius:10px;padding:12px 16px;">
                                        <p
                                            style="font-size:12.5px;color:#4A5175;
                                                  line-height:1.6;margin:0;">
                                            🔒 Jika kamu tidak merasa meminta reset password,
                                            abaikan email ini. Akun kamu tetap aman.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:13px;color:#8A93AE;line-height:1.6;margin:0;">
                                Salam hangat,<br>
                                <strong style="color:#181D35;">Tim EasyPark</strong><br>
                                Politeknik Negeri Jember — Kampus 2 Bondowoso
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="background:#F5F7FC;border-radius:0 0 20px 20px;
                                   border-top:1px solid #EBEEF5;padding:20px 40px;
                                   text-align:center;">
                            <p style="font-size:11.5px;color:#8A93AE;margin:0;line-height:1.7;">
                                Email ini dikirim otomatis oleh sistem EasyPark.<br>
                                Mohon tidak membalas email ini.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>
