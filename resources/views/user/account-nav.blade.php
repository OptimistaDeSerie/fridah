<ul class="nav nav-tabs list flex-column mb-0" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('user.index') }}" aria-controls="dashboard" aria-selected="true">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.orders') }}" aria-controls="order" aria-selected="true">Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab"
            aria-controls="address" aria-selected="false">Addresses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="edit-tab" data-toggle="tab" href="#edit" role="tab"
            aria-controls="edit" aria-selected="false">Account details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="shop-address-tab" data-toggle="tab" href="#shipping" role="tab"
            aria-controls="edit" aria-selected="false">Shopping Address</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="login.html">Logout</a>
    </li>
</ul>