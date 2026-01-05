@extends('layouts.app')
@section('main-content')
<hr class="divider mb-0 mt-0">
<main class="main">
    <div class="container">
        <ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
            <li class="active">
                <a href="javascript:void(0)" style="color: #4dae65;">Shopping Cart</a>
            </li>
            <li>
                <a href="javascript:void(0)">Checkout</a>
            </li>
            <li class="disabled">
                <a href="javascript:void(0)">Order Complete</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-table-container">
                    @if($cartItems->count() > 0)
                    <table class="table table-cart">
                        <thead>
                            <tr>
                                <th class="thumbnail-col"></th>
                                <th class="product-col">Product</th>
                                <th class="price-col">Price</th>
                                <th class="qty-col">Quantity</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $cartItem)
                            <tr class="product-row">
                                <td>
                                    <figure class="product-image-container">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $cartItem->model->slug]) }}" class="product-image">
                                            <img loading="lazy" src="{{asset('backend/uploads/products')}}/{{$cartItem->model->image}}" alt="{{$cartItem->name}}">
                                        </a>
                                        <form method="POST" action="{{route('cart.remove',['rowId'=>$cartItem->rowId])}}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0)" class="btn-remove icon-cancel remove-cart-item" title="Remove Product"></a>
                                        </form>
                                    </figure>
                                </td>
                                <td class="product-col">
                                    <h5 class="product-title">
                                        <a href="{{ route('shop.product.details', ['product_slug' => $cartItem->model->slug]) }}">{{$cartItem->name}}</a>
                                    </h5>
                                </td>
                                <td>{{ $cartItem->price }}</td>
                                <td>
                                    <div class="product-single-qty">
                                        <input class="horizontal-quantity form-control" type="text" data-rowid="{{ $cartItem->rowId }}" name="quantity" value="{{ $cartItem->qty }}" readonly>
                                    </div><!-- End .product-single-qty -->
                                </td>
                                <td class="text-right"><span class="subtotal-price">{{$cartItem->subTotal()}}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="clearfix">
                                    <div class="float-right">
                                        <div class="float-right">
                                            <form method="POST" action="{{ route('cart.empty') }}" id="clear-cart-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-shop btn-update-cart btn-add-cart1" id="clear-cart-btn">
                                                    Clear Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div><!-- End .float-right -->
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    @else
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p>Your cart is empty.</p>
                            </div>  
                        </div>
                    @endif
                </div><!-- End .cart-table-container -->
            </div><!-- End .col-lg-8 -->

            <div class="col-lg-4">
                <div class="cart-summary">
                    <h3>CART TOTALS</h3>

                    <table class="table table-totals">
                        <tbody>
                            <tr>
                                <td>Subtotal</td>
                                <td id="cart-subtotal">{{Cart::instance('cart')->subtotal()}}</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td id="cart-total">{{Cart::instance('cart')->subtotal()}}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="checkout-methods">
                        <a href="{{route('cart.checkout')}}" class="btn btn-block btn-primary">Proceed to Checkout
                            <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div><!-- End .cart-summary -->
            </div><!-- End .col-lg-4 -->
        </div><!-- End .row -->
    </div><!-- End .container -->
    <div class="mb-6"></div><!-- margin -->
</main><!-- End .main -->
@endsection
@push('scripts')
<script>
$(function() {
    $('.remove-cart-item').on('click', function(e) {
        e.preventDefault();
        let $btn = $(this);
        let $form = $btn.closest('form');
        let url = $form.attr('action');
        let token = $form.find('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                _method: 'DELETE'
            },
            success: function(response) {
                // Remove the product row from the table
                $btn.closest('tr').fadeOut(300, function() {
                    $(this).remove();
                });
                if (response.sub_total) {
                    $('#cart-total').text(response.sub_total);
                    $('#cart-subtotal').text(response.sub_total);
                    $('.cart-price').text('₦' + response.sub_total); // Update header cart subtotal
                    $('.cart-count').text(response.count); // Update header cart count
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Failed to remove item from cart.');
            }
        });
    });
});
$(function() {
    $('#clear-cart-form').on('submit', function(e) {
        e.preventDefault();

        let $form = $(this);
        let $btn = $form.find('button[type="submit"]');
        let url = $form.attr('action');
        let token = $form.find('input[name="_token"]').val();

        Swal.fire({
            title: 'Clear Cart?',
            text: "Are you sure you want to remove all items from your cart?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, clear it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable button and show spinner
                $btn.prop('disabled', true);
                let originalText = $btn.html();
                $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Clearing...');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: token,
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        // Replace main cart table with empty message
                        $('.cart-table-container').html(`
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p>Your cart is empty.</p>
                                </div>  
                            </div>
                        `);

                        // Reset cart totals in main table
                        $('#cart-total').text('0');
                        $('#cart-subtotal').text('0');

                        // Reset header cart count and subtotal
                        $('.cart-count').remove(); // remove badge
                        $('.cart-price').text('₦0.00'); // reset subtotal

                        Swal.fire({
                            icon: 'success',
                            title: 'Cleared!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error',
                            'Failed to clear cart.',
                            'error'
                        );
                    },
                    complete: function() {
                        // Re-enable button and restore text
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            }
        });
    });
});


</script>
@endpush