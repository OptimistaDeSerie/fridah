@extends('layouts.app')
@section('main-content')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom_1.css') }}">

<hr class="divider mb-0 mt-0">

<div class="container">
    <div class="product-single-container product-single-default">

        <div class="cart-message d-none">
            <strong class="single-cart-notice">{{ $product->name }}</strong>
            <span>has been added to your cart.</span>
        </div>

        <div class="row">

            {{-- GALLERY --}}
            <div class="col-lg-5 col-md-6 product-single-gallery">
                <div class="product-slider-container">
                    <div class="product-single-carousel owl-carousel owl-theme show-nav-hover">
                        @foreach (explode(',', $product->images) as $gimg)
                            <div class="product-item">
                                <img loading="lazy"
                                     class="product-single-image"
                                     src="{{ asset('backend/uploads/products/'.$gimg) }}"
                                     width="468"
                                     height="468">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="prod-thumbnail owl-dots">
                    @foreach (explode(',', $product->images) as $gimg)
                        <div class="owl-dot">
                            <img loading="lazy"
                                 src="{{ asset('backend/uploads/products/thumbnails/'.trim($gimg)) }}"
                                 width="110"
                                 height="110">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- DETAILS --}}
            <div class="col-lg-7 col-md-6 product-single-details">
                <h1 class="product-title">{{ $product->name }}</h1>
                <hr class="short-divider">

                {{-- PRICE (CHANGES WHEN SIZE CHANGES) --}}
                <div class="price-box">
                    <span class="new-price" id="product-price">
                        {{ $currency }} -- choose size first
                    </span>
                </div>

                <div class="product-desc">
                    <p>{{ $product->short_description }}</p>
                </div>

                <ul class="single-info-list">
                    <li>SKU: <strong>{{ $product->SKU }}</strong></li>
                    <li>
                        CATEGORY:
                        <strong>{{ $product->category->name }}</strong>
                    </li>
                </ul>

                {{-- ADD TO CART --}}
                <div class="product-action mt-3">
                    <div class="row">
                        {{-- SIZE SELECTOR --}}
                        <div class="form-group">
                            <select class="form-control" id="size-select" required>
                                <option value="">Choose Size</option>
                                @foreach ($product->sizes as $size)
                                    <option value="{{ $size->id }}"
                                        data-price="{{ $size->sale_price && $size->sale_price > 0 ? $size->sale_price : $size->regular_price }}">
                                        {{ $size->size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- ADD TO CART FORM --}}
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

                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">

                            {{-- LOCKED PRICE --}}
                            <input type="hidden" name="price" id="cart-price">

                            {{-- SIZE ID --}}
                            <input type="hidden" name="size_id" id="cart-size-id">

                            <button type="submit"
                                    class="btn btn-primary btn-add-cart1"
                                    id="add-to-cart-btn">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>

                <hr class="divider mb-0 mt-0">
            </div>
        </div>
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
    {{-- RELATED PRODUCTS --}}
    <div class="products-section pt-0">
        <h2 class="section-title m-b-4">Related Products</h2>

        <div class="products-slider owl-carousel owl-theme dots-top dots-small mb-0">
            @foreach ($relatedproducts as $rproduct)
                <div class="product-default">
                    <figure>
                        <a href="{{ route('shop.product.details', $rproduct->slug) }}">
                            <img loading="lazy"
                                 src="{{ asset('backend/uploads/products/'.$rproduct->image) }}"
                                 width="217">
                        </a>
                    </figure>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    const $sizeSelect = $('#size-select');
    const $addBtn = $('#add-to-cart-btn');
    const $priceInput = $('#cart-price');
    const $sizeIdInput = $('#cart-size-id');

    /* ==========================================================
     * SIZE CHANGE HANDLER
     * ========================================================== */
    $sizeSelect.on('change', function () {
        let selectedSizeId = $(this).val();
        let selectedPrice = $(this).find(':selected').data('price');

        if (!selectedSizeId) {
            $addBtn.prop('disabled', true);
            $sizeIdInput.val('');
            $priceInput.val('');
            $('#product-price').text('₦ -- choose size first'); 
            return;
        }

        // sync values into hidden inputs
        $sizeIdInput.val(selectedSizeId);
        $priceInput.val(selectedPrice);


        // UPDATE PRICE TEXT
        $('#product-price').text(
            '₦ ' + Number(selectedPrice).toLocaleString()
        );

        // enable add to cart
        $addBtn.prop('disabled', false);
    });

    /* ==========================================================
     * ADD TO CART (AJAX) — FIXED & CLEAN
     * ========================================================== */
    $(document).on('submit', '.addtocart-form', function (e) {
        e.preventDefault();

        let form = $(this);
        let $btn = form.find('button[type="submit"]');
        let actionUrl = form.attr('action');
        let formData = form.serialize();

        // HARD GUARD
        if (!$sizeIdInput.val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Select a size',
                text: 'Please choose a size before adding to cart.'
            });
            return;
        }

        // Disable button + spinner
        $btn.prop('disabled', true);
        let originalHtml = $btn.html();
        $btn.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...'
        );

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

                    // Header updates
                    $('.cart-count').text(response.count);
                    $('.cart-price').text('₦' + response.subtotal);

                    // CLEAN REPLACEMENT (NO UGLY APPEND)
                    $('.product-action').replaceWith(
                        `<a href="{{ route('cart.index') }}"
                            class="btn btn-primary btn-add-cart1">
                            Go to Cart
                        </a>`
                    );
                }
            },

            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Something went wrong. Please try again.'
                });
            },

            complete: function () {
                $btn.prop('disabled', false).html(originalHtml);
            }
        });
    });

});

</script>
@endpush
