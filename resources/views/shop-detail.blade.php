@extends('layouts.app')
@section('main-content')
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
                    <span class="old-price">{{$currency}} {{$product->regular_price}}</span>
                    <span class="new-price">{{$currency}} {{$product->sale_price}}</span>
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
                    @if(Cart::instance('cart')->content()->Where('id',$product->id)->count()>0)
                        <a href="{{route('cart.index')}}" class="btn btn-primary mb-3">Go to Cart</a>
                    @else
                    <form name="addtocart-form" action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <div class="product-single-qty">
                            <input class="horizontal-quantity form-control" type="text" name="quantity" value="1" readonly>
                        </div>
                        <!-- End .product-single-qty -->
                        <input type="hidden" name="id" value="{{$product->id}}" />
                        <input type="hidden" name="name" value="{{$product->name}}" />
                        <input type="hidden" name="price" value="{{$product->sale_price == '' ? $product->regular_price:$product->sale_price}}" />  
                        <button type="submit" class="btn btn-dark mr-2" title="Add to Cart">Add to Cart</button>
                    </form>
                    @endif
                </div>
                <!-- End .product-action -->

                <hr class="divider mb-0 mt-0">

                <div class="product-single-share mb-3">
                    <label class="sr-only">Share:</label>

                    <div class="social-icons mr-2">
                        <a href="#" class="social-icon social-facebook icon-facebook" target="_blank" title="Facebook"></a>
                        <a href="#" class="social-icon social-twitter icon-twitter" target="_blank" title="Twitter"></a>
                        <a href="#" class="social-icon social-linkedin fab fa-linkedin-in" target="_blank" title="Linkedin"></a>
                        <a href="#" class="social-icon social-gplus fab fa-google-plus-g" target="_blank" title="Google +"></a>
                        <a href="#" class="social-icon social-mail icon-mail-alt" target="_blank" title="Mail"></a>
                    </div>
                    <!-- End .social-icons -->

                    <a href="wishlist.html" class="btn-icon-wish add-wishlist" title="Add to Wishlist"><i
                            class="icon-wishlist-2"></i><span>Add to
                            Wishlist</span></a>
                </div>
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