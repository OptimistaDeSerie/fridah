@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add New Banner</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{route('admin.banners')}}"><div class="text-tiny">Banners</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">New Banner</div></li>
            </ul>
        </div>
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.banner.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset class="name">
                    <div class="body-title">Banner Type <span class="tf-color-1">*</span></div>
                    <select name="banner_type" class="flex-grow" required>
                        <option value="left">Main Banner (Large - left side)</option>
                        <option value="right">Side Banner (Small - right side)</option>
                    </select>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Title</div>
                    <input class="flex-grow" type="text" name="title" value="{{ old('title') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Subtitle</div>
                    <input class="flex-grow" type="text" name="subtitle" value="{{ old('subtitle') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Short Text <small>(e.g. Fresh!, Sugar-Free)</small></div>
                    <input class="flex-grow" type="text" name="short_text" value="{{ old('short_text') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Description</div>
                    <textarea class="flex-grow" name="description">{{ old('description') }}</textarea>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Sort Order</div>
                    <input class="flex-grow" type="number" name="sort_order" value="{{ old('sort_order', 0) }}">
                </fieldset>

                <fieldset>
                    <div class="body-title">Status</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="status" value="1" checked class="w-4 h-4">
                        <span class="body-text">Active (show on frontend)</span>
                    </label>
                </fieldset>

                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img src="" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to browse</span><br>
                                    <small>Left: ~939×235px | Right: ~460×235px</small>
                                </span>
                                <input type="file" id="myFile" name="image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger">{{ $message }}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save Banner</button>
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
            $("#imgpreview").show();
        }
    });
</script>
@endpush