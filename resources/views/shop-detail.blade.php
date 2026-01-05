@extends('layouts.app')
@section('main-content')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom_1.css') }}">
<hr class="divider mb-0 mt-0">
<div class="container">
    <div class="product-single-container product-single-default">
        <div class="cart-message d-none">
            <strong class="single-cart-notice">{{$product->name}}</strong>
            <span>has been added to your cart.</span>
        </div>

        <div class="row">
            <div class="col-lg-5 col-md-6 product-single-gallery">
                <div class="product-slider-container">
                    <div class="label-group">
                    </div>
                    <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                        @foreach (explode(',',$product->images) as $gimg)
                        <div class="product-item">
                            <img loading="lazy" class="product-single-image" src="{{asset('backend/uploads/products/')}}/{{$gimg}}" width="468" height="468" alt="{{$gimg}}" />
                        </div>
                        @endforeach

                    </div>
                    <!-- End .product-single-carousel -->
                    <span class="prod-full-screen">
                        <i class="icon-plus"></i>
                    </span>
                </div>

                <div class="prod-thumbnail owl-dots">
                    @foreach (explode(',',$product->images) as $gimg)
                    <div class="owl-dot">
                        <img loading="lazy" src="{{asset('backend/uploads/products/thumbnails/')}}/{{trim($gimg)}}" width="110" height="110" alt="{{$gimg}}" />
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- End .product-single-gallery -->

            <div class="col-lg-7 col-md-6 product-single-details">
                <h1 class="product-title">{{$product->name}}</h1>
                <hr class="short-divider">
                <div class="price-box">
                    <span class="old-price">{{$currency}} {{ number_format($product->regular_price, 0, '.', ',') }}</span>
                    <span class="new-price">{{$currency}} {{ number_format($product->sale_price, 0, '.', ',') }}</span>
                </div>
                <!-- End .price-box -->

                <div class="product-desc">
                    <p>
                        {{$product->short_description}}
                    </p>
                </div>
                <!-- End .product-desc -->

                <ul class="single-info-list">

                    <li>
                        SKU: <strong>{{$product->SKU}}</strong>
                    </li>

                    <li>
                        CATEGORY: <strong><a href="" class="product-category">{{$product->category->name}}</a></strong>
                    </li>
                </ul>

                <div class="product-action">
                    @php
                        $inCart = Cart::instance('cart')->content()->where('id', $product->id)->first();
                    @endphp

                    @if($inCart)
                        {{-- Already in cart: just show Go to Cart button --}}
                        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-add-cart1">Go to Cart</a>
                    @else
                        {{-- Not in cart: quantity selector + add to cart button --}}
                        <form class="addtocart-form" action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <div class="product-single-qty">
                                <input class="horizontal-quantity form-control"
                                    type="text"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    readonly>
                            </div>
                            <input type="hidden" name="id" value="{{ $product->id }}" />
                            <input type="hidden" name="name" value="{{ $product->name }}" />
                            <input type="hidden" name="price"
                                value="{{ $product->sale_price ?: $product->regular_price }}" />  
                            <button type="submit" class="btn btn-primary btn-add-cart1" title="Add to Cart">Add to Cart</button>
                        </form>
                    @endif
                </div>
                <!-- End .product-action -->

                <hr class="divider mb-0 mt-0">
                <!-- End .product single-share -->
            </div>
            <!-- End .product-single-details -->
        </div>
        <!-- End .row -->
    </div>
    <div class="product-single-tabs">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Description</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                <div class="product-desc-content">
                    <p>{{$product->description}}</p>
                </div>
                <!-- End .product-desc-content -->
            </div>
            <!-- End .tab-pane -->
        </div>
        <!-- End .tab-content -->
    </div>
    <!-- End .product-single-tabs -->

    <div class="products-section pt-0">
        <h2 class="section-title m-b-4">Related Products</h2>

        <div class="row">
            <div class="products-slider owl-carousel owl-theme dots-top dots-small mb-0" data-owl-options="{
                        'margin': 0
                    }">
                @foreach ($relatedproducts as $rproduct)
                <div class="product-default inner-quickview inner-icon">
                    <figure>
                        <a href="{{ route('shop.product.details', ['product_slug' => $rproduct->slug]) }}">
                            <img loading='lazy' src="{{asset('backend/uploads/products')}}/{{$rproduct->image}}" width="217" height="217" alt="{{$rproduct->name}}">
                        </a>
                        <div class="label-group">
                            <div class="product-label label-hot">HOT</div>
                        </div>
                        <div class="btn-icon-group">
                            <a href="#" class="btn-icon btn-add-cart product-type-simple"><i
                                    class="icon-shopping-cart"></i></a>
                        </div>
                    </figure>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function () {
    $(document).on('submit', '.addtocart-form', function (e) {
        e.preventDefault();
        let form = $(this);
        let $btn = form.find('button[type="submit"]'); // assume form has a submit button
        let actionUrl = form.attr('action');
        let formData = form.serialize();

        // Disable button and show spinner
        $btn.prop('disabled', true);
        let originalHtml = $btn.html();
        $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');

        $.ajax({
            url: actionUrl,
            type: "POST",
            data: formData,
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Update cart count in header
                    if ($('.cart-count').length) {
                        $('.cart-count').text(response.count);
                    }

                    // Update subtotal
                    if ($('.cart-subtotal').length) {
                        $('.cart-subtotal').text(response.subtotal);
                    }

                    // Turn button into "Go to Cart"
                    form.replaceWith(
                        `<a href="{{ route('cart.index') }}" class="btn btn-primary btn-add-cart1">
                            Go to Cart
                        </a>`
                    );
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong. Please try again.'
                });
            },
            complete: function () {
                // Re-enable button and restore original HTML in case of error
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    });
});
</script>
@endpush