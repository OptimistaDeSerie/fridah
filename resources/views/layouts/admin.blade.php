<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Fridah's Spice</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" content="" />
        <meta name="description" content="Fridah's Spice - Your one-stop shop for all spices" />
        <meta name="author" content="SW-THEMES">
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/icons/favicon') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/animate.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/animation.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/bootstrap-select.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/font/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/icon/style.css') }}">
        <link rel="shortcut icon" href="{{ asset('backend/images/favicon.ico') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('backend/images/favicon.ico') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/sweetalert.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.min.css') }}">
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
        @stack("styles")
    </head>
    <body class="body">
        <div id="wrapper">
            <div id="page" class="">
                <div class="layout-wrap">

                    <!-- <div id="preload" class="preload-container">
        <div class="preloading">
            <span></span>
        </div>
    </div> -->

                    <div class="section-menu-left">
                        <div class="box-logo">
                            <a href="{{route('admin.index')}}" id="site-logo-inner">
                                <img class="" id="logo_header" alt="" src="{{ asset('backend/images/logo/logo.png') }}"
                                    data-light="{{ asset('backend/images/logo/logo.png') }}" data-dark="{{ asset('images/logo/logo.png') }}">
                            </a>
                            <div class="button-show-hide">
                                <i class="icon-menu-left"></i>
                            </div>
                        </div>
                        <div class="center">
                            <div class="center-item">
                                <div class="center-heading">Main Home</div>
                                <ul class="menu-list">
                                    <li class="menu-item">
                                        <a href="{{route('index')}}" class="">
                                            <div class="icon"><i class="icon-grid"></i></div>
                                            <div class="text">Main Website</div>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="menu-list">
                                    <li class="menu-item">
                                        <a href="{{route('admin.index')}}" class="">
                                            <div class="icon"><i class="icon-grid"></i></div>
                                            <div class="text">Dashboard</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="center-item">
                                <ul class="menu-list">
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-shopping-cart"></i></div>
                                            <div class="text">Products</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.product.add')}}" class="">
                                                    <div class="text">Add Product</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.products')}}" class="">
                                                    <div class="text">Products</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                                <div class="icon"><i class="icon-layers"></i></div>
                                                <div class="text">Category</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                    <a href="{{route('admin.category.add')}}" class="">
                                                    <div class="text">New Category</div>
                                                    </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                    <a href="{{route('admin.categories')}}" class="">
                                                    <div class="text">Categories</div>
                                                    </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-file-plus"></i></div>
                                            <div class="text">Order</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{route('admin.orders')}}" class="">
                                                    <div class="text">Orders</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="#" class="">
                                                    <div class="text">Order tracking</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-shopping-cart"></i></div>
                                            <div class="text">Delivery</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.delivery-fees') }}" class="">
                                                    <div class="text">Delivery Fee</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.carriers') }}" class="">
                                                    <div class="text">Carriers</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.weights') }}" class="">
                                                    <div class="text">Weight</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item has-children">
                                        <a href="javascript:void(0);" class="menu-item-button">
                                            <div class="icon"><i class="icon-image"></i></div>
                                            <div class="text">Slider</div>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.sliders') }}" class="">
                                                    <div class="text">Main Home Slider</div>
                                                </a>
                                            </li>
                                            <li class="sub-menu-item">
                                                <a href="{{ route('admin.popular.categories') }}" class="">
                                                    <div class="text">Popular Categories Slider</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('admin.hot.deals') }}" class="">
                                            <div class="icon"><i class="icon-trending-up"></i></div>
                                            <div class="text">Hot Deals</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('admin.banners') }}" class="">
                                            <div class="icon"><i class="icon-image"></i></div>
                                            <div class="text">Home Banner</div>
                                        </a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="{{ route('admin.shop_banners') }}" class="">
                                            <div class="icon"><i class="icon-image"></i></div>
                                            <div class="text">Product Page Banner</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="section-content-right">
                        <div class="header-dashboard">
                            <div class="wrap">
                                <div class="header-left">
                                    <a href="index-2.html">
                                        <img class="" id="logo_header_mobile" alt="" src="{{ asset('backend/images/logo/logo.png') }}"
                                            data-light="{{ asset('backend/images/logo/logo.png') }}" data-dark="{{ asset('backend/images/logo/logo.png') }}"
                                            data-width="154px" data-height="52px" data-retina="{{ asset('images/logo/logo.png') }}">
                                    </a>
                                    <div class="button-show-hide">
                                        <i class="icon-menu-left"></i>
                                    </div>
                                    <form class="form-search flex-grow">
                                        <fieldset class="name">
                                            <input type="text" placeholder="Search here..." class="show-search" name="name"
                                                tabindex="2" value="" aria-required="true" required="">
                                        </fieldset>
                                        <div class="button-submit">
                                            <button class="" type="submit"><i class="icon-search"></i></button>
                                        </div>
                                        <div class="box-content-search" id="box-content-search">
                                            <ul class="mb-24">
                                                <li class="mb-14">
                                                    <div class="body-title">Top selling product</div>
                                                </li>
                                                <li class="mb-14">
                                                    <div class="divider"></div>
                                                </li>
                                                <li>
                                                    <ul>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('backend/images/products/17.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Dog Food
                                                                        Rachael Ray Nutrish®</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('backend/images/products/18.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Natural
                                                                        Dog Food Healthy Dog Food</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('backend/images/products/19.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Freshpet
                                                                        Healthy Dog Food and Cat</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            <ul class="">
                                                <li class="mb-14">
                                                    <div class="body-title">Order product</div>
                                                </li>
                                                <li class="mb-14">
                                                    <div class="divider"></div>
                                                </li>
                                                <li>
                                                    <ul>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('backend/images/products/20.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Sojos
                                                                        Crunchy Natural Grain Free...</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('backend/images/products/21.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Kristin
                                                                        Watson</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14 mb-10">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('backend/images/products/22.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Mega
                                                                        Pumpkin Bone</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mb-10">
                                                            <div class="divider"></div>
                                                        </li>
                                                        <li class="product-item gap14">
                                                            <div class="image no-bg">
                                                                <img src="{{ asset('backend/images/products/23.png') }}" alt="">
                                                            </div>
                                                            <div class="flex items-center justify-between gap20 flex-grow">
                                                                <div class="name">
                                                                    <a href="product-list.html" class="body-text">Mega
                                                                        Pumpkin Bone</a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </form>

                                </div>
                                <div class="header-grid">
                                    <div class="popup-wrap message type-header">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="header-item">
                                                    @if($recentOrders->count() > 0)
                                                        <span class="text-tiny">{{ $recentOrders->count() }}</span>
                                                    @endif
                                                    <i class="icon-bell"></i>
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end has-content" aria-labelledby="dropdownMenuButton2">
                                                <li><h6>Recent Orders</h6></li>

                                                @forelse($recentOrders as $order)
                                                    <li>
                                                        <div class="message-item">
                                                            <div class="image">
                                                                <i class="icon-shopping-bag"></i>
                                                            </div>
                                                            <a href="{{ route('admin.order.item', ['id' => $order->id]) }}">
                                                                <div>
                                                                    <div class="body-title-2">
                                                                        Order <strong>#{{ $order->order_no }}</strong>
                                                                    </div>
                                                                    <div class="text-tiny">
                                                                        ₦{{ number_format($order->total, 2) }} • 
                                                                        {{ $order->created_at->format('M d, Y') }}
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </li>
                                                @empty
                                                    <li>
                                                        <div class="message-item text-center py-3">
                                                            <div class="text-tiny">No recent orders</div>
                                                        </div>
                                                    </li>
                                                @endforelse

                                                <li>
                                                    <a href="{{ route('admin.orders') }}" class="tf-button w-full">
                                                        View all orders
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @if(Auth::user()->user_type == 'admin')
                                    <div class="popup-wrap user type-header">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="header-user wg-user">
                                                    <span class="image">
                                                        <img src="{{ asset('backend/images/avatar/user-1.png') }}" alt="">
                                                    </span>
                                                    <span class="flex flex-column">
                                                        <span class="body-title mb-2">{{ Auth::user()->firstname }}</span>
                                                        <span class="text-tiny">Admin</span>
                                                    </span>
                                                </span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end has-content"
                                                aria-labelledby="dropdownMenuButton3">
                                                <li>
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <a href="{{ route('logout') }}" class="user-item"
                                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                                            <div class="icon">
                                                                <i class="icon-log-out"></i>
                                                            </div>
                                                            <div class="body-title-2">Log out</div>
                                                        </a>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="main-content">
                            @yield('main-content')
                            <div class="bottom-page">
                                <div class="body-text">Copyright © 2025 Fridah Spices</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('backend/js/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('backend/js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('backend/js/apexcharts/apexcharts.js') }}"></script>
        <script src="{{ asset('backend/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
        @stack("scripts")
    </body>
</html>
