<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Fridah's Spice</title>
        <meta name="keywords" content="Fridah's Spice" />
        <meta name="description" content="Fridah's Spice - Your one-stop shop for all spices" />
        <meta name="author" content="SW-THEMES">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/icons/favicon') }}">

        <script>
            WebFontConfig = {
                google: {
                    families: ['Open+Sans:300,400,600,700,800', 'Poppins:200,300,400,500,600,700,800', 'Oswald:300,400,500,600,700,800']
                }
            };
            (function(d) {
                var wf = d.createElement('script'),
                    s = d.scripts[0];
                wf.src = '{{ asset("assets/js/webfont.js") }}';
                wf.async = true;
                s.parentNode.insertBefore(wf, s);
            })(document);
        </script>

        <!-- Plugins CSS File -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!-- Main CSS File -->
        <link rel="stylesheet" href="{{ asset('assets/css/demo35.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
        @stack("styles")
    </head>
    <body>
        <div class="loading-overlay">
            <div class="bounce-loader">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>

        <div class="page-wrapper">
            <header class="header">
                <div class="header-top">
                    <div class="container">
                        <div class="header-left d-none d-xl-block">
                            <div class="info-box info-box-icon-left p-0">
                                <i class="icon-shipping text-primary"></i>

                                <div class="info-box-content0">
                                    <h4 class="mb-0">FREE Express Shipping On Orders $99+</h4>
                                </div>
                                <!-- End .info-box-content -->
                            </div>
                            <!-- End .info-box -->
                        </div>
                        <!-- End .header-left -->

                        <div class="header-right header-dropdowns">
                            <div class="header-dropdown font2">
                                <a href="#">USD</a>
                                <div class="header-menu">
                                    <ul>
                                        <li><a href="#">EUR</a></li>
                                        <li><a href="#">USD</a></li>
                                    </ul>
                                </div>
                                <!-- End .header-menu -->
                            </div>
                            <!-- End .header-dropown -->

                            <div class="header-dropdown mr-4 pl-2 font2">
                                <a href="#">ENG</a>
                                <div class="header-menu">
                                    <ul>
                                        <li><a href="#">ENG</a>
                                        </li>
                                        <li><a href="#">FRH</a></li>
                                    </ul>
                                </div>
                                <!-- End .header-menu -->
                            </div>
                            <!-- End .header-dropown -->

                            <div class="separator d-none d-lg-inline"></div>

                            <div class="header-dropdown dropdown-expanded d-none d-lg-block">
                                <a href="#">Links</a>
                                <div class="header-menu">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <i class="icon-pin"></i> Our Stores
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-shipping-truck"></i> Track Your Order
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="icon-help-circle"></i> Help
                                            </a>
                                        </li>
                                        <li>
                                            <a href="wishlist.html">
                                                <i class="icon-wishlist-2"></i> Wishlist
                                            </a>
                                        </li>
                                        @guest
                                        <li>
                                            <a href="{{route('login')}}">
                                                <i class="icon-user-2"></i> Login/Register
                                            </a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{ Auth::user()->user_type == 'admin' ? route('admin.index') : route('user.index') }}">
                                                <i class="icon-user-2"></i> {{ Auth::user()->name }}
                                            </a>
                                        </li>
                                        @endguest
                                    </ul>
                                </div>
                            </div>

                            <span class="separator d-none d-lg-inline"></span>

                            <div class="social-icons">
                                <a href="#" class="social-icon social-instagram icon-instagram" target="_blank"></a>
                                <a href="#" class="social-icon social-twitter icon-twitter" target="_blank"></a>
                                <a href="#" class="social-icon social-facebook icon-facebook" target="_blank"></a>
                            </div>
                            <!-- End .social-icons -->
                        </div>
                        <!-- End .header-right -->
                    </div>
                    <!-- End .container -->
                </div>
                <!-- End .header-top -->

                <div class="header-middle sticky-header" data-sticky-options="{'mobile': true}">
                    <div class="container">
                        <div class="header-left w-lg-max">
                            <button class="mobile-menu-toggler text-primary mr-2" type="button">
                                <i class="fas fa-bars"></i>
                            </button>
                            <a href="{{ route('index') }}" class="logo">
                                <img src="{{ asset('assets/images/logo-black.png') }}" class="w-100" width="111" height="44" alt="Porto Logo">
                            </a>
                            <div class="header-icon header-search header-search-inline header-search-category d-lg-block d-none text-right mt-0">
                                <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                                <form action="#" method="get">
                                    <div class="header-search-wrapper">
                                        <input type="search" class="form-control" name="q" id="q" placeholder="Search..." required>
                                        <div class="select-custom">
                                            <select id="cat" name="cat">
                                                <option value="">All Categories</option>
                                                <option value="4">Fashion</option>
                                                <option value="12">- Women</option>
                                                <option value="13">- Men</option>
                                                <option value="66">- Jewellery</option>
                                                <option value="67">- Kids Fashion</option>
                                                <option value="5">Electronics</option>
                                                <option value="21">- Smart TVs</option>
                                                <option value="22">- Cameras</option>
                                                <option value="63">- Games</option>
                                                <option value="7">Home &amp; Garden</option>
                                                <option value="11">Motors</option>
                                                <option value="31">- Cars and Trucks</option>
                                                <option value="32">- Motorcycles &amp; Powersports</option>
                                                <option value="33">- Parts &amp; Accessories</option>
                                                <option value="34">- Boats</option>
                                                <option value="57">- Auto Tools &amp; Supplies</option>
                                            </select>
                                        </div>
                                        <!-- End .select-custom -->
                                        <button class="btn icon-magnifier p-0" title="search" type="submit"></button>
                                    </div>
                                    <!-- End .header-search-wrapper -->
                                </form>
                            </div>
                            <!-- End .header-search -->
                        </div>
                        <!-- End .header-left -->

                        <div class="header-right">

                            <a href="wishlist.html" class="header-icon position-relative d-lg-none mr-2">
                                <i class="icon-wishlist-2"></i>
                                <span class="badge-circle">0</span>
                            </a>

                            <div class="cart-dropdown-wrapper d-flex align-items-center">
                                <div class="dropdown cart-dropdown">
                                    <a href="#" title="Cart" class="dropdown-toggle cart-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                        <i class="icon-cart-thick"></i>
                                        <span class=" cart-count badge-circle">3</span>
                                    </a>

                                    <div class="cart-overlay"></div>

                                    <div class="dropdown-menu mobile-cart">
                                        <a href="#" title="Close (Esc)" class="btn-close">×</a>

                                        <div class="dropdownmenu-wrapper custom-scrollbar">
                                            <div class="dropdown-cart-header">Shopping Cart</div>
                                            <!-- End .dropdown-cart-header -->

                                            <div class="dropdown-cart-products">
                                                <div class="product">
                                                    <div class="product-details">
                                                        <h4 class="product-title">
                                                            <a href="demo35-product.html">Ultimate 3D Bluetooth Speaker</a>
                                                        </h4>

                                                        <span class="cart-product-info">
                                                            <span class="cart-product-qty">1</span> × $99.00
                                                        </span>
                                                    </div>
                                                    <!-- End .product-details -->

                                                    <figure class="product-image-container">
                                                        <a href="demo35-product.html" class="product-image">
                                                            <img src="{{ asset('assets/images/products/product-1.jpg')  }}" alt="product" width="80" height="80">
                                                        </a>

                                                        <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                                    </figure>
                                                </div>
                                                <!-- End .product -->

                                                <div class="product">
                                                    <div class="product-details">
                                                        <h4 class="product-title">
                                                            <a href="demo35-product.html">Brown Women Casual HandBag</a>
                                                        </h4>

                                                        <span class="cart-product-info">
                                                            <span class="cart-product-qty">1</span> × $35.00
                                                        </span>
                                                    </div>
                                                    <!-- End .product-details -->

                                                    <figure class="product-image-container">
                                                        <a href="demo35-product.html" class="product-image">
                                                            <img src="{{ asset('assets/images/products/product-2.jpg')  }}" alt="product" width="80" height="80">
                                                        </a>

                                                        <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                                    </figure>
                                                </div>
                                                <!-- End .product -->

                                                <div class="product">
                                                    <div class="product-details">
                                                        <h4 class="product-title">
                                                            <a href="demo35-product.html">Circled Ultimate 3D Speaker</a>
                                                        </h4>

                                                        <span class="cart-product-info">
                                                            <span class="cart-product-qty">1</span> × $35.00
                                                        </span>
                                                    </div>
                                                    <!-- End .product-details -->

                                                    <figure class="product-image-container">
                                                        <a href="demo35-product.html" class="product-image">
                                                            <img src="{{ asset('assets/images/products/product-3.jpg')  }}" alt="product" width="80" height="80">
                                                        </a>
                                                        <a href="#" class="btn-remove" title="Remove Product"><span>×</span></a>
                                                    </figure>
                                                </div>
                                                <!-- End .product -->
                                            </div>
                                            <!-- End .cart-product -->

                                            <div class="dropdown-cart-total">
                                                <span>SUBTOTAL:</span>

                                                <span class="cart-total-price float-right">$134.00</span>
                                            </div>
                                            <!-- End .dropdown-cart-total -->

                                            <div class="dropdown-cart-action">
                                                <a href="cart.html" class="btn btn-gray btn-block view-cart">View
                                                    Cart</a>
                                                <a href="checkout.html" class="btn btn-dark btn-block">Checkout</a>
                                            </div>
                                            <!-- End .dropdown-cart-total -->
                                        </div>
                                        <!-- End .dropdownmenu-wrapper -->
                                    </div>
                                    <!-- End .dropdown-menu -->
                                </div>
                                <!-- End .dropdown -->

                                <span class="cart-subtotal font2 d-none d-sm-inline">Shopping Cart
                                    <span class="cart-price d-block font2">$0.00</span>
                                </span>
                            </div>
                        </div>
                        <!-- End .header-right -->
                    </div>
                    <!-- End .container -->
                </div>
                <!-- End .header-middle -->

                <div class="header-bottom sticky-header d-none d-lg-flex" data-sticky-options="{'mobile': false}">
                    <div class="container">
                        <div class="header-center w-100 ml-0">
                            <nav class="main-nav d-flex font2">
                                <div class="menu-depart">
                                    <a href="{{ route('index') }}"><i class="fa fa-bars align-middle mr-3"></i>All
                                        Departments</a>
                                    <ul class="menu menu-vertical">
                                        <li>
                                            <a href="#"><i class="icon-category-fashion"></i>Fashion</a>
                                            <span class="menu-btn"></span>
                                            <div class="megamenu megamenu-fixed-width megamenu-one">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-1">
                                                                <a href="#" class="nolink pl-0">Woman</a>
                                                                <ul class="submenu">
                                                                    <li><a href="{{ route('index') }}">Tops &amp; Blouses</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Accessories</a></li>
                                                                    <li><a href="{{ route('index') }}">Dresses &amp; Skirts</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Shoes &amp; Boots</a>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-md-6 mb-1">
                                                                <a href="#" class="nolink pl-0">Men</a>
                                                                <ul class="submenu">
                                                                    <li><a href="{{ route('index') }}">Accessories</a></li>
                                                                    <li><a href="{{ route('index') }}">Watch Fashion</a></li>
                                                                    <li><a href="{{ route('index') }}">Tees, Knits &amp;
                                                                            Polos</a></li>
                                                                    <li><a href="{{ route('index') }}">Paints &amp; Denim</a>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-md-6 mb-1">
                                                                <a href="#" class="nolink pl-0">Jewellery</a>
                                                                <ul class="submenu">
                                                                    <li><a href="{{ route('index') }}">Sweaters</a></li>
                                                                    <li><a href="{{ route('index') }}">Heels &amp; Sandals</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Jeans &amp; Shorts</a>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-md-6 mb-1">
                                                                <a href="#" class="nolink pl-0">Kids Fashion</a>
                                                                <ul class="submenu">
                                                                    <li><a href="{{ route('index') }}">Casual Shoes</a></li>
                                                                    <li><a href="{{ route('index') }}">Spring &amp; Autumn</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Winter Sneakers</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 text-right">
                                                        <div class="menu-banner menu-banner-2 d-inline-block position-relative h-auto">
                                                            <figure class="text-right">
                                                                <img src="{{ asset('assets/images/demoes/demo35/menu-banner-1.jpg')  }}" alt="Menu banner" class="product-promo d-inline-block" width="300" height="383">
                                                            </figure>
                                                            <i>OFF</i>
                                                            <div class="banner-content text-left">
                                                                <h4>
                                                                    <span class="text-dark">UP TO</span><br />
                                                                    <b class="text-dark">50%</b>
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row px-5">
                                                    <div class="col-lg-12">
                                                        <div class="partners-container mb-2">
                                                            <div class="owl-carousel owl-theme" data-owl-options="{
                                                                'dots': false,
                                                                'items': 4,
                                                                'margin': 20,
                                                                'responsive': {
                                                                    '1200': {
                                                                        'items': 5
                                                                    }
                                                                }
                                                            }">
                                                                <div class="partner">
                                                                    <img src="{{ asset('assets/images/brands/small/brand1.png') }}" alt="logo image" width="140" height="60">
                                                                </div>
                                                                <div class="partner">
                                                                    <img src="{{ asset('assets/images/brands/small/brand2.png')  }}" alt="logo image" width="140" height="60">
                                                                </div>
                                                                <div class="partner">
                                                                    <img src="{{ asset('assets/images/brands/small/brand3.png')  }}" alt="logo image" width="140" height="60">
                                                                </div>
                                                                <div class="partner">
                                                                    <img src="{{ asset('assets/images/brands/small/brand4.png')  }}" alt="logo image" width="140" height="60">
                                                                </div>
                                                                <div class="partner">
                                                                    <img src="{{ asset('assets/images/brands/small/brand5.png')  }}" alt="logo image" width="140" height="60">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End .megamenu -->
                                        </li>
                                        <li>
                                            <a href="#"><i class="icon-category-electronics"></i>Electronics</a>
                                            <span class="menu-btn"></span>
                                            <div class="megamenu megamenu-fixed-width megamenu-two">
                                                <div class="row">
                                                    <div class="col-lg-3 mb-1">
                                                        <a href="#" class="nolink pl-0">ACCESSORIES</a>
                                                        <ul class="submenu">
                                                            <li><a href="{{ route('index') }}">Cables &amp; Adapters</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Electronic Cigarattes</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Batteries</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Chargers</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Home Electronic</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Bags &amp; Cases</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- End .col-lg-4 -->

                                                    <div class="col-lg-3 mb-1">
                                                        <a href="#" class="nolink pl-0">AUDIO &amp; VIDEO</a>
                                                        <ul class="submenu">
                                                            <li><a href="{{ route('index') }}">Televisions</a></li>
                                                            <li><a href="{{ route('index') }}">TV Receivers</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Projectors</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Audio Amplifier</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">TV SticksAmplifier</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- End .col-lg-4 -->

                                                    <div class="col-lg-3 mb-1">
                                                        <a href="#" class="nolink pl-0">CAMERA &amp; PHOTO</a>
                                                        <ul class="submenu">
                                                            <li><a href="{{ route('index') }}">Digital Cameras</a></li>
                                                            <li><a href="{{ route('index') }}">Camcorders</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Camera Drones</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Action Cameras</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Photo Supplies</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Camera &amp; Photo</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- End .col-lg-4 -->

                                                    <div class="col-lg-3 mb-1">
                                                        <a href="#" class="nolink pl-0">LAPTOPS</a>
                                                        <ul class="submenu">
                                                            <li><a href="{{ route('index') }}">Gaming Laptops</a></li>
                                                            <li><a href="{{ route('index') }}">Utraslim Laptops</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Tablets</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Laptop Accessories</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Tablet Accessories</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Laptop Bag &amp; Cases</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- End .col-lg-4 -->
                                                </div>
                                                <!-- End .row -->
                                                <div class="row px-5">
                                                    <div class="col-md-6">
                                                        <div class="banner menu-banner-3 banner-md-vw text-transform-none">
                                                            <figure>
                                                                <img src="{{ asset('assets/images/demoes/demo35/menu-banner-2.jpg')  }}" alt="banner">
                                                            </figure>

                                                            <div class="banner-layer banner-layer-middle d-flex align-items-center justify-content-end pt-0">
                                                                <div class="content-left">
                                                                    <h4 class="banner-layer-circle-item mb-0 ls-0">
                                                                        40<sup>%<small class="ls-0">OFF</small></sup>
                                                                    </h4>
                                                                </div>
                                                                <div class="content-right text-right">
                                                                    <h5 class=" ls-0"><del class="d-block m-b-2 text-secondary">$450</del>$270
                                                                    </h5>
                                                                    <h4 class="m-b-1 ls-n-25">Watches</h4>
                                                                    <h3 class="mb-0">HURRY UP!</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End .banner -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="banner menu-banner-4 banner-md-vw">
                                                            <figure>
                                                                <img src="{{ asset('assets/images/demoes/demo35/menu-banner-3.jpg')  }}" alt="banner">
                                                            </figure>

                                                            <div class="banner-layer banner-layer-middle d-flex align-items-end flex-column">
                                                                <h3 class="text-dark text-right">
                                                                    Electronic<br>Deals</h3>

                                                                <div class="coupon-sale-content">
                                                                    <h4 class="custom-coupon-sale-text bg-dark text-white d-block font1 text-transform-none">
                                                                        Exclusive COUPON
                                                                    </h4>
                                                                    <h5 class="custom-coupon-sale-text font1 text-dark ls-n-10 p-0">
                                                                        <b class="text-dark">$100</b> OFF
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End .banner -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End .megamenu -->
                                        </li>
                                        <li>
                                            <a href="#"><i class="icon-category-gifts"></i>Gifts</a>
                                            <span class="menu-btn"></span>

                                            <div class="megamenu megamenu-fixed-width megamenu-three">
                                                <div class="row">
                                                    <div class="col-lg-3 mb-1">
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('assets/images/demoes/demo35/icons/boy.png')  }}" alt="icon" width="50" height="68" />
                                                        </div>
                                                        <a href="#" class="nolink">FOR HIM</a>
                                                        <ul class="submenu pb-0">
                                                            <li><a href="{{ route('index') }}">Gifts for Boyfriend</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Gifts for Husband</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Gifts for Dad</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Gifts for Grandpa</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- End .col-lg-4 -->

                                                    <div class="col-lg-3 mb-1">
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('assets/images/demoes/demo35/icons/girl.png')  }}" alt="icon" width="50" height="68" />
                                                        </div>
                                                        <a href="#" class="nolink">FOR HER</a>
                                                        <ul class="submenu pb-0">
                                                            <li><a href="{{ route('index') }}">Gifts for Girlfriend</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Gifts for Wife</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Gifts for Mom</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Gifts for Grandma</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- End .col-lg-4 -->

                                                    <div class="col-lg-3 mb-1">
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('assets/images/demoes/demo35/icons/kid.png')  }}" alt="icon" width="50" height="68" />
                                                        </div>
                                                        <a href="#" class="nolink">FOR KIDS</a>
                                                        <ul class="submenu pb-0">
                                                            <li><a href="{{ route('index') }}">Gifts for Boys</a></li>
                                                            <li><a href="{{ route('index') }}">Gifts for Girls</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Gifts for Twin Boys</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Gifts for Twin Girls</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- End .col-lg-4 -->

                                                    <div class="col-lg-3 mb-1">
                                                        <div class="image-wrapper">
                                                            <img src="{{ asset('assets/images/demoes/demo35/icons/supermarket.png')  }}" alt="icon" width="50" height="68" />
                                                        </div>
                                                        <a href="#" class="nolink">BIRTHDAY</a>
                                                        <ul class="submenu pb-0">
                                                            <li><a href="{{ route('index') }}">Birthday for Him</a></li>
                                                            <li><a href="{{ route('index') }}">Birthday for Her</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Boyfriend Gifts</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Girlfriend Gifts</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- End .col-lg-4 -->
                                                </div>
                                                <!-- End .row -->
                                            </div>
                                            <!-- End .megamenu -->
                                        </li>
                                        <li>
                                            <a href="{{ route('index') }}"><i class="icon-category-garden"></i>Home & Garden</a>
                                            <span class="menu-btn"></span>
                                            <div class="megamenu megamenu-fixed-width megamenu-four">
                                                <div class="row p-0">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-1 pb-2">
                                                                <a href="#" class="nolink pl-0 d-lg-none d-block">VARIATION
                                                                    1</a>
                                                                <a href="#" class="nolink pl-0">FURNITURE</a>
                                                                <ul class="submenu m-b-4">
                                                                    <li><a href="{{ route('index') }}">Sofas & Couches</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Armchairs</a></li>
                                                                    <li><a href="{{ route('index') }}">Bed Frames</a></li>
                                                                    <li><a href="{{ route('index') }}">Beside Tables</a></li>
                                                                    <li><a href="{{ route('index') }}">Dressing Tables</a></li>
                                                                    <li><a href="{{ route('index') }}">Chest of Drawers</a></li>
                                                                </ul>

                                                                <a href="#" class="nolink pl-0">HOME ACCESSORIES</a>
                                                                <ul class="submenu m-b-4">
                                                                    <li><a href="{{ route('index') }}">Decorative
                                                                            Accessories</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Candles & Holders</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Home Fragrance</a></li>
                                                                    <li><a href="{{ route('index') }}">Mirrors</a></li>
                                                                    <li><a href="{{ route('index') }}">Clocks</a></li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <a href="#" class="nolink pl-0 d-lg-none d-block">VARIATION
                                                                    2</a>
                                                                <a href="#" class="nolink pl-0">LIGHTING</a>
                                                                <ul class="submenu m-b-4">
                                                                    <li><a href="{{ route('index') }}">Light Bulbs</a></li>
                                                                    <li><a href="{{ route('index') }}">Lamps</a></li>
                                                                    <li><a href="{{ route('index') }}">Celling Lights</a></li>
                                                                    <li><a href="{{ route('index') }}">Wall Lights</a></li>
                                                                    <li><a href="{{ route('index') }}">Bathroom Lighting</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Outdoor Lighting</a></li>
                                                                </ul>

                                                                <a href="#" class="nolink pl-0">GARDEN & OUTDOORS</a>
                                                                <ul class="submenu m-b-4">
                                                                    <li><a href="{{ route('index') }}">Garden Furniture</a></li>
                                                                    <li><a href="{{ route('index') }}">Lawn Mowers</a></li>
                                                                    <li><a href="{{ route('index') }}">Pressure Washers</a></li>
                                                                    <li><a href="{{ route('index') }}">All Garden Tools &
                                                                            Equipment</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Barbecue & Outdoor
                                                                            Dining</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 bg-gray">
                                                        <div class="product-widgets-container">
                                                            <div class="product-default left-details product-widget">
                                                                <figure>
                                                                    <a href="demo35-product.html">
                                                                        <img src="{{ asset('assets/images/demoes/demo35/products/small/product-1.jpg')  }}" width="84" height="84" alt="product">
                                                                    </a>
                                                                </figure>

                                                                <div class="product-details">
                                                                    <h3 class="product-title"> <a href="demo35-product.html">Temperos</a> </h3>

                                                                    <div class="ratings-container">
                                                                        <div class="product-ratings">
                                                                            <span class="ratings" style="width:0%"></span>
                                                                            <!-- End .ratings -->
                                                                            <span class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                        <!-- End .product-ratings -->
                                                                    </div>
                                                                    <!-- End .product-container -->

                                                                    <div class="price-box">
                                                                        <span class="product-price">$39.00</span>
                                                                    </div>
                                                                    <!-- End .price-box -->
                                                                </div>
                                                                <!-- End .product-details -->
                                                            </div>

                                                            <div class="product-default left-details product-widget">
                                                                <figure>
                                                                    <a href="demo35-product.html">
                                                                        <img src="{{ asset('assets/images/demoes/demo35/products/small/product-2.jpg')  }}" width="84" height="84" alt="product">
                                                                    </a>
                                                                </figure>

                                                                <div class="product-details">
                                                                    <h3 class="product-title"> <a href="demo35-product.html">Clasico</a> </h3>

                                                                    <div class="ratings-container">
                                                                        <div class="product-ratings">
                                                                            <span class="ratings" style="width:0%"></span>
                                                                            <!-- End .ratings -->
                                                                            <span class="tooltiptext tooltip-top">5.00</span>
                                                                        </div>
                                                                        <!-- End .product-ratings -->
                                                                    </div>
                                                                    <!-- End .product-container -->

                                                                    <div class="price-box">
                                                                        <span class="product-price">$119.00</span>
                                                                    </div>
                                                                    <!-- End .price-box -->
                                                                </div>
                                                                <!-- End .product-details -->
                                                            </div>

                                                            <div class="product-default left-details product-widget">
                                                                <figure>
                                                                    <a href="demo35-product.html">
                                                                        <img src="{{ asset('assets/images/demoes/demo35/products/small/product-3.jpg')  }}" width="84" height="84" alt="product">
                                                                    </a>
                                                                </figure>

                                                                <div class="product-details">
                                                                    <h3 class="product-title"> <a href="demo35-product.html">Coffee</a> </h3>

                                                                    <div class="ratings-container">
                                                                        <div class="product-ratings">
                                                                            <span class="ratings" style="width:100%"></span>
                                                                            <!-- End .ratings -->
                                                                            <span class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                        <!-- End .product-ratings -->
                                                                    </div>
                                                                    <!-- End .product-container -->

                                                                    <div class="price-box">
                                                                        <span class="product-price">$34.00</span>
                                                                    </div>
                                                                    <!-- End .price-box -->
                                                                </div>
                                                                <!-- End .product-details -->
                                                            </div>

                                                            <div class="product-default left-details product-widget">
                                                                <figure>
                                                                    <a href="demo35-product.html">
                                                                        <img src="{{ asset('assets/images/demoes/demo35/products/small/product-4.jpg')  }}" width="84" height="84" alt="product">
                                                                    </a>
                                                                </figure>

                                                                <div class="product-details">
                                                                    <h3 class="product-title"> <a href="demo35-product.html">Grape</a> </h3>

                                                                    <div class="ratings-container">
                                                                        <div class="product-ratings">
                                                                            <span class="ratings" style="width:100%"></span>
                                                                            <!-- End .ratings -->
                                                                            <span class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                        <!-- End .product-ratings -->
                                                                    </div>
                                                                    <!-- End .product-container -->

                                                                    <div class="price-box">
                                                                        <span class="product-price">$29.00</span>
                                                                    </div>
                                                                    <!-- End .price-box -->
                                                                </div>
                                                                <!-- End .product-details -->
                                                            </div>

                                                            <div class="product-default left-details product-widget">
                                                                <figure>
                                                                    <a href="demo35-product.html">
                                                                        <img src="{{ asset('assets/images/demoes/demo35/products/small/product-5.jpg')  }}" width="84" height="84" alt="product">
                                                                    </a>
                                                                </figure>

                                                                <div class="product-details">
                                                                    <h3 class="product-title"> <a href="demo35-product.html">Magic Toast</a> </h3>

                                                                    <div class="ratings-container">
                                                                        <div class="product-ratings">
                                                                            <span class="ratings" style="width:100%"></span>
                                                                            <!-- End .ratings -->
                                                                            <span class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                        <!-- End .product-ratings -->
                                                                    </div>
                                                                    <!-- End .product-container -->

                                                                    <div class="price-box">
                                                                        <span class="old-price">$29.00</span>
                                                                        <span class="product-price">$18.00</span>
                                                                    </div>
                                                                    <!-- End .price-box -->
                                                                </div>
                                                                <!-- End .product-details -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End .row -->
                                            </div>
                                            <!-- End .megamenu -->
                                        </li>
                                        <li>
                                            <a href="{{ route('index') }}"><i class="icon-category-music"></i>Music</a>
                                            <span class="menu-btn"></span>
                                            <div class="megamenu megamenu-fixed-width megamenu-five text-transform-none p-0" style="background-image: url(assets/images/demoes/demo35/menu-banner-4.jpg);">
                                                <div class="row m-0">
                                                    <div class="col-lg-4 pt-0">
                                                        <a href="#" class="nolink text-white pl-0">INSTRUMENTS</a>
                                                        <ul class="submenu bg-transparent">
                                                            <li><a href="{{ route('index') }}">Guitar</a></li>
                                                            <li><a href="{{ route('index') }}">Drums Sets</a></li>
                                                            <li><a href="{{ route('index') }}">Percussions</a></li>
                                                            <li><a href="{{ route('index') }}">Pedals & Effects</a></li>
                                                            <li><a href="{{ route('index') }}">Sound Cards</a></li>
                                                            <li><a href="{{ route('index') }}">Studio Equipments</a>
                                                            </li>
                                                            <li><a href="{{ route('index') }}">Piano & Keyboards</a>
                                                            </li>
                                                        </ul>

                                                        <a href="#" class="nolink text-white pl-0">EXTRA</a>
                                                        <ul class="submenu bg-transparent pb-0">
                                                            <li><a href="{{ route('index') }}">Strings</a></li>
                                                            <li><a href="{{ route('index') }}">Recorders</a></li>
                                                            <li><a href="{{ route('index') }}">Amplifiers</a></li>
                                                            <li><a href="{{ route('index') }}">Accessories</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-lg-8 pt-0 d-lg-block d-none">
                                                        <div class="banner menu-banner-5 d-flex align-items-center">
                                                            <div class="banner-layer text-right pt-0">
                                                                <h6 class="text-transform-none font1 mb-1">
                                                                    CHECK NEW ARRIVALS
                                                                </h6>
                                                                <h3 class="font1 text-white">PROFESSIONAL</h3>
                                                                <h2 class="font1 text-transform-none text-white">
                                                                    HEADPHONES</h2>
                                                                <a href="{{ route('index') }}" class="btn btn-dark font1">VIEW
                                                                    ALL NOW</a>
                                                            </div>
                                                            <!-- End .banner-layer -->
                                                        </div>
                                                        <!-- End .home-slide -->
                                                    </div>
                                                </div>
                                                <!-- End .row -->
                                            </div>
                                            <!-- End .megamenu -->
                                        </li>
                                        <li>
                                            <a href="{{ route('index') }}"><i class="icon-cat-sport"></i>Sports</a>
                                            <span class="menu-btn"></span>
                                            <div class="megamenu megamenu-fixed-width megamenu-six text-transform-none">
                                                <div class="row">
                                                    <div class="col-md-6 pt-0">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <a href="#" class="nolink pl-0">SPORTS</a>
                                                                <ul class="submenu bg-transparent">
                                                                    <li><a href="{{ route('index') }}">Sports &amp; Fitness</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Boating &amp; Sailing</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Clothing</a></li>
                                                                    <li><a href="{{ route('index') }}">Exercise &amp;
                                                                            Fitness</a></li>
                                                                    <li><a href="{{ route('index') }}">Golf</a></li>
                                                                    <li><a href="{{ route('index') }}">Hunting &amp; Fishing</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Leisure Sports</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Running</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Swimming</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Team Sports</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Tennis</a>
                                                                    </li>
                                                                    <li><a href="{{ route('index') }}">Other Sports</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <a href="#" class="nolink pl-0">SHOP BY PRICE</a>
                                                                <ul class="submenu bg-transparent pb-0 m-b-3">
                                                                    <li><a href="{{ route('index') }}">Under $25</a></li>
                                                                    <li><a href="{{ route('index') }}">$25 to $50</a></li>
                                                                    <li><a href="{{ route('index') }}">$50 to $100</a></li>
                                                                    <li><a href="{{ route('index') }}">$100 to $200</a></li>
                                                                    <li><a href="{{ route('index') }}">$200 & Above</a></li>
                                                                </ul>
                                                                <a href="#" class="nolink pl-0">SHOP BY BRAND</a>
                                                                <ul class="submenu bg-transparent pb-0">
                                                                    <li><a href="{{ route('index') }}">Books</a></li>
                                                                    <li><a href="{{ route('index') }}">Adidas</a></li>
                                                                    <li><a href="{{ route('index') }}">Nike</a></li>
                                                                    <li><a href="{{ route('index') }}">Asics</a></li>
                                                                    <li><a href="{{ route('index') }}">Puma</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-lg-block d-none">
                                                        <div class="featured-deal bg-white mb-3">
                                                            <div class="product-default mb-0">
                                                                <h2 class="heading ls-n-10 text-uppercase mb-0">Flash Deals
                                                                </h2>
                                                                <figure>
                                                                    <a href="demo35-product.html">
                                                                        <img src="{{ asset('assets/images/demoes/demo35/products/product-16.jpg')  }}" alt="product" width="1200" height="1200">
                                                                    </a>
                                                                    <div class="product-countdown-container">
                                                                        <span class="product-countdown-title">offer ends
                                                                            in:</span>
                                                                        <div class="product-countdown countdown-compact" data-until="2021, 10, 5" data-compact="true">
                                                                        </div>
                                                                        <!-- End .product-countdown -->
                                                                    </div>
                                                                    <!-- End .product-countdown-container -->
                                                                </figure>
                                                                <div class="product-details">
                                                                    <h3 class="product-title">
                                                                        <a href="demo35-product.html">Raw Meat</a>
                                                                    </h3>
                                                                    <div class="ratings-container">
                                                                        <div class="product-ratings">
                                                                            <span class="ratings" style="width:80%"></span>
                                                                            <!-- End .ratings -->
                                                                            <span class="tooltiptext tooltip-top"></span>
                                                                        </div>
                                                                        <!-- End .product-ratings -->
                                                                    </div>
                                                                    <!-- End .product-container -->
                                                                    <div class="price-box">
                                                                        <del class="old-price">$59.00</del>
                                                                        <span class="product-price">$49.00</span>
                                                                    </div>
                                                                    <!-- End .price-box -->
                                                                </div>
                                                                <!-- End .product-details -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End .row -->
                                            </div>
                                            <!-- End .megamenu -->
                                        </li>
                                    </ul>
                                </div>
                                <ul class="menu">
                                    <li>
                                        <a href="{{ route('index') }}">Shop</a>
                                        <div class="megamenu megamenu-fixed-width megamenu-3cols">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <a href="#" class="nolink">VARIATION 1</a>
                                                    <ul class="submenu">
                                                        <li><a href="category.html">Fullwidth Banner</a></li>
                                                        <li><a href="category-banner-boxed-slider.html">Boxed Slider
                                                                Banner</a>
                                                        </li>
                                                        <li><a href="category-banner-boxed-image.html">Boxed Image
                                                                Banner</a>
                                                        </li>
                                                        <li><a href="category.html">Left Sidebar</a></li>
                                                        <li><a href="category-sidebar-right.html">Right Sidebar</a></li>
                                                        <li><a href="category-off-canvas.html">Off Canvas Filter</a></li>
                                                        <li><a href="category-horizontal-filter1.html">Horizontal
                                                                Filter1</a>
                                                        </li>
                                                        <li><a href="category-horizontal-filter2.html">Horizontal
                                                                Filter2</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4">
                                                    <a href="#" class="nolink">VARIATION 2</a>
                                                    <ul class="submenu">
                                                        <li><a href="category-list.html">List Types</a></li>
                                                        <li><a href="category-infinite-scroll.html">Ajax Infinite Scroll</a>
                                                        </li>
                                                        <li><a href="category.html">3 Columns Products</a></li>
                                                        <li><a href="category-4col.html">4 Columns Products</a></li>
                                                        <li><a href="category-5col.html">5 Columns Products</a></li>
                                                        <li><a href="category-6col.html">6 Columns Products</a></li>
                                                        <li><a href="category-7col.html">7 Columns Products</a></li>
                                                        <li><a href="category-8col.html">8 Columns Products</a></li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4 p-0">
                                                    <div class="menu-banner">
                                                        <figure>
                                                            <img src="{{ asset('assets/images/menu-banner.jpg')  }}" alt="Menu banner" width="300" height="300">
                                                        </figure>
                                                        <div class="banner-content">
                                                            <h4>
                                                                <span class="">UP TO</span><br />
                                                                <b class="">50%</b>
                                                                <i>OFF</i>
                                                            </h4>
                                                            <a href="category.html" class="btn btn-sm btn-dark">SHOP NOW</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End .megamenu -->
                                    </li>
                                    <li>
                                        <a href="demo35-product.html">Products</a>
                                        <div class="megamenu megamenu-fixed-width">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <a href="#" class="nolink">PRODUCT PAGES</a>
                                                    <ul class="submenu">
                                                        <li><a href="demo35-product.html">SIMPLE PRODUCT</a></li>
                                                        <li><a href="product-variable.html">VARIABLE PRODUCT</a></li>
                                                        <li><a href="demo35-product.html">SALE PRODUCT</a></li>
                                                        <li><a href="demo35-product.html">FEATURED & ON SALE</a></li>
                                                        <li><a href="product-custom-tab.html">WITH CUSTOM TAB</a></li>
                                                        <li><a href="product-sidebar-left.html">WITH LEFT SIDEBAR</a></li>
                                                        <li><a href="product-sidebar-right.html">WITH RIGHT SIDEBAR</a></li>
                                                        <li><a href="product-addcart-sticky.html">ADD CART STICKY</a></li>
                                                    </ul>
                                                </div>
                                                <!-- End .col-lg-4 -->

                                                <div class="col-lg-4">
                                                    <a href="#" class="nolink">PRODUCT LAYOUTS</a>
                                                    <ul class="submenu">
                                                        <li><a href="product-extended-layout.html">EXTENDED LAYOUT</a></li>
                                                        <li><a href="product-grid-layout.html">GRID IMAGE</a></li>
                                                        <li><a href="product-full-width.html">FULL WIDTH LAYOUT</a></li>
                                                        <li><a href="product-sticky-info.html">STICKY INFO</a></li>
                                                        <li><a href="product-sticky-both.html">LEFT & RIGHT STICKY</a></li>
                                                        <li><a href="product-transparent-image.html">TRANSPARENT IMAGE</a>
                                                        </li>
                                                        <li><a href="product-center-vertical.html">CENTER VERTICAL</a></li>
                                                        <li><a href="#">BUILD YOUR OWN</a></li>
                                                    </ul>
                                                </div>
                                                <!-- End .col-lg-4 -->

                                                <div class="col-lg-4 p-0">
                                                    <div class="menu-banner menu-banner-2">
                                                        <figure>
                                                            <img src="{{ asset('assets/images/menu-banner-1.jpg')  }}" alt="Menu banner" class="product-promo" width="380" height="790">
                                                        </figure>
                                                        <i>OFF</i>
                                                        <div class="banner-content">
                                                            <h4>
                                                                <span class="">UP TO</span><br />
                                                                <b class="">50%</b>
                                                            </h4>
                                                        </div>
                                                        <a href="category.html" class="btn btn-sm btn-dark">SHOP NOW</a>
                                                    </div>
                                                </div>
                                                <!-- End .col-lg-4 -->
                                            </div>
                                            <!-- End .row -->
                                        </div>
                                        <!-- End .megamenu -->
                                    </li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li>
                                        <a href="#">Pages</a>
                                        <ul>
                                            <li><a href="wishlist.html">Wishlist</a></li>
                                            <li><a href="cart.html">Shopping Cart</a></li>
                                            <li><a href="checkout.html">Checkout</a></li>
                                            <li><a href="dashboard.html">Dashboard</a></li>
                                            <li><a href="about.html">About Us</a></li>
                                            <li><a href="#">Blog</a>
                                                <ul>
                                                    <li><a href="blog.html">Blog</a></li>
                                                    <li><a href="single.html">Blog Post</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="contact.html">Contact Us</a></li>
                                            <li><a href="login.html">Login</a></li>
                                            <li><a href="forgot-password.html">Forgot Password</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Elements</a>
                                        <ul class="custom-scrollbar">
                                            <li><a href="element-accordions.html">Accordion</a></li>
                                            <li><a href="element-alerts.html">Alerts</a></li>
                                            <li><a href="element-animations.html">Animations</a></li>
                                            <li><a href="element-banners.html">Banners</a></li>
                                            <li><a href="element-buttons.html">Buttons</a></li>
                                            <li><a href="element-call-to-action.html">Call to Action</a></li>
                                            <li><a href="element-countdown.html">Count Down</a></li>
                                            <li><a href="element-counters.html">Counters</a></li>
                                            <li><a href="element-headings.html">Headings</a></li>
                                            <li><a href="element-icons.html">Icons</a></li>
                                            <li><a href="element-info-box.html">Info box</a></li>
                                            <li><a href="element-posts.html">Posts</a></li>
                                            <li><a href="element-products.html">Products</a></li>
                                            <li><a href="element-product-categories.html">Product Categories</a></li>
                                            <li><a href="element-tabs.html">Tabs</a></li>
                                            <li><a href="element-testimonial.html">Testimonials</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#" target="blank">Buy Porto!</a></li>
                                </ul>
                            </nav>
                            <div class="info-boxes font2 align-items-center ml-auto">
                                <div class="info-item">
                                    <a href="#"><i class="icon-percent-shape"></i>Special Offers</a>
                                </div>
                                <div class="info-item">
                                    <a href="#"><i class="icon-business-book"></i>Recipes</a>
                                </div>
                            </div>
                        </div>
                        <div class="header-right"></div>
                    </div>
                </div>
            </header>
            <!-- End .header -->
            @yield('main-content')
            <footer class="footer font2">
                <div class="container">
                    <div class="footer-middle">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="widget mb-3">
                                    <h4 class="widget-title">Customer Service</h4>

                                    <ul class="links">
                                        <li><a href="#">Help &amp; FAQs</a></li>
                                        <li><a href="dashboard.html">Order Tracking</a></li>
                                        <li><a href="#">Shipping &amp; Delivery</a></li>
                                        <li><a href="#">Orders History</a></li>
                                        <li><a href="#">Advanced Search</a></li>
                                        <li><a href="login.html">Login</a></li>
                                    </ul>
                                </div>
                                <!-- End .widget -->
                            </div>
                            <!-- End .col-lg-3 -->

                            <div class="col-lg-3">
                                <div class="widget mb-3">
                                    <h4 class="widget-title">About Us</h4>

                                    <ul class="links">
                                        <li><a href="about.html">About Us</a></li>
                                        <li><a href="#">Careers</a></li>
                                        <li><a href="#">Our Stores</a></li>
                                        <li><a href="#">Corporate Sales</a></li>
                                        <li><a href="#">Careers</a></li>
                                    </ul>
                                </div>
                                <!-- End .widget -->
                            </div>
                            <!-- End .col-lg-3 -->

                            <div class="col-lg-3">
                                <div class="widget mb-3">
                                    <h4 class="widget-title">More Information</h4>

                                    <ul class="links">
                                        <li><a href="#">Affiliates</a></li>
                                        <li><a href="#">Refer a Friend</a></li>
                                        <li><a href="#">Student Beans Offers</a></li>
                                        <li><a href="#">Gift Vouchers</a></li>
                                    </ul>
                                </div>
                                <!-- End .widget -->
                            </div>
                            <!-- End .col-lg-3 -->

                            <div class="col-lg-3">
                                <div class="widget mb-3">
                                    <h4 class="widget-title">Social Media</h4>

                                    <div class="social-icons">
                                        <a href="#" class="social-icon social-instagram icon-instagram" target="_blank"></a>
                                        <a href="#" class="social-icon social-twitter icon-twitter" target="_blank"></a>
                                        <a href="#" class="social-icon social-facebook icon-facebook" target="_blank"></a>
                                    </div>
                                    <!-- End .social-icons -->
                                </div>
                                <!-- End .col-lg-3 -->

                                <div class="widget mb-3">
                                    <h4 class="widget-title">Payment Methods</h4>

                                    <img src="{{ asset('assets/images/demoes/demo35/payment.png')  }}" alt="payment" width="240" height="32">
                                </div>
                            </div>
                            <!-- End .row -->
                        </div>
                    </div>
                    <div class="footer-bottom">
                        <p class="footer-copyright text-lg-center ls-n-25 mb-0">Porto eCommerce.&nbsp;&copy;&nbsp;&nbsp;2021.&nbsp;&nbsp;All Rights Reserved.
                        </p>
                    </div>
                    <!-- End .footer-bottom -->
                </div>
                <!-- End .container -->
            </footer>
            <!-- End .footer -->
        </div>
        <!-- End .page-wrapper -->

        <div class="mobile-menu-overlay"></div>
        <!-- End .mobil-menu-overlay -->

        <div class="mobile-menu-container">
            <div class="mobile-menu-wrapper">
                <span class="mobile-menu-close"><i class="fa fa-times"></i></span>
                <nav class="mobile-nav">
                    <ul class="mobile-menu">
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li>
                            <a href="{{ route('index') }}">Categories</a>
                            <ul>
                                <li><a href="category.html">Full Width Banner</a></li>
                                <li><a href="category-banner-boxed-slider.html">Boxed Slider Banner</a></li>
                                <li><a href="category-banner-boxed-image.html">Boxed Image Banner</a></li>
                                <li><a href="category-sidebar-left.html">Left Sidebar</a></li>
                                <li><a href="category-sidebar-right.html">Right Sidebar</a></li>
                                <li><a href="category-off-canvas.html">Off Canvas Filter</a></li>
                                <li><a href="category-horizontal-filter1.html">Horizontal Filter 1</a></li>
                                <li><a href="category-horizontal-filter2.html">Horizontal Filter 2</a></li>
                                <li><a href="#">List Types</a></li>
                                <li><a href="category-infinite-scroll.html">Ajax Infinite Scroll<span
                                            class="tip tip-new">New</span></a></li>
                                <li><a href="category.html">3 Columns Products</a></li>
                                <li><a href="category-4col.html">4 Columns Products</a></li>
                                <li><a href="category-5col.html">5 Columns Products</a></li>
                                <li><a href="category-6col.html">6 Columns Products</a></li>
                                <li><a href="category-7col.html">7 Columns Products</a></li>
                                <li><a href="category-8col.html">8 Columns Products</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="demo35-product.html">Products</a>
                            <ul>
                                <li>
                                    <a href="#" class="nolink">PRODUCT PAGES</a>
                                    <ul>
                                        <li><a href="demo35-product.html">SIMPLE PRODUCT</a></li>
                                        <li><a href="product-variable.html">VARIABLE PRODUCT</a></li>
                                        <li><a href="demo35-product.html">SALE PRODUCT</a></li>
                                        <li><a href="demo35-product.html">FEATURED & ON SALE</a></li>
                                        <li><a href="product-sticky-info.html">WIDTH CUSTOM TAB</a></li>
                                        <li><a href="product-sidebar-left.html">WITH LEFT SIDEBAR</a></li>
                                        <li><a href="product-sidebar-right.html">WITH RIGHT SIDEBAR</a></li>
                                        <li><a href="product-addcart-sticky.html">ADD CART STICKY</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="nolink">PRODUCT LAYOUTS</a>
                                    <ul>
                                        <li><a href="product-extended-layout.html">EXTENDED LAYOUT</a></li>
                                        <li><a href="product-grid-layout.html">GRID IMAGE</a></li>
                                        <li><a href="product-full-width.html">FULL WIDTH LAYOUT</a></li>
                                        <li><a href="product-sticky-info.html">STICKY INFO</a></li>
                                        <li><a href="product-sticky-both.html">LEFT & RIGHT STICKY</a></li>
                                        <li><a href="product-transparent-image.html">TRANSPARENT IMAGE</a></li>
                                        <li><a href="product-center-vertical.html">CENTER VERTICAL</a></li>
                                        <li><a href="#">BUILD YOUR OWN</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Pages<span class="tip tip-hot">Hot!</span></a>
                            <ul>
                                <li>
                                    <a href="wishlist.html">Wishlist</a>
                                </li>
                                <li>
                                    <a href="cart.html">Shopping Cart</a>
                                </li>
                                <li>
                                    <a href="checkout.html">Checkout</a>
                                </li>
                                <li>
                                    <a href="dashboard.html">Dashboard</a>
                                </li>
                                <li>
                                    <a href="login.html">Login</a>
                                </li>
                                <li>
                                    <a href="forgot-password.html">Forgot Password</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="blog.html">Blog</a></li>
                        <li>
                            <a href="#">Elements</a>
                            <ul class="custom-scrollbar">
                                <li><a href="element-accordions.html">Accordion</a></li>
                                <li><a href="element-alerts.html">Alerts</a></li>
                                <li><a href="element-animations.html">Animations</a></li>
                                <li><a href="element-banners.html">Banners</a></li>
                                <li><a href="element-buttons.html">Buttons</a></li>
                                <li><a href="element-call-to-action.html">Call to Action</a></li>
                                <li><a href="element-countdown.html">Count Down</a></li>
                                <li><a href="element-counters.html">Counters</a></li>
                                <li><a href="element-headings.html">Headings</a></li>
                                <li><a href="element-icons.html">Icons</a></li>
                                <li><a href="element-info-box.html">Info box</a></li>
                                <li><a href="element-posts.html">Posts</a></li>
                                <li><a href="element-products.html">Products</a></li>
                                <li><a href="element-product-categories.html">Product Categories</a></li>
                                <li><a href="element-tabs.html">Tabs</a></li>
                                <li><a href="element-testimonial.html">Testimonials</a></li>
                            </ul>
                        </li>
                    </ul>

                    <ul class="mobile-menu mt-2 mb-2">
                        <li class="border-0">
                            <a href="#">
                                Special Offer!
                            </a>
                        </li>
                        <li class="border-0">
                            <a href="https://1.envato.market/DdLk5" target="_blank">
                                Buy Porto!
                                <span class="tip tip-hot">Hot</span>
                            </a>
                        </li>
                    </ul>

                    <ul class="mobile-menu">
                        <li><a href="login.html">My Account</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                        <li><a href="blog.html">Blog</a></li>
                        <li><a href="wishlist.html">My Wishlist</a></li>
                        <li><a href="cart.html">Cart</a></li>
                        <li><a href="login.html" class="login-link">Log In</a></li>
                    </ul>
                </nav>
                <!-- End .mobile-nav -->

                <form class="search-wrapper mb-2" action="#">
                    <input type="text" class="form-control mb-0" placeholder="Search..." required />
                    <button class="btn icon-search text-white bg-transparent p-0" type="submit"></button>
                </form>

                <div class="social-icons">
                    <a href="#" class="social-icon social-facebook icon-facebook" target="_blank">
                    </a>
                    <a href="#" class="social-icon social-twitter icon-twitter" target="_blank">
                    </a>
                    <a href="#" class="social-icon social-instagram icon-instagram" target="_blank">
                    </a>
                </div>
            </div>
            <!-- End .mobile-menu-wrapper -->
        </div>
        <!-- End .mobile-menu-container -->

        <div class="sticky-navbar">
            <div class="sticky-info">
                <a href="{{ route('index') }}">
                    <i class="icon-home"></i>Home
                </a>
            </div>
            <div class="sticky-info">
                <a href="{{ route('index') }}" class="">
                    <i class="icon-bars"></i>Categories
                </a>
            </div>
            <div class="sticky-info">
                <a href="wishlist.html" class="">
                    <i class="icon-wishlist-2"></i>Wishlist
                </a>
            </div>
            <div class="sticky-info">
                <a href="login.html" class="">
                    <i class="icon-user-2"></i>Account
                </a>
            </div>
            <div class="sticky-info">
                <a href="cart.html" class="">
                    <i class="icon-shopping-cart position-relative">
                        <span class="cart-count badge-circle">3</span>
                    </i>Cart
                </a>
            </div>
        </div>

        <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

        <!-- Plugins JS File -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
        <script src="{{ asset('assets/js/optional/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.plugin.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
        <!-- Main JS File -->
        <script src="{{ asset('assets/js/main.min.js') }}"></script>
        @stack("scripts")
    </body>
</html>
