@extends('layouts.app')
@section('main-content')
<main class="main bg-gray">
    <section class="intro-section">
        <div class="home-slider owl-carousel owl-theme loaded slide-animate mb-4" data-owl-options="{
            'nav': false,
            'lazyLoad': false
        }">
            @forelse ($homeSliders ?? HomeSlider::where('status', true)->orderBy('sort_order')->orderBy('id', 'desc')->get() as $slide)
            <div class="home-slide banner" style="background-color: {{ $slide->bg_color }};">
                <figure>
                    <img src="{{ asset('backend/uploads/sliders/' . $slide->image) }}" alt="{{ $slide->title }}" width="1903" height="520">
                </figure>

                <div class="banner-layer banner-layer-middle banner-layer-{{ $slide->text_position == 'right' ? 'right' : 'left' }}">
                    @if($slide->title)
                    <h4 class="font-weight-normal text-body m-b-2 appear-animate" data-animation-name="fadeInDownShorter" data-animation-delay="100">
                        Exclusive Product New Arrival
                    </h4>
                    <h2 class="appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="600">
                        {{ $slide->title }}
                    </h2>
                    @endif

                    @if($slide->subtitle || $slide->short_text)
                    <div class="position-relative appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="1100">
                        @if($slide->subtitle)<h3 class="text-uppercase">{{ $slide->subtitle }}</h3>@endif
                        @if($slide->short_text)<h5 class="rotate-text font-weight-normal text-primary">{{ $slide->short_text }}</h5>@endif
                    </div>
                    @endif

                    @if($slide->description)
                    <p class="font2 text-right text-uppercase appear-animate" data-animation-name="fadeInUpShorter" data-animation-delay="1400">
                        {{ $slide->description }}
                    </p>
                    @endif

                    @if($slide->offer_text)
                    <div class="coupon-sale-text m-b-2 appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="1800">
                        <h6 class="text-uppercase text-right mb-0">
                            <sup>up to</sup><strong class="text-white">{{ $slide->offer_text }}</strong>
                        </h6>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <!-- Optional fallback static slide if no sliders -->
            @endforelse
        </div>
    </section>

    <section class="popular-section">
        <div class="container">
            <div class="info-boxes-slider owl-carousel" data-owl-options="{
                'items': 1,
                'margin': 0,
                'dots': false,
                'loop': false,
                'autoHeight': true,
                'responsive': {
                    '576': {
                        'items': 2
                    },
                    '768': {
                        'items': 3
                    },
                    '1200': {
                        'items': 4
                    }
                }
            }">
                <div class="info-box info-box-icon-left">
                    <i class="icon-shipping text-primary"></i>
                    <div class="info-content">
                        <h4 class="ls-n-25">Express Shipping to all statesg</h4>
                        <p class="font2 font-weight-light text-body ls-10">GIG and local carriers.
                        </p>
                    </div>
                </div>
                <div class="info-box info-box-icon-left">
                    <i class="icon-credit-card text-primary"></i>
                    <div class="info-content">
                        <h4 class="ls-n-25">Money Back Guarantee</h4>
                        <p class="font2 font-weight-light text-body ls-10">100% money back guarantee</p>
                    </div>
                </div>
                <div class="info-box info-box-icon-left">
                    <i class="icon-support text-primary"></i>
                    <div class="info-content">
                        <h4 class="ls-n-25">Online Support 24/7</h4>
                        <p class="font2 font-weight-light text-body ls-10">Our support lines are active always.</p>
                    </div>
                </div>
                <div class="info-box info-box-icon-left">
                    <i class="icon-secure-payment text-primary"></i>
                    <div class="info-content">
                        <h4 class="ls-n-25">Secure Payment</h4>
                        <p class="font2 font-weight-light text-body ls-10">Safe and secure payments.</p>
                    </div>
                </div>
            </div>

            <h2 class="section-title">Popular Products</h2><br>
            <div class="categories-slider owl-carousel owl-theme mb-4 appear-animate" 
                data-owl-options='{ "items":1, "responsive":{"576":{"items":2},"768":{"items":3},"992":{"items":4}} }'
                data-animation-name="fadeInUpShorter" data-animation-delay="200">
                @forelse($popularCategoryItems as $item)
                    <div class="product-category bg-white">
                        <a href="{{ $item->link_url }}">
                            <figure>
                                <img src="{{ asset('backend/uploads/popular-categories/' . $item->image) }}" 
                                    alt="{{ $item->title }}" width="341" height="200">
                            </figure>
                            <div class="category-content">
                                <h3 class="font2 ls-n-25">{{ $item->title }}</h3>
                                <span class="font2 ls-n-20">{{ $item->count_text }}</span>
                            </div>
                        </a>
                    </div>
                @empty
                    <!-- Fallback static items here if needed -->
                @endforelse
            </div>

            <div class="appear-animate" data-animation-name="fadeIn" data-animation-delay="200">
                <h2 class="section-title">Hot Deals</h2><br>
                <div class="products-container product-slider-tab rounded">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="all">
                            <div class="products-slider owl-carousel owl-theme nav-outer" data-owl-options="{
                                'dots': false,
                                'nav': true,
                                'margin': 0,
                                'responsive': {
                                    '576': {'items': 3},
                                    '768': {'items': 4},
                                    '1200': {'items': 6}
                                }
                            }">
                                @forelse($hotDeals as $deal)
                                    @if($deal->product)
                                    <div class="product-default inner-quickview inner-icon">
                                        <figure>
                                            <a href="{{ route('shop.product.details', $deal->product->slug) }}">
                                                <img src="{{ asset('backend/uploads/products/' . $deal->product->image) }}"
                                                    width="217" height="217"
                                                    alt="{{ $deal->product->name }}">
                                            </a>
                                            @if($deal->show_hot_label)
                                            <div class="label-group">
                                                <div class="product-label label-hot">HOT</div>
                                            </div>
                                            @endif
                                            <div class="btn-icon-group">
                                                <a href="{{ route('shop.product.details', $deal->product->slug) }}" 
                                                class="btn-icon btn-add-cart">
                                                    <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </div>
                                            <a href="{{ route('shop.product.details', $deal->product->slug) }}" class="btn-quickview" title="Quick View">
                                                View
                                            </a>
                                        </figure>
                                        <div class="product-details">
                                            <div class="category-wrap">
                                                <div class="category-list">
                                                    @if($deal->product->category)
                                                        <a href="{{ route('shop.index') }}?categories={{ $deal->product->category->id }}" class="product-category">{{ $deal->product->category->name }}</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <h3 class="product-title">
                                                <a href="{{ route('shop.product.details', $deal->product->slug) }}">
                                                    {{ $deal->product->name }}
                                                </a>
                                            </h3>
                                            <div class="price-box">
                                                <span class="product-price">{{ $currency }} {{ number_format($deal->product->sale_price ?? 0, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @empty
                                    <p class="text-center py-4 w-100">No hot deals available.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="special-section ">
        <div class="container">
            <div class="row">
                @if($leftBanner)
                <div class="col-md-8">
                    <div class="banner banner1 rounded m-b-4" style="background-color: #d9e1e1;">
                        <figure>
                            <img src="{{ asset('backend/uploads/banners/' . $leftBanner->image) }}" alt="banner" width="939" height="235">
                        </figure>
                        <div class="banner-layer banner-layer-middle banner-layer-right">
                            <h4 class="font-weight-normal text-body">{{ $leftBanner->title }}</h4>
                            <h2 class="m-l-n-1 p-r-5 m-r-2">{{ $leftBanner->subtitle }}</h2>
                            <div class="position-relative">
                                <h3 class="text-uppercase">{{ $leftBanner->description }}</h3>
                                <h5 class="rotate-text font-weight-normal text-primary">{{ $leftBanner->short_text }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($rightBanner)
                <div class="col-md-4">
                    <div class="banner banner2 rounded mb-3" style="background-color: #b28475;">
                        <figure>
                            <img src="{{ asset('backend/uploads/banners/' . $rightBanner->image) }}" alt="banner" width="460" height="235">
                        </figure>
                        <div class="banner-layer banner-layer-middle banner-layer-right">
                            <h4 class="font-weight-normal text-white">{{ $rightBanner->title }}</h4>
                            <h2 class="text-white">{{ $rightBanner->subtitle }}</h2>
                            <h3 class="text-white text-uppercase mb-2">{{ $rightBanner->description }}</h3>
                            <h5 class="font-weight-normal text-white mb-0">{{ $rightBanner->short_text }}</h5>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <h2 class="section-title">Top Sellers</h2><br>
            <div class="row offer-products">
                @if($featuredSeller)
                <div class="col-md-4 appear-animate" data-animation-name="fadeInRightShorter" data-animation-delay="100">
                    <div class="count-deal bg-white rounded mb-md-0">
                        <div class="product-default">
                            <figure>
                                <a href="{{ route('shop.product.details', $featuredSeller->slug ?? $featuredSeller->id) }}">
                                    <img src="{{ asset('backend/uploads/products/' . $featuredSeller->image) }}" 
                                        alt="{{ $featuredSeller->name }}" 
                                        width="1200" 
                                        height="1200"
                                        class="w-100">
                                </a>
                            </figure><br><br>
                            <div class="product-details">
                                <div class="category-list">
                                    <a href="{{ route('shop.index') }}?categories={{ $featuredSeller->category->id }}" class="product-category">
                                        {{ $featuredSeller->category->name ?? 'Category' }}
                                    </a>
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('shop.product.details', $featuredSeller->slug ?? $featuredSeller->id) }}">
                                        {{ Str::limit($featuredSeller->name, 30) }}
                                    </a>
                                </h3>
                                <div class="price-box">
                                    @if($featuredSeller->regular_price && $featuredSeller->sale_price && $featuredSeller->regular_price > $featuredSeller->sale_price)
                                        <del class="old-price">{{ $currency }}{{ number_format($featuredSeller->regular_price, 2) }}</del>
                                        <span class="product-price">{{ $currency }}{{ number_format($featuredSeller->sale_price, 2) }}</span>
                                    @else
                                        <span class="product-price">{{ $currency }}{{ number_format($featuredSeller->regular_price ?? $featuredSeller->sale_price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="product-action">
                                    <a href="{{ route('shop.product.details', $featuredSeller->slug ?? $featuredSeller->id) }}" 
                                    class="btn-icon btn-add-cart product-type-simple">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($gridSellers->count() > 0)
                <div class="col-md-8 appear-animate" data-animation-name="fadeInLeftShorter" data-animation-delay="300">
                    <div class="custom-products bg-white rounded">
                        <div class="row">
                            @foreach($gridSellers as $seller)
                            <div class="col-6 col-sm-4 col-xl-3">
                                <div class="product-default inner-quickview inner-icon">
                                    <figure>
                                        <a href="{{ route('shop.product.details', $seller->slug ?? $seller->id) }}">
                                            <img src="{{ asset('backend/uploads/products/' . $seller->image) }}" 
                                                width="217" 
                                                height="217" 
                                                alt="{{ $seller->name }}"
                                                class="w-100">
                                        </a>
                                        @if($seller->regular_price && $seller->sale_price && $seller->regular_price > $seller->sale_price)
                                            @php
                                                $discount = round((($seller->regular_price - $seller->sale_price) / $seller->regular_price) * 100);
                                            @endphp
                                            <div class="label-group">
                                                <div class="product-label label-sale">-{{ $discount }}%</div>
                                            </div>
                                        @endif
                                        <div class="btn-icon-group">
                                            <a href="#" class="btn-icon btn-add-cart product-type-simple" 
                                            data-product-id="{{ $seller->id }}">
                                                <i class="icon-shopping-cart"></i>
                                            </a>
                                        </div>
                                        <a href="{{ route('shop.product.details', $seller->slug ?? $seller->id) }}" class="btn-quickview" title="Quick View" data-product-id="{{ $seller->id }}">
                                            View
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="category-wrap">
                                            <div class="category-list">
                                                <a href="{{ route('shop.index') }}?categories={{ $seller->category->id }}" class="product-category">
                                                    {{ Str::limit($seller->category->name ?? 'Category', 15) }}
                                                </a>
                                            </div>
                                        </div>
                                        <h3 class="product-title">
                                            <a href="{{ route('shop.product.details', $seller->slug ?? $seller->id) }}">
                                                {{ Str::limit($seller->name, 25) }}
                                            </a>
                                        </h3>
                                        <div class="price-box">
                                            @if($seller->regular_price && $seller->sale_price && $seller->regular_price > $seller->sale_price)
                                                <span class="old-price">{{ $currency }}{{ number_format($seller->regular_price, 2) }}</span>
                                                <span class="product-price">{{ $currency }}{{ number_format($seller->sale_price, 2) }}</span>
                                            @else
                                                <span class="product-price">{{ $currency }}{{ number_format($seller->regular_price ?? $seller->sale_price, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section><br>
</main>
<!-- End .main -->
@endsection