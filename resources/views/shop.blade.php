@extends('layouts.app')
@section('main-content')
<main class="main">
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav"></nav>
        <div class="row">
            <div class="col-lg-9">
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
                <div class="boxed-slider owl-carousel owl-carousel-lazy owl-theme owl-theme-light">
                    @foreach(\App\Models\ShopBanner::where('status', true)->orderBy('sort_order')->get() as $banner)
                        <div class="boxed-slide">
                            <figure>
                                <img loading="lazy"
                                     class="slide-bg owl-lazy"
                                     data-src="{{ asset('backend/uploads/shop-banners/' . $banner->image) }}"
                                     src="{{ asset('backend/uploads/shop-banners/' . $banner->image) }}"
                                     alt="{{ $banner->title ?? 'Shop Banner' }}"
                                     width="870" height="300">
                            </figure>
                            <div class="slide-content">
                                @if($banner->line_1)<h4>{{ $banner->line_1 }}</h4>@endif
                                @if($banner->line_2)<h5>{{ $banner->line_2 }}</h5>@endif
                                @if($banner->line_3)<span>{{ $banner->line_3 }}</span>@endif
                                @if($banner->line_4)<b>{!! $banner->line_4 !!}</b>@endif
                                @if($banner->line_5)<p>{{ $banner->line_5 }}</p>@endif
                                @if($banner->button_text && $banner->button_link)
                                    <a href="{{ $banner->button_link }}" class="btn btn-sm btn-dark">
                                        {{ $banner->button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <nav class="toolbox sticky-header mt-2" data-sticky-options="{'mobile': true}">
                    <div class="toolbox-left">
                        <a href="#" class="sidebar-toggle">
                            <span>Filter</span>
                        </a>

                        <div class="toolbox-item toolbox-sort">
                            <label>Sort By:</label>
                            <div class="select-custom">
                                <select class="form-control" id="orderby">
                                    <option value="-1" {{ $orderby == -1 ? 'selected':'' }}>Default sorting</option>
                                    <option value="1" {{ $orderby == 1 ? 'selected':'' }}>Date, New to Old</option>
                                    <option value="2" {{ $orderby == 2 ? 'selected':'' }}>Date, Old to New</option>
                                    <option value="3" {{ $orderby == 3 ? 'selected':'' }}>Price, Low to High</option>
                                    <option value="4" {{ $orderby == 4 ? 'selected':'' }}>Price, High to Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="toolbox-right">
                        <div class="toolbox-item toolbox-show">
                            <label>Show:</label>
                            <div class="select-custom">
                                <select class="form-control" id="pagesize">
                                    <option value="12" {{ $size == 12 ? 'selected': '' }}>12</option>
                                    <option value="24" {{ $size == 24 ? 'selected': '' }}>24</option>
                                    <option value="48" {{ $size == 48 ? 'selected': '' }}>48</option>
                                    <option value="102" {{ $size == 102 ? 'selected': '' }}>102</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </nav>
                {{-- PRODUCTS --}}
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-6 col-sm-4">
                            <div class="product-default">
                                <figure>
                                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                        <img loading="lazy"
                                             src="{{ asset('backend/uploads/products/'.$product->image) }}"
                                             width="280" height="280"
                                             alt="{{ $product->name }}">
                                    </a>
                                </figure>
                                <div class="product-details">
                                    <h3 class="product-title">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    {{--SIZE-BASED PRICE --}}
                                    <div class="price-box">
                                        @if($product->effective_price)
                                            @php
                                                // find max regular price among sizes (for strike-through)
                                                $regularPrice = $product->sizes->max('regular_price');
                                                $salePrice    = $product->effective_price;
                                            @endphp

                                            @if($regularPrice && $regularPrice > $salePrice)
                                                <span class="old-price">
                                                    {{ $currency }}{{ number_format($regularPrice, 0, '.', ',') }}
                                                </span>
                                            @endif

                                            <span class="product-price">
                                                {{ $currency }}{{ number_format($salePrice, 0, '.', ',') }}
                                            </span>
                                            <small class="d-block text-muted">From</small>
                                        @else
                                            <span class="product-price text-muted">Price unavailable</span>
                                        @endif
                                    </div>
                                    {{-- ACTION --}}
                                    <div class="product-action">
                                        @php
                                            $hasSizes = $product->sizes->count() > 0;
                                        @endphp

                                        @if(Cart::instance('cart')->content()->where('id',$product->id)->count() > 0)
                                            <a href="{{ route('cart.index') }}"
                                               class="btn-icon btn-primary btn-add-cart1">
                                                <i class="icon-shopping-cart"></i>GO TO CART
                                            </a>

                                        @elseif($hasSizes)
                                            {{-- MUST SELECT SIZE --}}
                                            <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}"
                                               class="btn-icon btn-primary btn-add-cart1">
                                                <i class="icon-eye"></i>SELECT SIZE
                                            </a>

                                        @else
                                            {{-- NO SIZES (RARE CASE) --}}
                                            <form name="addtocart-form" method="POST" action="{{ route('cart.add') }}">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="name" value="{{ $product->name }}">
                                                <input type="hidden" name="price" value="{{ $product->effective_price }}">
                                                <button type="submit" class="btn-icon btn-add-cart1">
                                                    <i class="icon-shopping-cart"></i>ADD TO CART
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <nav class="toolbox toolbox-pagination">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </nav>
            </div>

            {{-- SIDEBAR --}}
            <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                <div class="sidebar-wrapper">

                    {{-- CATEGORIES --}}
                    <div class="widget">
                        <h3 class="widget-title">Categories</h3>
                        <div class="widget-body">
                            <ul class="cat-list">
                                @foreach($categories as $category)
                                    <li>
                                        <label>
                                            <input type="checkbox" name="categories"
                                                   value="{{ $category->id }}"
                                                   @if(in_array($category->id,$filter_categories)) checked @endif>
                                            {{ $category->name }}
                                            <span>({{ $category->products_count }})</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- PRICE SLIDER --}}
                    <div class="widget">
                        <h3 class="widget-title">Price</h3>
                        <div class="widget-body pb-0">
                            <div id="price-slider"></div>
                            <div class="filter-price-action">
                                <span id="filter-price-range"></span>
                                <a href="{{ route('shop.index') }}" class="btn btn-primary btn-add-cart1">Reset</a>
                            </div>
                        </div>
                    </div>

                </div>
            </aside>
        </div>
    </div>
</main>

<form id="sizeFilterForm" method="GET" action="{{ route('shop.index') }}">
    <input type="hidden" name="page" value="{{ $products->currentPage() }}">
    <input type="hidden" name="size" id="size" value="{{ $size }}">
    <input type="hidden" name="order" id="order" value="{{ $orderby }}">
    <input type="hidden" name="categories" id="hidden_categories">
    <input type="hidden" name="min_price" id="min_price" value="{{ $min_price }}">
    <input type="hidden" name="max_price" id="max_price" value="{{ $max_price }}">
</form>
@endsection

<script src="{{ asset('assets/js/nouislider.min.js') }}"></script>
@push('scripts')
<script>
    var backendMinPrice = {{ $min_price }};
    var backendMaxPrice = {{ $max_price }};
    window.cartIndexUrl = "{{ route('cart.index') }}";
    $(function() {
        $(document).on('submit', 'form[name="addtocart-form"]', function(e) {
            e.preventDefault();
            let $form = $(this);
            let $btn = $form.find('button[type="submit"]'); // assuming you have a submit button
            let url = $form.attr('action');
            let formData = $form.serialize(); // serialize hidden inputs

            // Disable button and show spinner
            $btn.prop('disabled', true);
            let originalHtml = $btn.html();
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Update header cart count
                    if ($('.cart-count').length) {
                        $('.cart-count').text(response.count);
                    } else {
                        // If badge doesn’t exist yet, append it
                        $('.cart-toggle').append(
                            `<span class="cart-count badge-circle">${response.count}</span>`
                        );
                    }

                    // Update header subtotal
                    $('.cart-price').text('₦' + response.subtotal);

                    // Change button to "GO TO CART"
                    $form.replaceWith(
                        `<a href="${window.cartIndexUrl}" class="btn-icon btn-primary btn-add-cart1" style="color: #fff; background:#154821; border-color:#154821;">
                            <i class="icon-shopping-cart"></i> GO TO CART
                        </a>`
                    );

                    Swal.fire({
                        icon: 'success',
                        title: 'Added!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire(
                        'Error',
                        'Failed to add product to cart.',
                        'error'
                    );
                },
                complete: function() {
                    // Re-enable button and restore original HTML in case of error
                    $btn.prop('disabled', false).html(originalHtml);
                }
            });
        });


    //PageSize filter
    $("#pagesize").on('change', function() {
        var size = $(this).val();
        $("#size").val(size);
        $("#sizeFilterForm").submit();
    });

    //ordering filter
    $("#orderby").on('change', function() {
        var order = $(this).val();
        $("#order").val(order);
        $("#sizeFilterForm").submit();
    });

    //categories filter
    $("input[name='categories']").on('change', function() {
        var selectedCategories = [];
        $("input[name='categories']:checked").each(function() {
            selectedCategories.push($(this).val());
        });
        $("#hidden_categories").val(selectedCategories.join(','));
        $("#sizeFilterForm").submit();
    });
});
</script>
@endpush