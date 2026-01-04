@extends('layouts.app')
@section('main-content')
<main class="main">
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
        </nav>
        <div class="row">
            <div class="col-lg-9">
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
                                <a href="{{ $banner->button_link }}" class="btn btn-sm btn-dark">{{ $banner->button_text }}</a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <nav class="toolbox sticky-header mt-2" data-sticky-options="{'mobile': true}">
                    <div class="toolbox-left">
                        <a href="#" class="sidebar-toggle"><svg data-name="Layer 3" id="Layer_3"
                                viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <line x1="15" x2="26" y1="9" y2="9" class="cls-1"></line>
                                <line x1="6" x2="9" y1="9" y2="9" class="cls-1"></line>
                                <line x1="23" x2="26" y1="16" y2="16" class="cls-1"></line>
                                <line x1="6" x2="17" y1="16" y2="16" class="cls-1"></line>
                                <line x1="17" x2="26" y1="23" y2="23" class="cls-1"></line>
                                <line x1="6" x2="11" y1="23" y2="23" class="cls-1"></line>
                                <path
                                    d="M14.5,8.92A2.6,2.6,0,0,1,12,11.5,2.6,2.6,0,0,1,9.5,8.92a2.5,2.5,0,0,1,5,0Z"
                                    class="cls-2"></path>
                                <path d="M22.5,15.92a2.5,2.5,0,1,1-5,0,2.5,2.5,0,0,1,5,0Z" class="cls-2"></path>
                                <path d="M21,16a1,1,0,1,1-2,0,1,1,0,0,1,2,0Z" class="cls-3"></path>
                                <path
                                    d="M16.5,22.92A2.6,2.6,0,0,1,14,25.5a2.6,2.6,0,0,1-2.5-2.58,2.5,2.5,0,0,1,5,0Z"
                                    class="cls-2"></path>
                            </svg>
                            <span>Filter</span>
                        </a>

                        <div class="toolbox-item toolbox-sort">
                            <label>Sort By:</label>

                            <div class="select-custom">
                                <select name="orderby" class="form-control" name="orderby" id="orderby">
                                    <option value="-1" {{$orderby == -1 ? 'selected':''}} selected>Default sorting</option>
                                    <option value="1" {{$orderby == 1 ? 'selected':''}}>Date, New to Old</option>
                                    <option value="2" {{$orderby == 2 ? 'selected':''}}>Date, Old to New</option>
                                    <option value="3" {{$orderby == 3 ? 'selected':''}}>Price, Low to High</option>
                                    <option value="4" {{$orderby == 4 ? 'selected':''}}>Price, High to Low</option>
                                </select>
                            </div>
                            <!-- End .select-custom -->
                        </div>
                        <!-- End .toolbox-item -->
                    </div>
                    <!-- End .toolbox-left -->

                    <div class="toolbox-right">
                        <div class="toolbox-item toolbox-show">
                            <label>Show:</label>

                            <div class="select-custom">
                                <select name="count" class="form-control" id="pagesize" name="pagesize">
                                    <option value="12" {{ $size == 12 ? 'selected': '' }}>12</option>
                                    <option value="24" {{ $size == 24 ? 'selected': '' }}>24</option>
                                    <option value="48" {{ $size == 48 ? 'selected': '' }}>48</option>
                                    <option value="102" {{ $size == 102 ? 'selected': '' }}>102</option>
                                </select>
                            </div>
                            <!-- End .select-custom -->
                        </div>
                        <!-- End .toolbox-item -->
                    </div>
                    <!-- End .toolbox-right -->
                </nav>
                <!-- Products Row -->
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-6 col-sm-4">
                        <div class="product-default">
                            <figure>
                                <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">
                                    <img loading="lazy" src="{{asset('backend/uploads/products')}}/{{$product->image}}" width="280" height="280" alt="{{$product->name}}" />
                                </a>
                            </figure>
                            <div class="product-details">
                                <h3 class="product-title">
                                    <a href="{{ route('shop.product.details', ['product_slug' => $product->slug]) }}">{{$product->name}}</a>
                                </h3>
                                <div class="price-box">
                                    @if($product->sale_price)
                                        <span class="old-price">{{ $currency }}{{ number_format($product->regular_price, 0, '.', ',') }}</span>
                                        <span class="product-price">{{ $currency }}{{ number_format($product->sale_price, 0, '.', ',') }}</span>
                                    @else
                                        <span class="old-price">{{ $currency }}{{ number_format($product->regular_price, 0, '.', ',') }}</span>
                                    @endif
                                </div>
                                <div class="product-action">
                                    @if(Cart::instance('cart')->content()->Where('id',$product->id)->count()>0)
                                    <a href="{{route('cart.index')}}" class="btn-icon btn-primary btn-add-cart1">
                                        <i class="icon-shopping-cart"></i>GO TO CART
                                    </a>
                                    @else
                                    <form name="addtocart-form" method="POST" action="{{route('cart.add')}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$product->id}}" />
                                        <input type="hidden" name="quantity" value="1" />
                                        <input type="hidden" name="name" value="{{$product->name}}" />
                                        <input type="hidden" name="price" value="{{$product->sale_price == '' ? $product->regular_price:$product->sale_price}}" />
                                        <button type="submit" class="btn-icon btn-add-cart1 product-type-simple">
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
                    <ul class="pagination toolbox-item">
                        {{$products->withQueryString()->links('pagination::bootstrap-5')}}
                    </ul>
                </nav>
            </div>
            <!-- End .col-lg-9 -->

            <div class="sidebar-overlay"></div>
            <aside class="sidebar-shop col-lg-3 order-lg-first mobile-sidebar">
                <div class="sidebar-wrapper">
                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">Categories</a>
                        </h3>

                        <div class="collapse show" id="widget-body-2">
                            <div class="widget-body">
                                <ul class="cat-list">
                                    @foreach($categories as $category)
                                        <li>
                                            <label class="cursor-pointer">
                                                <input type="checkbox" class="mr-1" name="categories" value="{{ $category->id }}"
                                                    @if(in_array($category->id, $filter_categories)) checked @endif
                                                />
                                                {{ $category->name }}
                                                <span class="products-count">({{ $category->products_count }})</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End .widget-body -->
                        </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->

                    <div class="widget">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true" aria-controls="widget-body-3">Price</a>
                        </h3>
                        <div class="collapse show" id="widget-body-3">
                                    <div class="widget-body pb-0">
                                        <div class="price-slider-wrapper">
                                            <div id="price-slider"></div>
                                            <!-- End #price-slider -->
                                        </div>
                                        <!-- End .price-slider-wrapper -->

                                        <div class="filter-price-action d-flex align-items-center justify-content-between flex-wrap">
                                            <div class="filter-price-text">
                                                Price:
                                                <span id="filter-price-range"></span>
                                            </div>
                                            <!-- End .filter-price-text -->
                                            <a href="{{ route('shop.index') }}" class="btn btn-primary font2">Reset</a>
                                        </div>
                                        <!-- End .filter-price-action -->
                                    </div>
                                    <!-- End .widget-body -->
                                </div>
                        <!-- End .collapse -->
                    </div>
                    <!-- End .widget -->
                    <!-- End .widget -->
                </div>
                <!-- End .sidebar-wrapper -->
            </aside>
            <!-- End .col-lg-3 -->
        </div>
        <!-- End .row -->
    </div>
    <!-- End .container -->

    <div class="mb-4"></div>
    <!-- margin -->
</main>
<form id="sizeFilterForm" method="GET" action="{{ route('shop.index') }}">
    <input type="hidden" name="page" id="page" value="{{ $products->currentPage() }}">
    <input type="hidden" name="size" id="size" value="{{ $size }}">
    <input type="hidden" name="order" id="order" value="{{ $orderby }}">
    <input type="hidden" name="categories" id="hidden_categories">
    <input type="hidden" name="min_price" id="min_price" value="{{ $min_price }}">
    <input type="hidden" name="max_price" id="max_price" value="{{ $max_price }}">
</form>
<!-- End .main -->
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
        let url = $form.attr('action');
        let formData = $form.serialize(); // serialize hidden inputs
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
                $form.replaceWith(`
                    <a href="${window.cartIndexUrl}" class="btn-icon btn-primary btn-add-cart1" style="color: #fff;background:#154821;border-color:#154821;">
                        <i class="icon-shopping-cart"></i> GO TO CART
                    </a>
                `);
                Swal.fire(
                    'Added!',
                    response.message,
                    'success'
                );
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire(
                    'Error',
                    'Failed to add product to cart.',
                    'error'
                );
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