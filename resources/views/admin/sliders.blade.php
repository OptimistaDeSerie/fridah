@extends('layouts.admin')
@section('main-content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Home Sliders</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">All Sliders</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <!-- search if needed -->
                </div>
                <a class="tf-button style-1 w208" href="{{ route('admin.slider.add') }}"><i class="icon-plus"></i>Add new</a>
            </div>

            @if(Session::has('success'))
                <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif

            <div class="wg-table table-all-user">
                <table class="table table-striped table-bordered table-responsive" id="sliders-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title / Subtitle</th>
                            <th>Offer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                        <tr>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{ asset('backend/uploads/sliders/' . $slider->image) }}" alt="" style="max-height:80px;">
                                </div>
                            </td>
                            <td>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{ $slider->title }}</a><br>
                                    <small>{{ $slider->subtitle }}</small>
                                </div>
                            </td>
                            <td>{{ $slider->offer_text }}</td>
                            <td>{{ $slider->status ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{ route('admin.slider.edit', ['id' => $slider->id]) }}">
                                        <div class="item edit"><i class="icon-edit-3"></i></div>
                                    </a>
                                    <form action="{{ route('admin.slider.delete', ['id' => $slider->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <div class="item text-danger delete"><i class="icon-trash-2"></i></div>
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
                {{ $sliders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#sliders-table').DataTable({
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
    $(function(){
        $(".delete").on('click',function(e){
            e.preventDefault();
            var selectedForm = $(this).closest('form');
            swal({
                title: "Are you sure?",
                text: "You want to delete this record?",
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