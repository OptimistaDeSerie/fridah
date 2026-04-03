<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Fridah's Spice</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" content="Fridah's Spice" />
        <meta name="description" content="Fridah's Spice - Your one-stop shop for all spices" />

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/icons/favicon.ico') }}">

        <script>
            WebFontConfig = {
                google: {
                    families: ['Open+Sans:300,400,600,700,800', 'Poppins:200,300,400,500,600,700,800', 'Oswald:300,400,500,600,700,800']
                }
            };
        </script>

        <!-- Plugins CSS File -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!-- Main CSS File -->
        <link rel="stylesheet" href="{{ asset('assets/css/demo35.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/simple-line-icons/css/simple-line-icons.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/custom_1.css') }}">
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
                                    <h4 class="mb-0">Express Shipping to all states in Nigeria</h4>
                                </div>
                                <!-- End .info-box-content -->
                            </div>
                            <!-- End .info-box -->
                        </div>
                        <!-- End .header-left -->

                        <div class="header-right header-dropdowns">
                            <div class="separator d-none d-lg-inline"></div>
                            <div class="header-dropdown dropdown-expanded d-none d-lg-block">
                                <a href="#">Links</a>
                                <div class="header-menu">
                                    <ul>
                                        <li>
                                            <a href="#">
                                                <i class="icon-help-circle"></i> FAQ
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <span class="separator d-none d-lg-inline"></span>
                            <div class="social-icons">
                                <a href="https://www.instagram.com/fridahs_spice/" class="social-icon social-instagram icon-instagram" target="_blank"></a>
                                <a href="https://web.facebook.com/fridahsSpice/" class="social-icon social-facebook icon-facebook" target="_blank"></a>
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
                                <img loading="lazy" src="{{ asset('assets/images/logo-black.png') }}" class="w-100" width="111" height="44" alt="Fridah Spice Logo">
                            </a>
                            <div class="header-icon header-search header-search-inline header-search-category d-lg-block d-none text-right mt-0">
                                <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                                <form action="{{ route('shop.index') }}" method="GET">
                                    <div class="header-search-wrapper">
                                        <input type="search" class="form-control" name="q" id="q" placeholder="Search..." value="{{ request()->query('q') }}" required>
                                        <!-- <div class="select-custom">
                                            <select id="cat" name="cat">
                                                <option value="">All Categories</option>
                                                @foreach ($menucategories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ request()->query('cat') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                    @if ($category->children->isNotEmpty())
                                                        @foreach ($category->children as $child)
                                                            <option value="{{ $child->id }}"
                                                                {{ request()->query('cat') == $child->id ? 'selected' : '' }}>
                                                                - {{ $child->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div> -->
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
                            <div class="cart-dropdown-wrapper d-flex align-items-center mr-4">
                                <a href="{{ route('cart.index') }}" title="Cart" class="d-flex align-items-center">
                                    <div class="dropdown cart-dropdown">
                                        <i class="icon-cart-thick"></i>
                                        @if(Cart::instance('cart')->content()->count() > 0)
                                            <span class="cart-count badge-circle">{{ Cart::instance('cart')->content()->count() }}</span>
                                        @endif
                                    </div>
                                    <!-- End .dropdown -->
                                    <span class="cart-subtotal font2 d-none d-sm-inline ml-2">
                                        Shopping Cart
                                        @if(Cart::instance('cart')->content()->count() > 0)
                                            <span class="cart-price d-block font2">₦{{ Cart::instance('cart')->subtotal() }}</span>
                                        @else
                                            <span class="cart-price d-block font2">₦0.00</span>
                                        @endif
                                    </span>
                                </a>
                            </div>
                            <div class="header-dropdown dropdown cart-dropdown">
                                <a href="#">
                                    @guest
                                        <i class="icon-user-2"></i> Account
                                    @else
                                        <i class="icon-user-2"></i> <span class="font2">Hi, {{ Auth::user()->firstname }}</span>
                                    @endguest
                                </a>
                                <div class="header-menu">
                                    <ul>
                                        @guest
                                            <li>
                                                <a href="{{ route('login') }}">
                                                    <i class="icon-login"></i> Login / Register
                                                </a>
                                            </li>
                                        @else
                                            <!-- Common links for ALL authenticated users -->
                                            <li>
                                                <a href="{{ route('user.index') }}">
                                                    <i class=""></i> My Dashboard
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('user.orders') }}">
                                                    <i class=""></i> My Orders
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <!-- Admin-only links -->
                                            @if(Auth::user()->user_type == 'admin')
                                                <li>
                                                    <a href="{{ route('admin.index') }}" class="text-primary">
                                                        <i class=""></i> Admin Panel
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.orders') }}">
                                                        <i class=""></i> Manage Orders
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.products') }}">
                                                        <i class=""></i> Manage Products
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.categories') }}">
                                                        <i class=""></i> Manage Categories
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="divider"></li>
                                            <!-- Logout for all logged-in users -->
                                            <li>
                                                <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <i class="icon-logout"></i> Logout
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                                                    @csrf
                                                </form>
                                            </li>
                                        @endguest
                                    </ul>
                                </div>
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
                                    <a href="{{ route('index') }}"><i class="fa fa-bars align-middle mr-3"></i>All Categories</a>
                                    <ul class="menu menu-vertical">
                                    @foreach ($menucategories as $category)
                                        <li>
                                            <a href="{{ route('shop.index') }}?categories={{ $category->id }}">
                                                <i class="icon-category-garden"></i>
                                                {{ $category->name }}
                                            </a>
                                            @if ($category->children->isNotEmpty())
                                                <span class="menu-btn"></span>
                                                <div class="megamenu megamenu-fixed-width megamenu-two">
                                                    <div class="row">
                                                        @foreach ($category->children->chunk(6) as $chunk)
                                                            <div class="col-lg-3 mb-1">
                                                                <a href="{{ route('shop.index') }}?categories={{ $category->id }}" class="nolink pl-0 text-uppercase">
                                                                    {{ $category->name }}
                                                                </a>
                                                                <ul class="submenu">
                                                                    @foreach ($chunk as $child)
                                                                        <li>
                                                                            <a href="{{ route('shop.index') }}?categories={{ $child->id }}">
                                                                                {{ $child->name }}
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                </div>
                                <ul class="menu">
                                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                                    <li><a href="{{ route('about.us') }}">About Us</a></li>
                                    <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                                </ul>
                            </nav>
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
                                    <h4 class="widget-title">About</h4>

                                    <ul class="links">
                                        <li><a href="{{ route('about.us') }}">About Us</a></li>
                                        <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                                    </ul>
                                </div>
                                <!-- End .widget -->
                            </div>
                            <!-- End .col-lg-3 -->

                            <div class="col-lg-3">
                                <div class="widget mb-3">
                                    <h4 class="widget-title">Delivery & Returns</h4>

                                    <ul class="links">
                                        <li><a href="{{ route('shipping.policy') }}">Shipping & Delivery Policy</a></li>
                                        <li><a href="{{ route('return.policy') }}">Return & Refund Policy</a></li>
                                    </ul>
                                </div>
                                <!-- End .widget -->
                            </div>
                            <!-- End .col-lg-3 -->

                            <div class="col-lg-3">
                                <div class="widget mb-3">
                                    <h4 class="widget-title">More Information</h4>

                                    <ul class="links">
                                        <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                                        <li><a href="{{ route('terms.condition') }}">Terms & Conditions</a></li>
                                    </ul>
                                </div>
                                <!-- End .widget -->
                            </div>
                            <!-- End .col-lg-3 -->

                            <div class="col-lg-3">
                                <div class="widget mb-3">
                                    <h4 class="widget-title">Social Media</h4>

                                    <div class="social-icons">
                                        <a href="https://www.instagram.com/fridahs_spice/" class="social-icon social-instagram icon-instagram" target="_blank"></a>
                                        <a href="https://web.facebook.com/fridahsSpice/" class="social-icon social-facebook icon-facebook" target="_blank"></a>
                                    </div>
                                    <!-- End .social-icons -->
                                </div>
                                <!-- End .col-lg-3 -->
                            </div>
                            <!-- End .row -->
                        </div>
                    </div>
                    <div class="footer-bottom">
                        <p class="footer-copyright text-lg-center ls-n-25 mb-0">Fridah's Spice. &copy; {{ now()->year }}. All Rights Reserved.
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
                            <a href="{{ route('shop.index') }}">Categories</a>
                            <ul>
                            @foreach ($menucategories as $category)
                                <li>
                                    <a href="{{ route('shop.index') }}?categories={{ $category->id }}">
                                        <i class="icon-category-garden"></i>
                                        {{ $category->name }}
                                    </a>
                                    @if ($category->children->isNotEmpty())
                                        <span class="menu-btn"></span>
                                        <div class="megamenu megamenu-fixed-width megamenu-two">
                                            <div class="row">
                                                @foreach ($category->children->chunk(6) as $chunk)
                                                    <div class="col-lg-3 mb-1">
                                                        <a href="{{ route('shop.index') }}?categories={{ $category->id }}" class="nolink pl-0 text-uppercase">
                                                            {{ $category->name }}
                                                        </a>
                                                        <ul class="submenu">
                                                            @foreach ($chunk as $child)
                                                                <li>
                                                                    <a href="{{ route('shop.index') }}?categories={{ $child->id }}">
                                                                        {{ $child->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li><a href="{{route('shop.index')}}">Shop</a></li>
                    </ul>
                    <ul class="mobile-menu mt-2 mb-2">
                        <li class="border-0">
                            <a href="{{ route('about.us') }}">
                                About Us
                            </a>
                        </li>
                        <li class="border-0">
                            <a href="{{ route('contact.us') }}">
                                Contact Us
                            </a>
                        </li>
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
                <a href="{{ route('cart.index') }}" class="">
                    <i class="icon-shopping-cart position-relative">
                        @if(Cart::instance('cart')->content()->count()>0)
                            <span class=" cart-count badge-circle">{{Cart::instance('cart')->content()->count()}}</span>
                        @endif
                    </i>Cart
                </a>
            </div>
        </div>

        <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

        <!-- Plugins JS File -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/plugins.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/jquery.appear.min.js') }}" defer></script>
        <script src="{{ asset('assets/js/jquery.plugin.min.js') }}" defer></script>
        <!-- Main JS File -->
        <script src="{{ asset('assets/js/main.min.js') }}" defer></script>
        @stack("scripts")
    </body>
</html>
