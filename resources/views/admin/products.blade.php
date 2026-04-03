@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">                            
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Products</h3>
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
                    <div class="text-tiny">Products</div>
                </li>
            </ul>
        </div>
        
        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow"></div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}"><i class="icon-plus"></i>Add new</a>
                </div>
            <div class="table-responsive">
                @if(Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif
                @if(Session::has('status'))
                    <p class="alert alert-success">{{ Session::get('status') }}</p>
                @endif

                <table class="table table-striped table-bordered table-responsive" id="products-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <!-- Replaced Price & SalePrice with Price Range -->
                            <th>Price Range</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Stock Status</th>
                            <!-- Total Stock (sum of all sizes) -->
                            <th>Total Stock</th>
                            <!-- Available Sizes -->
                            <th>Sizes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('backend/uploads/products/thumbnails')}}/{{$product->image}}" alt="" class="image">
                                </div>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{$product->name}}</a>
                                    <div class="text-tiny mt-3">{{$product->slug}}</div>
                                </div>  
                            </td>
                            <td>
                                @if($product->sizes->count() > 0)
                                    ₦{{ number_format($product->sizes->min('sale_price')) }}
                                    @if($product->sizes->min('sale_price') != $product->sizes->max('sale_price'))
                                        - ₦{{ number_format($product->sizes->max('sale_price')) }}
                                    @endif
                                @else
                                    <span class="text-muted">No sizes</span>
                                @endif
                            </td>
                            <td>{{$product->SKU}}</td>
                            <td>{{$product->category?->name ?? 'Uncategorized'}}</td>
                            <td>
                                <span class="badge {{ $product->stock_status == 'instock' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($product->stock_status) }}
                                </span>
                            </td>
                            <td>
                                <!-- Total quantity across all sizes -->
                                {{ $product->sizes->sum('quantity') }}
                            </td>
                            <td>
                                <!-- List all sizes (compact view) -->
                                @if($product->sizes->count() > 0)
                                    <small>
                                        @foreach($product->sizes as $size)
                                            <div>{{ $size->size }} ({{ $size->quantity }} pcs)</div>
                                        @endforeach
                                    </small>
                                @else
                                    <span class="text-muted">None</span>
                                @endif
                            </td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('admin.product.edit',['id'=>$product->id])}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('admin.product.delete',['id'=>$product->id])}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach                                  
                    </tbody>
                </table>
            </div>
            
            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">                
                {{$products->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
    $('#products-table').DataTable({
        paging: true,
        searching: true,
        info: true,
        lengthChange: true,
        language: {
            search: "Search:",
            paginate: {
                previous: "<i class='icon-chevron-left'></i>",
                next: "<i class='icon-chevron-right'></i>"
            }
        },
        //Make sizes column readable in DataTables
        columnDefs: [
            { targets: [7], orderable: false } // Sizes column
        ]
    });

    $('.dt-input').addClass('float-start mb-3').css({
        'margin-right': '10px',
    });

    $(function(){
        $(".delete").on('click',function(e){
            e.preventDefault();
            var selectedForm = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to delete this Product? This will also delete all its sizes!",
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