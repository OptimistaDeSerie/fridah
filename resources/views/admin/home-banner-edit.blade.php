@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Banner</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{route('admin.banners')}}"><div class="text-tiny">Banners</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit</div></li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <input type="hidden" name="id" value="{{ $banner->id }}">

                <fieldset class="name">
                    <div class="body-title">Banner Type <span class="tf-color-1">*</span></div>
                    <select name="banner_type" class="flex-grow" required>
                        <option value="left" {{ $banner->banner_type == 'left' ? 'selected' : '' }}>Main Banner (Large)</option>
                        <option value="right" {{ $banner->banner_type == 'right' ? 'selected' : '' }}>Side Banner (Small)</option>
                    </select>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Title</div>
                    <input class="flex-grow" type="text" name="title" value="{{ old('title', $banner->title) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Subtitle</div>
                    <input class="flex-grow" type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Short Text</div>
                    <input class="flex-grow" type="text" name="short_text" value="{{ old('short_text', $banner->short_text) }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Description</div>
                    <textarea class="flex-grow" name="description">{{ old('description', $banner->description) }}</textarea>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Sort Order</div>
                    <input class="flex-grow" type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}">
                </fieldset>

                <fieldset>
                    <div class="body-title">Status</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="status" value="1" {{ old('status', $banner->status) ? 'checked' : '' }} class="w-4 h-4">
                        <span class="body-text">Active</span>
                    </label>
                </fieldset>

                <fieldset>
                    <div class="body-title">Current Image</div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('backend/uploads/banners/' . $banner->image) }}" class="effect8" alt="">
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