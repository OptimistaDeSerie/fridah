@extends('layouts.app')
@section('main-content')
<!-- <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}"> -->
<style>
    #checkout-form {
        margin: 0;
        padding: 0;
    }
    .checkout-steps {
        margin-top: 0 !important;
    }
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
            <li class="active">
                <a href="{{route('cart.index')}}" style="color: #4dae65;">Shopping Cart</a>
            </li>
            <li>
                <a href="javascript:void(0)" style="color: #4dae65;">Checkout</a>
            </li>
            <li class="disabled">
                <a href="javascript:void(0)">Order Complete</a>
            </li>
        </ul>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form id="checkout-form" name="checkout-form" action="{{ route('cart.place.an.order') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-7">
                    <ul class="checkout-steps">
                        <li>
                            <h2 class="step-title">Delivery Information</h2>
                            @if($address)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-1 pb-2">
                                            <div style="border:1px solid #ddd; padding:10px; border-radius:5px; background:#f9f9f9;">
                                                <p style="margin:0;"><strong>Address:</strong> {{ $address->address }}</p>
                                                <p style="margin:0;"><strong>Location and Delivery Vendor:</strong> {{ $address->deliveryFee->state->title }} ({{ $address->deliveryFee->carrier->title }})</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox mt-0">
                                        <input type="checkbox" class="custom-control-input" id="different_shipping" name="different_shipping" value="1"/>
                                        <label class="custom-control-label" data-toggle="collapse" data-target="#collapseFour"
                                        aria-controls="collapseFour" for="different_shipping">Should this order be delivered to a different address?</label>
                                    </div>
                                </div>
                                <div id="collapseFour" class="collapse">
                                    <div class="shipping-info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-1 pb-2">
                                                    <label>Address
                                                        <abbr class="required" title="required">*</abbr></label>
                                                    <textarea class="form-control" name="address" id="address">{{ $address->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-1 pb-2">
                                                    <label>State and Delivery Carrier
                                                        <abbr class="required" title="required">*</abbr></label>
                                                        <select name="delivery_fee_id" class="form-control" id="delivery_fee_id" required>
                                                            @if($address && $address->delivery_fee_id)
                                                                <option value="{{ $address->deliveryFee->id }}" selected>
                                                                    {{ $address->deliveryFee->state->title }} ({{ $address->deliveryFee->carrier->title }})
                                                                </option>
                                                            @else
                                                                <option value="" selected>Select State & Carrier</option>
                                                            @endif
                                                            @foreach ($deliveryFees as $fee)
                                                                @if(!$address || $fee->id != $address->delivery_fee_id)
                                                                    <option value="{{ $fee->id }}">{{ $fee->state->title }} ({{ $fee->carrier->title }})</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        @error('delivery_fee_id') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-1 pb-2">
                                            <label>Address
                                                <abbr class="required" title="required">*</abbr></label>
                                            <textarea class="form-control" placeholder="House number and street name" name="address" required>{{ old('address') }}</textarea>
                                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="select-custom">
                                            <label>State and Delivery Carrier
                                                <abbr class="required" title="required">*</abbr>
                                            </label>
                                            <select name="delivery_fee_id" class="form-control" id="delivery_fee_id" required>
                                                <option value="" selected="selected">Select State & Carrier</option>
                                                @foreach ($deliveryFees as $fee)
                                                    <option value="{{ $fee->id }}">{{ $fee->state->title }} ({{ $fee->carrier->title }})</option>
                                                @endforeach
                                            </select>
                                            @error('delivery_fee_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </li>
                    </ul>
                </div>
                <!-- End .col-lg-7 -->

                <div class="col-lg-5">
                    <div class="order-summary">
                        <h3>YOUR ORDER</h3>
                        <table class="table table-mini-cart">
                            <thead>
                                <tr>
                                    <th colspan="2">Product</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::instance('cart')->content() as $item)
                                <tr>
                                    <td class="product-col">
                                        <h3 class="product-title">
                                            {{ $item->name }} (<span class="product-qty">{{ $item->qty }} unit(s)</span>)
                                        </h3>
                                    </td>
                                    <td class="price-col">
                                        <span>₦{{ $item->price }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="cart-subtotal" id="cart-subtotal" style="border-top: 2px solid #dee2e6;">
                                    <td>
                                        <h4>Subtotal</h4>
                                    </td>
                                    <td class="price-col">
                                        <span>₦{{ Cart::instance('cart')->subtotal() }}</span>
                                    </td>
                                </tr>
                                <tr class="cart-shipping">
                                    <td>
                                        <h4>Shipping</h4>
                                    </td>
                                    <td class="price-col">
                                        @if($address)
                                            <span>₦{{ number_format($address->deliveryFee->price, 2) }}</span>
                                        @else
                                            <span>₦0</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="order-total">
                                    <td>
                                        <h4>Total</h4>
                                    </td>
                                    <td style="text-align: right;">
                                        <b class="total-price">
                                            <span>
                                                ₦{{ number_format(
                                                    (float) str_replace(',', '', Cart::instance('cart')->subtotal()) 
                                                    + ($address ? $address->deliveryFee->price : 0),
                                                    2
                                                ) }}
                                            </span>
                                        </b>
                                    </td>
                                </tr>
                                <tr class="order-shipping mb-4" style="border-top: 2px solid #dee2e6;">
                                    <td class="text-left mb-4" colspan="2">
                                        <h4 class="m-b-sm">Payment Methods</h4>
                                        <div class="form-group form-group-custom-control mb-0">
                                            <div class="custom-control custom-radio d-flex mb-0">
                                                <input type="radio" name="mode" id="checkout_paystack" class="custom-control-input" value="paystack" checked>
                                                <label class="custom-control-label" for="checkout_paystack">Paystack</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <button type="submit" class="btn btn-primary btn-place-order mt-4" form="checkout-form">
                            Place order
                        </button>
                    </div>
                    <!-- End .order-summary -->
                </div>
                <!-- End .col-lg-5 -->
            </div>
            <!-- End .row -->
        </form>
    </div>
</main>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    $('#delivery_fee_id').on('change', function() {
        var feeId = $(this).val();
        if (!feeId) return;
        $.ajax({
            url: '/cart/delivery-fee',
            type: 'GET',
            data: { delivery_fee_id: feeId },
            success: function(response) {
                // Update shipping price
                $('.cart-shipping .price-col span').text('₦' + response.price);
                // Update subtotal and total
                var subtotal = parseFloat($('#cart-subtotal .price-col span').text().replace(/[^\d.]/g, ''));
                var total = subtotal + parseFloat(response.price);
                $('.total-price span').text('₦' + total.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            },
            error: function(xhr) {
                alert('Could not fetch delivery fee.');
            }
        });
    });
});
</script>
@endpush