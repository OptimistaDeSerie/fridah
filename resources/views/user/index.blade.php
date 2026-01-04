@extends('layouts.app')
@section('main-content')
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<main class="main bg-grey">
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3"></nav>
        <div class="container account-container custom-account-container">
            <div class="row">
                <div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
                    <h2 class="text-uppercase">My Account</h2>
                    @include('user.account-nav')
                </div>
                <div class="col-lg-9 order-lg-last order-1 tab-content">
                    <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                        <!-- Index unique content -->
                        <div class="welcome-content">
                            <h3>Welcome to your dashboard!</h3>
                            <p>Use the navigation to manage your account, view orders, addresses, and more.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="mb-5"></div><!-- margin -->
@endsection