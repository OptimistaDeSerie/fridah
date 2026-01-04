@extends('layouts.admin')
@section('main-content')
<style>
    .table-transaction>tbody>tr:nth-of-type(odd) {
        --bs-table-accent-bg: #fff !important;
    }    
</style>
<div class="main-content-inner">                            
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Order Details</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>                                                                           
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Order Items</div>
                </li>
            </ul>
        </div>       
        
        <div class="wg-box mt-5 mb-5">            
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Ordered Details</h5>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.orders')}}">Back</a>
            </div>
            @if(Session::has('status'))
                <p class='alert alert-success'>{{Session::get('status')}}</p>
            @endif             
            <table class="table table-bordered table-transaction responsive">
                <tr>
                    <th>Order No</th>
                    <td>{{$transaction->order->order_no}}</td>
                    <th>Mobile</th>
                    <td>{{$transaction->order->user->phone}}</td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{$transaction->order->created_at}}</td>
                    <th>Email</th>
                    <td>{{$transaction->order->user->email}}</td>
                </tr>
                <tr>
                    <th>Delivered Date</th>
                    <td>{{$transaction->order->delivered_date}}</td>
                    <th>Order Date</th>
                    <td>{{$transaction->order->created_at}}</td>
                </tr>
                <tr>
                    <th>Order Status</th>
                    <td>
                        @if($transaction->order->status=='delivered')
                            <span class="badge bg-success">Delivered</span>
                        @elseif($transaction->order->status=='canceled')
                            <span class="badge bg-danger">Canceled</span>
                        @else
                            <span class="badge bg-warning">Ordered</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>        
        
        <div class="wg-box mt-5">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Ordered Items</h5>
                </div>            
            </div>
            <div class="table-responsive">
                <table class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th class="">Price</th>
                            <th class="">Quantity</th>
                            <th class="">SKU</th>
                            <th class="">Category</th>
                            <th class="">Return Status</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderitems as $orderitem)
                        <tr>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('backend/uploads/products/thumbnails')}}/{{$orderitem->product->image}}" alt="" class="image">
                                </div> 
                            </td>
                            <td class="">
                                <div class="name">
                                    <a href="{{route('shop.product.details',['product_slug'=>$orderitem->product->slug])}}" target="_blank" class="body-title-2">{{$orderitem->product->name}}</a>                                    
                                </div>
                            </td>
                            <td class="">₦{{$orderitem->price}}</td>
                            <td class="">{{$orderitem->quantity}}</td>
                            <td class="">{{$orderitem->product->SKU}}</td>
                            <td class="">{{$orderitem->product->category->name}}</td>
                            <td class="">{{$orderitem->rstatus == 0 ? "No":"Yes"}}</td>                                                                                
                            <td class="">
                                <a href="{{route('shop.product.details',['product_slug'=>$orderitem->product->slug])}}" target="_blank">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>                                                                    
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @endforeach                                  
                    </tbody>
                </table>
            </div>
            
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">                
                {{$orderitems->links('pagination::bootstrap-5')}}
            </div>
        </div>
        <div class="wg-box mt-5">
            <h5>Shipping Address</h5>
            <div class="my-account__address-item col-md-6">                
                <div class="my-account__address-item__detail">
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
        <div class='wg-box mt-5'>
            <h5>Update Order Status</h5>
            <form action="{{route('admin.order.status.update')}}" method='POST'>
                @csrf
                @method('PUT')
                <input type='hidden' name='order_id' value='{{ $transaction->order->id }}'  />
                <div class='row'>
                    <div class='col-md-3'>
                        <div class='select'>
                            <select id='order_status' name='order_status'>                            
                                <option value='ordered' {{$transaction->order->status=='ordered' ? 'selected':''}}>Ordered</option>
                                <option value='delivered' {{$transaction->order->status=='delivered' ? 'selected':''}}>Delivered</option>
                                <option value='canceled' {{$transaction->order->status=='canceled' ? 'selected':''}}>Canceled</option>
                            </select>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <button type='submit' class='btn btn-primary tf-button w208'>Update</button>
                    </div>                    
                </div>
            </form>
        </div>
        <div class="wg-box mt-5">
            <h5>Transactions</h5>
            <table class="table responsive table-bordered table-transaction">
                <tr>
                    <th>Subtotal</th>
                    <td>₦{{$transaction->order->subtotal}}</td>
                    <th>Payment Mode</th>
                    <td>{{$transaction->mode}}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>₦{{$transaction->order->total}}</td>

                    <th>Status</th>
                    <td>
                        @if($transaction->status=='approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($transaction->status=='declined')
                            <span class="badge bg-danger">Declined</span>
                        @elseif($transaction->status=='refunded')
                            <span class="badge bg-secondary">Refunded</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                </tr>                
            </table>
        </div>       
    </div>
</div>
@endsection