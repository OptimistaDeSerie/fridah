@extends('layouts.app')

@section('main-content')
<main class="main">
    <div class="container py-5">
        <div class="card shadow-lg border-0 mx-auto" style="max-width: 500px;">
            <div class="card-body text-center p-5">
                <div class="mb-4">
                    <div class="spinner-grow text-primary me-1"></div>
                    <div class="spinner-grow text-primary me-1" style="animation-delay: .2s;"></div>
                    <div class="spinner-grow text-primary" style="animation-delay: .4s;"></div>
                </div>
                <h3 class="fw-bold mb-3">Processing Your Payment</h3>
                <p class="text-muted">
                    Please wait while we confirm your payment.
                </p>
                <div class="alert alert-light small mt-3">
                    <strong>Reference:</strong> {{ $reference }}
                </div>
                <p class="mt-3 text-muted small">
                    This may take a few seconds. Do not close this page.
                </p>
            </div>
        </div>
    </div>
</main>

<script>
    const reference = "{{ $reference }}";
    function checkPaymentStatus() {
        fetch(`/payment-status/${reference}`)
            .then(response => response.json())
            .then(data => {
                if (data.approved) {
                    window.location.href = "{{ route('user.orders') }}";
                }
            });
    }
    setInterval(checkPaymentStatus, 3000);
</script>
@endsection