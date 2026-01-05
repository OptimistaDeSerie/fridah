<ul class="nav nav-tabs list flex-column mb-0" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('user.index') }}" aria-controls="dashboard" aria-selected="true">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.orders') }}" aria-controls="order" aria-selected="true">Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.addresses') }}" aria-controls="address" aria-selected="true">Shipping Addresses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="login.html">Logout</a>
    </li>
</ul>