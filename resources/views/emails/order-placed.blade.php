<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmed</title>
</head>
<body style="margin:0;padding:0;background:#f7f4ef;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 5px 15px rgba(0,0,0,0.05);">

                <!-- Header -->
                <tr>
                    <td style="background:#16a34a; padding:30px; text-align:center; color:white;">
                        <h1 style="margin:0;">Fridah's Spice</h1>
                    </td>
                </tr>

                <!-- Body -->
                <tr>
                    <td style="padding:30px;color:#333333;">
                        <h2 style="margin-top:0;">Hello {{ $user->firstname }},</h2>

                        <p>Thank you for your order!</p>

                        <p><strong>Order Reference:</strong> {{ $transaction->paystack_reference }}</p>
                        <p><strong>Shipping Address:</strong> {{ optional($transaction->order->defaultAddress)->address ?? 'No address available' }}</p>

                        @if($transaction->order->defaultAddress && $transaction->order->defaultAddress->deliveryFee)
                            <p>
                                <strong>State:</strong> {{ $transaction->order->defaultAddress->deliveryFee->state->title ?? 'N/A' }}<br>
                                <strong>Carrier:</strong> {{ $transaction->order->defaultAddress->deliveryFee->carrier->title ?? 'N/A' }}<br>
                            </p>
                        @endif

                        <h3>Order Details:</h3>

                        <table width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
                            <thead>
                                <tr style="background:#f4f4f4;">
                                    <th style="border:1px solid #ddd;text-align:left;">Item</th>
                                    <th style="border:1px solid #ddd;text-align:left;">Size</th>
                                    <th style="border:1px solid #ddd;text-align:right;">Qty</th>
                                    <th style="border:1px solid #ddd;text-align:right;">Price</th>
                                    <th style="border:1px solid #ddd;text-align:right;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $cartItems = $transaction->cart_snapshot; @endphp
                                @if(is_string($cartItems))
                                    @php $cartItems = json_decode($cartItems, true); @endphp
                                @endif

                                @foreach($cartItems as $item)
                                    <tr>
                                        <td style="border:1px solid #ddd;">{{ $item['name'] }}</td>
                                        <td style="border:1px solid #ddd;">{{ $item['options']['size_name'] ?? '-' }}</td>
                                        <td style="border:1px solid #ddd;text-align:right;">{{ $item['qty'] }}</td>
                                        <td style="border:1px solid #ddd;text-align:right;">₦{{ number_format($item['price'],2) }}</td>
                                        <td style="border:1px solid #ddd;text-align:right;">₦{{ number_format($item['price'] * $item['qty'],2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <p style="margin-top:20px; font-size:16px;">
                            <strong>Subtotal:</strong> ₦{{ number_format($transaction->subtotal, 2) }}<br>
                            <strong>Delivery Fee:</strong> ₦{{ number_format($transaction->delivery_fee, 2) }}<br>
                            <strong>Total Paid:</strong> ₦{{ number_format($transaction->amount, 2) }}
                        </p>

                        <hr style="margin:25px 0;">

                        <p>We are preparing your delicious spices and will notify you once your order is dispatched.</p>

                        <p>If you have any questions, feel free to reply to this email.</p>

                        <p style="margin-top:30px;">
                            Warm regards,<br>
                            <strong>The Fridah's Spice Team</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="background:#f3ede7;padding:15px;text-align:center;font-size:12px;color:#777;">
                        © {{ date('Y') }} Fridah's Spice. All rights reserved.
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>