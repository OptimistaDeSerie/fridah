@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Hot Deals Products</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Hot Deals</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow"></div>
                <a class="tf-button style-1 w208" href="{{ route('admin.hot.deal.add') }}">
                    <i class="icon-plus"></i>Add Product
                </a>
            </div>

            @if(session('success'))
                <p class="alert alert-success">{{ session('success') }}</p>
            @endif

            <div class="wg-table table-all-user">
                <table class="table table-striped table-bordered table-responsive" id="hot-deals-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>HOT Label</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr>
                            <td>
                                @if($item->product?->image)
                                    <img src="{{ asset('backend/uploads/products/' . $item->product->image) }}"
                                         style="max-height:80px; object-fit:cover; border-radius:4px;">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>{{ $item->product?->name ?? 'Deleted' }}</td>
                            <td>{{ $item->product?->price ?? '-' }}</td>
                            <td>{{ $item->show_hot_label ? 'Yes' : 'No' }}</td>
                            <td>{{ $item->status ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{ route('admin.hot.deal.edit', $item->id) }}">
                                        <div class="item edit"><i class="icon-edit-3"></i></div>
                                    </a>
                                    <form action="{{ route('admin.hot.deal.delete', $item->id) }}" method="POST" style="display:inline">
                                        @csrf @method('DELETE')
                                        <div class="item text-danger delete"><i class="icon-trash-2"></i></div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No hot deals yet. <a href="{{ route('admin.hot.deal.add') }}">Add one</a></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{ $items->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#hot-deals-table').DataTable({
        paging: true,
        searching: true,
        info: true,
        lengthChange: true, // hides "Show entries" dropdown if you want
        language: {
            search: "Search:",
            paginate: {
                previous: "<i class='icon-chevron-left'></i>",
                next: "<i class='icon-chevron-right'></i>"
            }
        }
    });
    $('.dt-input').addClass('float-start mb-3').css({
        'margin-right': '100px',
    });
    $(".delete").click(function(e){
        e.preventDefault();
        var form = $(this).closest('form');
        swal({
            title: "Are you sure?",
            text: "Remove this product from Hot Deals?",
            type: "warning",
            buttons: ["Cancel", "Yes"],
            confirmButtonColor: '#dc3545'
        }).then((willDelete) => {
            if (willDelete) form.submit();
        });
    });
</script>
@endpush