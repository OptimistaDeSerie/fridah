@extends('layouts.admin')
@section('main-content')
<style>
/*     .table-striped th:nth-child(1), .table-striped td:nth-child(1) {
        width: 100px;   
    }
    .table-striped th:nth-child(2), .table-striped td:nth-child(2) {
        width: 250px;   
    } */
    #ordersTable td:nth-child(2),
    #ordersTable td:nth-child(8) {
        text-align: left !important;
    }
    .align-left{
        text-align: left !important;
    }
</style>
<div class="main-content-inner">                            
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Orders</h3>
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
                    <div class="text-tiny">Orders</div>
                </li>
            </ul>
        </div>
        
        <div class="wg-box">
            <div class="table-responsive">
                @if(Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif
                @if(Session::has('status'))
                    <p class='alert alert-success'>{{Session::get('status')}}</p>
                @endif
                <table id="ordersTable" class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th class="align-left">Phone</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th class="align-left">Total Items</th>
                            <th>Order No</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="divider"></div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        var table = $('#ordersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.orders') }}",
                type: 'GET',
            },
            columns: [
                { data: 'user', name: 'user' }, // custom search by CONCAT(firstname, lastname)
                { data: 'phone', name: 'users.phone' },
                { data: 'subtotal', name: 'orders.subtotal' },
                { data: 'total', name: 'orders.total' },
                { data: 'status', name: 'orders.status' },
                { data: 'order_date', name: 'orders.created_at' },
                { data: 'total_items', orderable: false, searchable: true },
                { data: 'order_no', name: 'orders.order_no' },
                { data: 'actions', orderable: false, searchable: false }
            ],
            pageLength: 10,
            ordering: true,
            searching: true,
            lengthChange: true
        });
        $(".delete").on('click',function(e){
            e.preventDefault();
            var selectedForm = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to delete this Product?",
                type: "warning",
                buttons: ["No!", "Yes!"],
                confirmButtonColor: '#dc3545'
            }).then(function (result) {
                if (result) {
                    selectedForm.submit();  
                }
            });                             
        });
    });
</script>    
@endpush 