<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Placed – Thank You!</title>
</head>

<body
    style="margin:0; padding:0; font-family: 'Helvetica Neue', Arial, sans-serif; background-color:#f8f9fa; color:#333;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f8f9fa; padding:30px 0;">
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:580px; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); padding:50px 30px 40px; text-align:center;">
                            <h1 style="margin:0; font-size:32px; color:white; font-weight:700; letter-spacing:-0.5px;">
                                Order Placed 🎉
                            </h1>
                            <p style="margin:12px 0 0; color:rgba(255,255,255,0.9); font-size:17px;">
                                We're preparing your order right now!
                            </p>
                        </td>
                    </tr>

                    <!-- Greeting + Content -->
                    <tr>
                        <td style="padding:40px 40px 30px;">
                            <p style="font-size:17px; line-height:1.6; margin:0 0 24px; color:#1f2937;">
                                Hello <strong>{{ $order->user->name }}</strong>,
                            </p>
                            <p style="font-size:17px; line-height:1.6; margin:0 0 32px; color:#4b5563;">
                                Your order has been successfully placed.<br>
                                Thank you for choosing us — we're excited to get your items to you soon!
                            </p>

                            <!-- Order Summary Card -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f9fafb; border-radius:12px; padding:28px; border:1px solid #e5e7eb;">
                                <tr>
                                    <td>
                                        <h3 style="margin:0 0 20px; font-size:20px; color:#111827; font-weight:600;">
                                            Order Details
                                        </h3>

                                        <table width="100%" cellpadding="8" cellspacing="0" border="0">
                                            <tr>
                                                <td style="color:#4b5563; font-size:16px; width:40%;">Order ID</td>
                                                <td style="font-weight:600; color:#111827; font-size:16px;">
                                                    {{ $order->id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#4b5563; font-size:16px;">Total Amount</td>
                                                <td style="font-weight:700; color:#111827; font-size:18px;">Rs
                                                    {{ number_format($order->Total_amt, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#4b5563; font-size:16px;">Status</td>
                                                <td style="font-weight:600; color:#059669; font-size:16px;">
                                                    {{ ucfirst($order->status) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p
                                style="font-size:16px; line-height:1.6; margin:32px 0 12px; color:#4b5563; text-align:center;">
                                We'll notify you as soon as your order ships!
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background:#f1f5f9; padding:30px; text-align:center; font-size:15px; color:#6b7280; border-top:1px solid #e5e7eb;">
                            <p style="margin:0 0 12px;">
                                Thank you for shopping with us 💜
                            </p>
                            <p style="margin:0; font-size:14px;">
                                Have questions? Reply to this email or contact us anytime.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>
