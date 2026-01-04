@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Shop Banner</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.shop_banners') }}"><div class="text-tiny">Shop Banners</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add New</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <form class="form-new-product form-style-1"
                  action="{{ route('admin.shop_banner.save') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <fieldset class="name">
                    <div class="body-title">Admin Title <small>(for reference only)</small></div>
                    <input class="flex-grow" type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Fashion Mega Sale">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 1 <small>(e.g. Fashion)</small></div>
                    <input class="flex-grow" type="text" name="line_1" value="{{ old('line_1') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 2 <small>(e.g. mega sale)</small></div>
                    <input class="flex-grow" type="text" name="line_2" value="{{ old('line_2') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 3 <small>(e.g. extra)</small></div>
                    <input class="flex-grow" type="text" name="line_3" value="{{ old('line_3') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 4 <small>(e.g. 60<i>%</i> OFF – use HTML)</small></div>
                    <input class="flex-grow" type="text" name="line_4" value="{{ old('line_4') }}" placeholder='60<i>%</i> OFF'>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Line 5 <small>(e.g. On order above $555)</small></div>
                    <input class="flex-grow" type="text" name="line_5" value="{{ old('line_5') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Button Text <small>(e.g. SHOP NOW)</small></div>
                    <input class="flex-grow" type="text" name="button_text" value="{{ old('button_text') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Button Link <small>(URL)</small></div>
                    <input class="flex-grow" type="url" name="button_link" value="{{ old('button_link') }}" placeholder="https://...">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Sort Order</div>
                    <input class="flex-grow" type="number" name="sort_order" value="{{ old('sort_order', 0) }}">
                </fieldset>

                <fieldset>
                    <div class="body-title">Status</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="status" value="1" checked class="w-4 h-4">
                        <span class="body-text">Active (show on shop page)</span>
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
                                <span class="body-text">Drop image here or select <span class="tf-color">click to browse</span><br>
                                    <small>Recommended: 870px × 300px</small>
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