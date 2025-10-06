@extends('layouts.app')
@section('main-content')
<!-- <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}"> -->
<style>
    .order-summary {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .order-summary h3 {
        margin-bottom: 1.9rem;
        font-size: 1.4rem;
        letter-spacing: -0.01em;
    }

    .order-summary .price-col {
        text-align: right;
    }

    .order-summary button.btn-place-order {
        width: 100%;
        padding: 12px;
    }
    .product-title {
        font-size: 1.4rem;
        font-weight: 400;
    }
    .table td, .table th {
        padding: .75rem;
        border-top: 0px;
        color: #222529;
    }
    .order-summary h4 {
        margin-bottom: 0;
        font-size: 1.4rem;
        font-weight: 600;
        letter-spacing: -0.01em;
        line-height: 19px;
    }
    .table-mini-cart .price-col {
        font-size: 1.4rem;
        font-weight: 400;
    }
    .step-title {
        color: #222529;
        font-size: 2.2rem;
    }
</style>
<hr class="divider mb-0 mt-0">
<main class="main">
    <div class="container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li>
                <a href="javascript:void(0)">Shopping Cart</a>
            </li>
            <li>
                <a href="javascript:void(0)">Checkout</a>
            </li>
            <li class="active">
                <a href="javascript:void(0)" style="color: #4dae65;">Order Complete</a>
            </li>
        </ul>
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="order-summary text-center">
                    <h3>Order Confirmation</h3>
                    <p>Your order has been successfully placed!</p>
                    <table class="table table-mini-cart">
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                            <tr>
                                <td class="product-col">
                                    <h3 class="product-title">
                                        {{ $item->product->name }} (<span class="product-qty">{{ $item->quantity }} unit(s)</span>)
                                    </h3>
                                </td>
                                <td class="price-col">
                                    <span>₦{{ number_format($item->price, 2) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="cart-shipping">
                                <td>
                                    <h4>Shipping</h4>
                                </td>
                                <td class="price-col">
                                    <span>₦{{ $deliveryFee ? number_format($deliveryFee->price, 2) : '0.00' }}</span>
                                </td>
                            </tr>
                            <tr class="cart-subtotal">
                                <td>
                                    <h4>Subtotal</h4>
                                </td>
                                <td class="price-col">
                                    <span>₦{{ number_format($order->subtotal, 2) }}</span>
                                </td>
                            </tr>
                            <tr class="order-total">
                                <td>
                                    <h4>Total</h4>
                                </td>
                                <td style="text-align: right;">
                                    <b class="total-price"><span>₦{{ number_format($order->total, 2) }}</span></b>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary mt-4">Continue Shopping</a>
                </div>
                <!-- End .order-summary -->
            </div>
            <!-- End .col-lg-5 -->
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
</script>
@endpush