@extends('layouts.admin')
@section('main-content')
<!-- DataTables CSS -->
<div class="main-content-inner">                            
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Weights</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Weights</div></li>
            </ul>
        </div>
        
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <a class="tf-button style-1 w208" href="{{ route('admin.weight.add') }}"><i class="icon-plus"></i>Add new</a>
            </div>
            <div class="table-responsive">
                @if(Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif
                <table id="weightsTable" class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Title</th>
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
<script>
$(document).ready(function() {
    var table = $('#weightsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.weights') }}",
            type: 'GET',
        },
        columns: [
            { data: 'title', name: 'title', searchable: true },
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
            text: "You want to delete this Weight?",
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