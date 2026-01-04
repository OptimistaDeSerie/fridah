@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Shop Banner</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.shop_banners') }}"><div class="text-tiny">Shop Banners</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <form class="form-new-product form-style-1"
                  action="{{ route('admin.shop_banner.update') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $banner->id }}">

                <fieldset class="name">
                    <div class="body-title">Admin Title</div>
                    <input class="flex-grow" type="text" name="title" value="{{ old('title', $banner->title) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 1</div>
                    <input class="flex-grow" type="text" name="line_1" value="{{ old('line_1', $banner->line_1) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 2</div>
                    <input class="flex-grow" type="text" name="line_2" value="{{ old('line_2', $banner->line_2) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 3</div>
                    <input class="flex-grow" type="text" name="line_3" value="{{ old('line_3', $banner->line_3) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 4 <small>(supports HTML like &lt;i&gt;)</small></div>
                    <input class="flex-grow" type="text" name="line_4" value="{{ old('line_4', $banner->line_4) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 5</div>
                    <input class="flex-grow" type="text" name="line_5" value="{{ old('line_5', $banner->line_5) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Button Text</div>
                    <input class="flex-grow" type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Button Link</div>
                    <input class="flex-grow" type="url" name="button_link" value="{{ old('button_link', $banner->button_link) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Sort Order</div>
                    <input class="flex-grow" type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}">
                </fieldset>

                <fieldset>
                    <div class="body-title">Status</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox"
                               name="status"
                               value="1"
                               {{ old('status', $banner->status) ? 'checked' : '' }}
                               class="w-4 h-4">
                        <span class="body-text">Active</span>
                    </label>
                </fieldset>

                <fieldset>
                    <div class="body-title">Current Image</div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('backend/uploads/shop-banners/' . $banner->image) }}"
                                 class="effect8"
                                 alt="Current banner">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">Change image <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                    <small class="text-muted">Leave empty to keep current image.</small>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#myFile").on("change", function(){
        const [file] = this.files;
        if (file) {
            $("#imgpreview img").attr('src', URL.createObjectURL(file));
        }
    });
</script>
@endpush