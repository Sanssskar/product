<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Update – {{ ucfirst($order->status) }}</title>
</head>

<body style="margin:0; padding:0; font-family: 'Helvetica Neue', Arial, sans-serif; background:#f8f9fa;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f8f9fa; padding:35px 0;">
        <tr>
            <td align="center">

                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:580px; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

                    <!-- Status Banner -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); padding:50px 30px 40px; text-align:center;">
                            <h1 style="margin:0; font-size:32px; color:white; font-weight:700;">
                                {{ ucfirst($order->status) }} 📦
                            </h1>
                            <p style="margin:14px 0 0; color:rgba(255,255,255,0.95); font-size:17px;">
                                Your order has been updated
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:40px 40px 30px;">
                            <p style="font-size:17px; line-height:1.6; margin:0 0 24px; color:#1f2937;">
                                Hi <strong>{{ $order->user->name }}</strong>,
                            </p>

                            <p style="font-size:17px; line-height:1.6; margin:0 0 32px; color:#4b5563;">
                                Good news — your order status has changed!
                            </p>

                            <!-- Status Card -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f9fafb; border-radius:12px; padding:28px; border:1px solid #e5e7eb;">
                                <tr>
                                    <td>
                                        <h3 style="margin:0 0 20px; font-size:20px; color:#111827; font-weight:600;">
                                            Order Update
                                        </h3>

                                        <table width="100%" cellpadding="8" cellspacing="0" border="0">
                                            <tr>
                                                <td style="color:#4b5563; font-size:16px; width:40%;">Order ID</td>
                                                <td style="font-weight:600; color:#111827; font-size:16px;">
                                                    {{ $order->id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#4b5563; font-size:16px;">Current Status</td>
                                                <td style="font-weight:700; color:#059669; font-size:18px;">
                                                    {{ ucfirst($order->status) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="text-align:center; margin:32px 0 8px; font-size:16px; color:#4b5563;">
                                We're working hard to get your order to you quickly!
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#f1f5f9; padding:30px; text-align:center; font-size:15px; color:#6b7280;">
                            <p style="margin:0 0 12px;">
                                Thank you for shopping with us 💙
                            </p>
                            <p style="margin:0; font-size:14px;">
                                Questions? Just reply to this email.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>
