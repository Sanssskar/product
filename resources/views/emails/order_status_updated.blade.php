<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Update - {{ ucfirst($order->status) }}</title>
</head>

<body
    style="margin:0; padding:0; font-family: 'Helvetica Neue', Arial, sans-serif; background-color:#f9fafb; color:#1f2937;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f9fafb; padding:40px 0;">
        <tr>
            <td align="center">

                <!-- Main Card -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="max-width:600px; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 10px 35px rgba(0,0,0,0.08);">

                    <!-- Status Header (changes color per status) -->
                    <tr>
                        <td
                            style="
                            background: {{ match ($order->status) {
                                'pending' => 'linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%)',
                                'approved' => 'linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%)',
                                'shipped' => 'linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%)',
                                'delivered' => 'linear-gradient(135deg, #10b981 0%, #34d399 100%)',
                                'cancel' => 'linear-gradient(135deg, #ef4444 0%, #f87171 100%)',
                                default => '#6b7280',
                            } }};
                            padding: 50px 30px 40px;
                            text-align: center;
                        ">
                            <h1 style="margin:0; font-size:36px; color:white; font-weight:700; letter-spacing:-0.5px;">
                                {{ match ($order->status) {
                                    'pending' => 'Order Received',
                                    'approved' => 'Order Approved',
                                    'shipped' => 'Order Shipped',
                                    'delivered' => 'Order Delivered 🎉',
                                    'cancel' => 'Order Cancelled',
                                    default => ucfirst($order->status),
                                } }}
                            </h1>

                            <p style="margin:14px 0 0; color:rgba(255,255,255,0.95); font-size:18px; font-weight:400;">
                                Order #{{ $order->id }}
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 40px 20px;">

                            <p style="font-size:17px; line-height:1.6; margin:0 0 28px; color:#111827;">
                                Hello <strong>{{ $order->user->name }}</strong>,
                            </p>

                            <!-- Status-specific message -->
                            @php
                                $messages = [
                                    'pending' =>
                                        'Your order has been successfully placed and is currently under review. We will notify you once it is approved.',
                                    'approved' =>
                                        'Great news! Your order has been approved and is now being prepared for shipping.',
                                    'shipped' =>
                                        'Your order is on its way! We’ve handed it over to our delivery partner.',
                                    'delivered' => 'Your order has been successfully delivered. Enjoy your purchase!',
                                    'cancel' =>
                                        'Your order has been cancelled as requested. If this was a mistake, please contact us immediately.',
                                ];
                            @endphp

                            <p style="font-size:17px; line-height:1.6; margin:0 0 32px; color:#4b5563;">
                                {{ $messages[$order->status] ?? 'Your order status has been updated.' }}
                            </p>

                            <!-- Order Summary -->
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="background:#f8fafc; border-radius:12px; padding:28px 30px; border:1px solid #e5e7eb; margin-bottom:32px;">
                                <tr>
                                    <td>
                                        <h3 style="margin:0 0 20px; font-size:20px; color:#111827; font-weight:600;">
                                            Order Information
                                        </h3>

                                        <table width="100%" cellpadding="10" cellspacing="0" border="0">
                                            <tr>
                                                <td style="color:#4b5563; font-size:16px; width:45%; padding-left:0;">
                                                    Order ID</td>
                                                <td style="font-weight:600; color:#111827; font-size:16px;">
                                                    {{ $order->id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="color:#4b5563; font-size:16px;">Current Status</td>
                                                <td
                                                    style="font-weight:700; font-size:17px; color: {{ match ($order->status) {
                                                        'pending' => '#d97706',
                                                        'approved' => '#2563eb',
                                                        'shipped' => '#7c3aed',
                                                        'delivered' => '#059669',
                                                        'cancel' => '#dc2626',
                                                        default => '#6b7280',
                                                    } }};">
                                                    {{ ucfirst($order->status) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="color:#4b5563; font-size:16px;">Total Amount</td>
                                                <td style="font-weight:700; color:#111827; font-size:18px;">
                                                    Rs {{ number_format($order->Total_amt, 2) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Next step guidance -->
                            @if ($order->status === 'shipped')
                                <p
                                    style="font-size:16px; line-height:1.6; margin:0 0 24px; color:#4b5563; text-align:center; font-style:italic;">
                                    Keep an eye on your email/SMS — you’ll receive tracking details very soon.
                                </p>
                            @elseif($order->status === 'delivered')
                                <p
                                    style="font-size:16px; line-height:1.6; margin:0 0 24px; color:#4b5563; text-align:center;">
                                    We hope you love your items! ❤️
                                </p>
                            @elseif($order->status === 'cancel')
                                <p
                                    style="font-size:16px; line-height:1.6; margin:0 0 24px; color:#4b5563; text-align:center;">
                                    Any refund will be processed according to our policy (usually within 5–7 business
                                    days).
                                </p>
                            @endif

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background:#f1f5f9; padding:32px 40px; text-align:center; font-size:15px; color:#6b7280; border-top:1px solid #e5e7eb;">
                            <p style="margin:0 0 12px; font-weight:500;">
                                Thank you for shopping with us!
                            </p>
                            <p style="margin:0 0 8px;">
                                Have any questions? Just reply to this email — we’re here to help.
                            </p>
                            <p style="margin:16px 0 0; font-size:14px;">
                                © {{ date('Y') }} {{ config('app.name') }} • All rights reserved
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
