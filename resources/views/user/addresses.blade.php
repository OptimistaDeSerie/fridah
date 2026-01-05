@extends('layouts.app')
@section('main-content')
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<main class="main bg-grey">
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">My Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Addresses</li>
            </ol>
        </nav>

        <div class="container account-container custom-account-container">
            <div class="row">
                <!-- Sidebar -->
                <div class="sidebar widget widget-dashboard mb-lg-0 mb-3 col-lg-3 order-0">
                    <h2 class="text-uppercase">My Account</h2>
                    @include('user.account-nav')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9 order-lg-last order-1 tab-content">
                    <div class="tab-pane fade show active" id="addresses" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>My Addresses</h3>
                            <a href="{{ route('cart.checkout') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Address
                            </a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($addresses->isEmpty())
                            <div class="alert alert-info">
                                You have no saved addresses yet. 
                                <a href="{{ route('cart.checkout') }}">Add one during checkout</a> or go to checkout to create your first address.
                            </div>
                        @else
                            <div class="row">
                                @foreach($addresses as $address)
                                    <div class="col-md-6 mb-4">
                                        <div class="address-box p-4 border rounded position-relative
                                            {{ $address->isdefault ? 'border-primary bg-light' : '' }}">
                                             <p class="mb-2"><strong>Address:</strong><br>
                                                {{ $address->address }}
                                            </p>

                                            @if($address->deliveryFee)
                                                <p class="mb-1">
                                                    <strong>State:</strong> {{ $address->deliveryFee->state->title ?? 'N/A' }}
                                                </p>
                                                <p class="mb-1">
                                                    <strong>Carrier:</strong> {{ $address->deliveryFee->carrier->title ?? 'N/A' }}
                                                </p>
                                                <p class="mb-3">
                                                    <strong>Delivery Fee:</strong> ₦{{ number_format($address->deliveryFee->price, 2) }}
                                                </p>
                                            @else
                                                <p class="text-danger mb-3">Warning: No delivery fee linked</p>
                                            @endif

                                            <div class="mt-3">
                                                @if(!$address->isdefault)
                                                    <form action="{{ route('user.set_default_address', $address) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                            Set as Default
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="mb-5"></div>
@endsection
@push('scripts')
<script>
    document.querySelectorAll('form[action*="/set-default"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Set as Default?',
                text: "This will make this address your default for future orders.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, set as default',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#007bff'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush