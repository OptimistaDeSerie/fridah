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
                        <!-- Orders unique content -->
                        <div class="order-content">
                            <h3 class="account-sub-title d-none d-md-block"><i class=""></i>Orders</h3>
                            <div class="order-table-container text-center">
                                <table class="table table-order text-left">
                                    <thead>
                                        <tr>
                                            <th class="order-id">Order No</th>
                                            <th class="order-date">Order date</th>
                                            <th class="order-date">Items</th>
                                            <th class="order-status">Status</th>
                                            <th class="order-status">Subtotal</th>
                                            <th class="order-price">Total</th>
                                            <th class="order-action">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($orders->count() > 0)
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td class="order-id">{{ $order->order_no }}</td>
                                                    <td class="order-date">{{ $order->created_at->format('Y-m-d') }}</td>
                                                    <td class="order-items">{{ $order->orderItems->sum('quantity') }}</td>
                                                    <td class="order-status">
                                                        @if($order->status=='delivered')
                                                            <span class="badge bg-success text-white">Delivered</span>
                                                        @elseif($order->status=='canceled')
                                                            <span class="badge bg-danger text-white">Canceled</span>
                                                        @elseif($order->status=='pending')
                                                            <span class="badge bg-info text-white">Pending</span>
                                                        @else
                                                            <span class="badge bg-warning text-white">Ordered</span>
                                                        @endif
                                                    </td>
                                                    <td class="order-subtotal">₦{{ number_format($order->subtotal, 2) }}</td>
                                                    <td class="order-total">₦{{ number_format($order->total, 2) }}</td>
                                                    <td class="order-action">
                                                        <a href="{{ route('user.order.details', ['order_id' => $order->id]) }}" class="btn btn-sm btn-primary text-white">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center p-0" colspan="7">
                                                    <p class="mb-5 mt-5">
                                                        No Order has been made yet.
                                                    </p>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <hr class="mt-0 mb-3 pb-2" />
                                <div class="divider"></div>
                                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                    {{ $orders->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="mb-5"></div><!-- margin -->
@endsection