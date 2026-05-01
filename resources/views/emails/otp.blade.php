<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Reset Password — EasyPark</title>
</head>

<body style="margin:0;padding:0;background:#F0F4FF;font-family:Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F0F4FF;padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:520px;">

                    {{-- Header --}}
                    <tr>
                        <td
                            style="background:linear-gradient(135deg,#071C52 0%,#0E2F7A 50%,#1A4BAD 100%);
                                   border-radius:20px 20px 0 0;padding:36px 40px;text-align:center;">

                            {{-- Logo --}}
                            <div style="margin-bottom:16px;">
                                <div
                                    style="display:inline-block;background:rgba(255,255,255,0.12);
                                            border:1px solid rgba(255,255,255,0.2);
                                            border-radius:14px;padding:10px 18px;">
                                    <span
                                        style="font-size:24px;font-weight:800;color:#ffffff;
                                                 letter-spacing:-0.5px;">🅿
                                        EasyPark</span>
                                </div>
                            </div>

                            <div style="font-size:12px;color:rgba(255,255,255,0.6);margin-bottom:24px;">
                                Sistem Manajemen Parkir — Polije Bondowoso
                            </div>

                            {{-- Step indicator --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                {{-- Step 1 done --}}
                                                <td align="center" style="width:60px;">
                                                    <div
                                                        style="width:28px;height:28px;border-radius:50%;
                                                                background:#E8B740;margin:0 auto 4px;
                                                                font-size:13px;font-weight:800;color:#071C52;
                                                                line-height:28px;text-align:center;">
                                                        ✓</div>
                                                    <div
                                                        style="font-size:10px;color:rgba(255,255,255,0.7);font-weight:600;">
                                                        Identitas</div>
                                                </td>
                                                {{-- Line done --}}
                                                <td style="width:40px;padding-bottom:18px;">
                                                    <div style="height:2px;background:#E8B740;border-radius:2px;"></div>
                                                </td>
                                                {{-- Step 2 active --}}
                                                <td align="center" style="width:60px;">
                                                    <div
                                                        style="width:28px;height:28px;border-radius:50%;
                                                                background:#fff;margin:0 auto 4px;
                                                                font-size:13px;font-weight:800;color:#0E2F7A;
                                                                line-height:28px;text-align:center;">
                                                        2</div>
                                                    <div style="font-size:10px;color:#fff;font-weight:700;">Kode OTP
                                                    </div>
                                                </td>
                                                {{-- Line pending --}}
                                                <td style="width:40px;padding-bottom:18px;">
                                                    <div
                                                        style="height:2px;background:rgba(255,255,255,0.25);border-radius:2px;">
                                                    </div>
                                                </td>
                                                {{-- Step 3 --}}
                                                <td align="center" style="width:60px;">
                                                    <div
                                                        style="width:28px;height:28px;border-radius:50%;
                                                                background:rgba(255,255,255,0.18);margin:0 auto 4px;
                                                                font-size:13px;font-weight:800;color:rgba(255,255,255,0.5);
                                                                line-height:28px;text-align:center;">
                                                        3</div>
                                                    <div style="font-size:10px;color:rgba(255,255,255,0.45);">Password
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="background:#ffffff;padding:36px 40px;">

                            <p style="font-size:15px;font-weight:700;color:#181D35;margin:0 0 6px;">
                                Halo, {{ $name }} 👋
                            </p>

                            <p style="font-size:13.5px;color:#4A5175;line-height:1.7;margin:0 0 28px;">
                                Kami menerima permintaan reset password untuk akun EasyPark kamu.
                                Gunakan kode OTP berikut untuk melanjutkan proses pemulihan akun.
                            </p>

                            {{-- OTP Box --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:8px;">
                                <tr>
                                    <td align="center">
                                        <div
                                            style="display:inline-block;
                                                    background:linear-gradient(135deg,#E8F0FB,#C0D3F5);
                                                    border:2px dashed #3B6FD4;border-radius:18px;
                                                    padding:24px 48px;text-align:center;">
                                            <div
                                                style="font-size:11px;font-weight:700;color:#4A5272;
                                                        text-transform:uppercase;letter-spacing:3px;margin-bottom:12px;">
                                                🔐 Kode OTP Kamu
                                            </div>
                                            <div
                                                style="font-size:46px;font-weight:800;color:#0E2F7A;
                                                        letter-spacing:16px;font-family:monospace;padding:0 8px;">
                                                {{ $otp }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            {{-- Timer info --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <div style="font-size:12px;color:#8A93AE;margin-bottom:8px;">
                                            ⏱ Berlaku selama <strong style="color:#0E2F7A;">10 menit</strong>
                                        </div>
                                        <div
                                            style="background:#D4D9E8;border-radius:4px;height:4px;
                                                    width:200px;overflow:hidden;margin:0 auto;">
                                            <div
                                                style="width:100%;height:100%;
                                                        background:linear-gradient(90deg,#0E2F7A,#3B6FD4);
                                                        border-radius:4px;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            {{-- Auto-fill button --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:28px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/forgot-password?otp=' . $otp) }}"
                                            style="display:inline-block;
                                                   background:linear-gradient(135deg,#0E2F7A,#1A4BAD);
                                                   color:#ffffff;font-size:14px;font-weight:700;
                                                   padding:14px 32px;border-radius:12px;
                                                   text-decoration:none;letter-spacing:0.02em;">
                                            ⚡ Isi OTP Otomatis
                                        </a>
                                        <p style="font-size:11px;color:#B3BBCC;margin:10px 0 0;">
                                            atau ketik kode di atas secara manual
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Divider --}}
                            <div style="border-top:1px solid #EBEEF5;margin-bottom:20px;"></div>

                            {{-- Warning --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:12px;">
                                <tr>
                                    <td
                                        style="background:#FFFAEB;border:1px solid #FDE68A;
                                               border-radius:10px;padding:12px 16px;">
                                        <p style="font-size:12.5px;color:#B54708;line-height:1.6;margin:0;">
                                            ⚠️ Kode ini hanya berlaku selama <strong>10 menit</strong>
                                            dan hanya bisa digunakan <strong>satu kali</strong>.
                                            Jangan bagikan kode ini kepada siapapun.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Info --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:12px;">
                                <tr>
                                    <td
                                        style="background:#F5F7FC;border:1px solid #EBEEF5;
                                               border-radius:10px;padding:12px 16px;">
                                        <p style="font-size:12.5px;color:#4A5175;line-height:1.6;margin:0;">
                                            🔒 Jika kamu tidak merasa meminta reset password,
                                            abaikan email ini. Akun kamu tetap aman.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Device info --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom:28px;">
                                <tr>
                                    <td
                                        style="background:#FEF2F2;border:1px solid #FED7D7;
                                               border-radius:10px;padding:12px 16px;">
                                        <p style="font-size:12px;color:#DC2626;font-weight:700;margin:0 0 6px;">
                                            📍 Detail permintaan:
                                        </p>
                                        <p style="font-size:12px;color:#4A5175;margin:0;line-height:1.8;">
                                            🕐 Waktu&nbsp; : <strong>{{ $meta['time'] ?? '-' }}</strong><br>
                                            🌐 IP&nbsp;&nbsp;&nbsp;&nbsp; :
                                            <strong>{{ $meta['ip'] ?? '-' }}</strong><br>
                                            📧 Email&nbsp; : <strong>{{ $meta['email'] ?? '-' }}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Sign off --}}
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td valign="middle">
                                        <p style="font-size:13px;color:#8A93AE;line-height:1.6;margin:0;">
                                            Salam hangat,<br>
                                            <strong style="color:#181D35;">Tim EasyPark</strong><br>
                                            Politeknik Negeri Jember — Kampus 2 Bondowoso
                                        </p>
                                    </td>
                                    <td align="right" valign="middle">
                                        <div
                                            style="background:#E8F0FB;border-radius:10px;
                                                    padding:10px 14px;display:inline-block;">
                                            <span style="font-size:22px;font-weight:800;color:#0E2F7A;">🅿</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="background:#F0F4FF;border-radius:0 0 20px 20px;
                                   border-top:1px solid #D4D9E8;padding:20px 40px;text-align:center;">
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
