@extends('layouts.app')
@section('main-content')
<main class="main">
    <div class="container text-center py-5">
        <h2>Processing Your Payment...</h2>
        <p>Please wait while we confirm your payment (Reference: {{ $reference }})</p>
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-4">You will be redirected shortly. Do not close this page.</p>
    </div>
</main>
<script>
    // Optional: poll order status or just redirect
    setTimeout(() => {
        window.location.href = "{{ route('user.orders') }}";
    }, 8000);
</script>
@endsection