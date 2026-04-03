<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Fridah's Spice</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">

    <tr>
        <td style="background:#16a34a; padding:30px; text-align:center; color:white;">
            <h1 style="margin:0;">Welcome to Fridah's Spice</h1>
        </td>
    </tr>

    <tr>
        <td style="padding:30px; color:#333;">
            <h2>Hello {{ $user->firstname }},</h2>

            <p>
                We’re excited to have you join the Fridah’s Spice family!
            </p>

            <p>
                Discover premium spices, bold flavors, and fast delivery straight to your doorstep.
            </p>

            <div style="text-align:center; margin:30px 0;">
                <a href="{{ url('/') }}"
                   style="background:#16a34a; color:white; padding:12px 24px; text-decoration:none; border-radius:5px;">
                    Start Shopping
                </a>
            </div>

            <p>
                If you have any questions, feel free to reply to this email.
            </p>

            <p>
                Warm regards,<br>
                <strong>Fridah's Spice Team</strong>
            </p>
        </td>
    </tr>

    <tr>
        <td style="background:#f4f4f4; padding:20px; text-align:center; font-size:12px; color:#777;">
            © {{ date('Y') }} Fridah's Spice. All rights reserved.
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>