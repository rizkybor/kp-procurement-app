<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

    <table width="100%" bgcolor="#f4f4f4" cellpadding="0" cellspacing="0" style="padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600" bgcolor="#ffffff" cellpadding="0" cellspacing="0" style="border-radius: 10px; padding: 30px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);">
                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <img src="{{ $logo_url }}" alt="Prime Billing Service" width="150" style="display:block;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td align="center" style="color:#333333; font-size:22px; font-weight:bold; padding-bottom: 10px;">
                            Hello, {{ $notifiable->name }}!
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td align="center" style="color:#555555; font-size:16px; line-height:1.5; padding-bottom: 20px;">
                            Kami menerima permintaan untuk mereset password akun Anda.
                        </td>
                    </tr>

                    <!-- Button -->
                    <tr>
                        <td align="center" style="padding: 30px 0;">
                            <a href="{{ route('password.reset', ['token' => $token]) }}"
                               style="background-color:#007bff; color:white; padding:14px 25px; text-decoration:none; font-size:16px; font-weight:bold; border-radius:5px; display:inline-block;">
                                Reset Password
                            </a>
                        </td>
                    </tr>

                    <!-- Note -->
                    <tr>
                        <td align="center" style="color:#555555; font-size:14px; line-height:1.5;">
                            Jika Anda tidak meminta reset password, abaikan email ini.
                        </td>
                    </tr>

                    <!-- Thank You -->
                    <tr>
                        <td align="center" style="color:#333333; font-size:14px; font-weight:600; padding-top: 15px;">
                            Terima kasih telah menggunakan layanan kami!
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="color:#888888; font-size:13px; padding-top:30px;">
                            Salam, <br><strong>Tim Support PT. Karya Prima Usahatama</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>