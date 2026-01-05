@extends('layouts.app')
@section('main-content')
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<main class="main bg-grey">
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">My Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Details</li>
            </ol>
        </nav>

        <div class="container account-container custom-account-container">
            <div class="row">
                <div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
                    <h2 class="text-uppercase">My Account</h2>
                    @include('user.account-nav')
                </div>

                <div class="col-lg-9 order-lg-last order-1 tab-content">
                    <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                        <h3 class="mb-4">Order Details</h3>

                        {{-- ORDER SUMMARY --}}
                        <div class="addresses-content mb-5">
                            <div class="row">
                                <div class="address col-md-6">
                                    <div class="heading d-flex">
                                        <h4 class="text-dark mb-0">Order Information</h4>
                                    </div>
                                    <div class="address-box">
                                        <p><strong>Order No:</strong> {{ $order->order_no }}</p>
                                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>
                                        <p><strong>Status:</strong> 
                                            @if($order->status == 'delivered')
                                                <span class="badge bg-success text-white">Delivered</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger text-white">Canceled</span>
                                            @else
                                                <span class="badge bg-warning text-white">Ordered</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="address col-md-6 mt-5 mt-md-0">
                                    <div class="heading d-flex">
                                        <h4 class="text-dark mb-0">Shipping Address</h4>
                                    </div>
                                    <div class="address-box">
                                        <p>{{ optional($order->defaultAddress)->address ?? 'No address available' }}</p>

                                        @if($order->defaultAddress && $order->defaultAddress->deliveryFee)
                                            <p>
                                                <strong>State:</strong> {{ $order->defaultAddress->deliveryFee->state->title ?? 'N/A' }}<br>
                                                <strong>Carrier:</strong> {{ $order->defaultAddress->deliveryFee->carrier->title ?? 'N/A' }}<br>
                                                <strong>Delivery Fee:</strong> ₦{{ number_format($order->defaultAddress->deliveryFee->price ?? 0, 2) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ORDERED ITEMS --}}
                        <div class="addresses-content mb-5">
                            <div class="heading d-flex">
                                <h4 class="text-dark">Ordered Items</h4>
                            </div>
                            <div class="table-responsive">
                                @if(Session::has('status'))
                                    <p class='alert alert-success'>{{Session::get('status')}}</p>
                                @endif
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset('backend/uploads/products/thumbnails/' . $item->product->image) }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         width="60">
                                                </td>
                                                <td>
                                                    <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}" target="_blank">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </td>
                                                <td>₦{{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>₦{{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-3">
                                    {{ $orderItems->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>

                        {{-- TRANSACTION DETAILS --}}
                        <div class="addresses-content">
                            <div class="heading d-flex">
                                <h4 class="text-dark">Transaction Summary</h4>
                            </div>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Subtotal</th>
                                    <td>₦{{ number_format($order->subtotal, 2) }}</td>
                                    <th>Delivery Fee</th>
                                    <td>₦{{ number_format(optional($order->defaultAddress->deliveryFee)->price ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>₦{{ number_format($order->total, 2) }}</td>
                                    <th>Payment Mode</th>
                                    <td>{{ $transaction->mode ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status</th>
                                    <td colspan="3">
                                        @if($transaction)
                                            @if($transaction->status == 'approved')
                                                <span class="badge bg-success text-white">Approved</span>
                                            @elseif($transaction->status == 'declined')
                                                <span class="badge bg-danger text-white">Declined</span>
                                            @elseif($transaction->status == 'refunded')
                                                <span class="badge bg-secondary text-white">Refunded</span>
                                            @else
                                                <span class="badge bg-warning text-white">Pending</span>
                                            @endif
                                        @else
                                            <span class="text-muted">No transaction record</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        @if($order->status != 'canceled' && $order->status != 'delivered')
                            <!-- <div class='wg-box mt-5 text-right'>                    
                                <form action="{{ route('user.cancel_order') }}" method='POST'>
                                    @csrf
                                    @method('PUT')
                                    <input type='hidden' name='order_id' value='{{$order->id}}' />
                                    <button type='button' class='btn btn-danger' id="cancel-order">Cancel Order</button>                        
                                </form>
                            </div> -->
                        @endif
                    </div> {{-- tab-pane --}}
                </div> {{-- col-lg-9 --}}
            </div>
        </div>
    </div>
</main>
<div class="mb-5"></div>
@endsection
@push('scripts')
    <script>
        $(function(){
            $("#cancel-order").on('click',function(e){
                e.preventDefault();
                var selectedForm = $(this).closest('form');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to cancel this order?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes!",
                    cancelButtonText: "No!",
                    confirmButtonColor: '#dc3545',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(function (result) {
                    if (result.isConfirmed) {
                        selectedForm.submit();  
                    }
                });                             
            });
        });
    </script>    
@endpush
