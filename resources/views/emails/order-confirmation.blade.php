@extends('emails.layouts.main')

@section('title', 'Order Confirmation - Woodcraft')

@section('content')
    {{-- Order Confirmation Header --}}
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #4B2E1F; margin-bottom: 10px;">Thank You for Your Order!</h1>
        <p style="color: #666; font-size: 16px;">
            Your order has been received and is being processed.
        </p>
    </div>

    {{-- Order Details --}}
    <div style="background-color: #f9f9f9; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
        <h2 style="color: #4B2E1F; margin-bottom: 15px;">Order Details</h2>
        
        {{-- Order Summary --}}
        <div style="margin-bottom: 20px;">
            <p style="margin: 5px 0;">
                <strong>Order Number:</strong> {{ $order->number }}
            </p>
            <p style="margin: 5px 0;">
                <strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}
            </p>
            <p style="margin: 5px 0;">
                <strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}
            </p>
        </div>

        {{-- Shipping Address --}}
        <div style="margin-bottom: 20px;">
            <h3 style="color: #4B2E1F; margin-bottom: 10px;">Shipping Address</h3>
            <p style="margin: 5px 0;">
                {{ $order->shipping_address->name }}<br>
                {{ $order->shipping_address->street }}<br>
                {{ $order->shipping_address->city }}, {{ $order->shipping_address->state }} {{ $order->shipping_address->zip }}<br>
                {{ $order->shipping_address->country }}
            </p>
        </div>

        {{-- Order Items --}}
        <div>
            <h3 style="color: #4B2E1F; margin-bottom: 10px;">Order Items</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #ddd;">
                        <th style="text-align: left; padding: 10px;">Item</th>
                        <th style="text-align: center; padding: 10px;">Quantity</th>
                        <th style="text-align: right; padding: 10px;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">
                                <div style="display: flex; align-items: center;">
                                    <img src="{{ $item->product->thumbnail }}" alt="{{ $item->product->name }}" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                    <div>
                                        <p style="margin: 0; font-weight: 500;">{{ $item->product->name }}</p>
                                        <p style="margin: 0; color: #666; font-size: 14px;">{{ $item->variant }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="text-align: center; padding: 10px;">{{ $item->quantity }}</td>
                            <td style="text-align: right; padding: 10px;">${{ number_format($item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right; padding: 10px;"><strong>Subtotal:</strong></td>
                        <td style="text-align: right; padding: 10px;">${{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right; padding: 10px;"><strong>Shipping:</strong></td>
                        <td style="text-align: right; padding: 10px;">${{ number_format($order->shipping_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right; padding: 10px;"><strong>Tax:</strong></td>
                        <td style="text-align: right; padding: 10px;">${{ number_format($order->tax, 2) }}</td>
                    </tr>
                    <tr style="border-top: 2px solid #ddd;">
                        <td colspan="2" style="text-align: right; padding: 10px;"><strong>Total:</strong></td>
                        <td style="text-align: right; padding: 10px;"><strong>${{ number_format($order->total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Next Steps --}}
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="color: #4B2E1F; margin-bottom: 15px;">What's Next?</h2>
        <p style="color: #666; margin-bottom: 20px;">
            We'll send you another email when your order ships. You can track your order status at any time by clicking the button below.
        </p>
        <a href="{{ route('orders.show', $order->number) }}" class="button">
            Track Order
        </a>
    </div>

    {{-- Additional Information --}}
    <div style="background-color: #f9f9f9; padding: 20px; border-radius: 4px;">
        <h3 style="color: #4B2E1F; margin-bottom: 10px;">Need Help?</h3>
        <p style="color: #666; margin-bottom: 15px;">
            If you have any questions about your order, please don't hesitate to contact our customer service team.
        </p>
        <p style="margin: 5px 0;">
            <strong>Email:</strong> support@woodcraft.com<br>
            <strong>Phone:</strong> +1 (555) 123-4567
        </p>
    </div>
@endsection 