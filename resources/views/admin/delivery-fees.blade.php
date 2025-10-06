@extends('layouts.admin')
@section('main-content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/dataTables.dataTables.min.css') }}">
<style>
    .table-striped th:nth-child(1), .table-striped td:nth-child(1) {
        width: 100px;   
    }
    .table-striped th:nth-child(2), .table-striped td:nth-child(2) {
        width: 250px;   
    }
</style>
<div class="main-content-inner">                            
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Delivery Fees</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>                                                                           
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Delivery Fees</div>
                </li>
            </ul>
        </div>
        
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <a class="tf-button style-1 w208" href="{{ route('admin.delivery-fee.add') }}"><i class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">
                @if(Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif
                <table id="deliveryFeesTable" class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>Carrier</th>
                            <th>Weight</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables JS -->
<script src="{{ asset('assets/js/dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script>
$(document).ready(function() {
    var table = $('#deliveryFeesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.delivery-fees') }}",
            type: 'GET',
        },
        columns: [
            { data: 'state.title', name: 'states.title', searchable: true },
            { data: 'carrier.title', name: 'carriers.title', searchable: true },
            { data: 'weight.title', name: 'weights.title', searchable: true },
            { data: 'price', name: 'delivery_fees.price', searchable: true, render: function(data) {
                if (!data || isNaN(Number(data))) {
                    return '₦0.00';
                }
                return '₦' + Number(data).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }},
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        pageLength: 10,
        ordering: true,
        searching: true,
        lengthChange: true
    });

    // Handle delete confirmation
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        var selectedForm = $(this).closest('form');
        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this Delivery Fee?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonText: 'No!',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                selectedForm.submit();
            }
        });
    });
});
</script>    
@endpush