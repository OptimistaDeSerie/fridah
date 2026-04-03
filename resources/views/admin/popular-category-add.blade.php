@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Popular Category Slider Item</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{route('admin.popular.categories')}}"><div class="text-tiny">Popular Categories Slider</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add New</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <form class="form-new-product form-style-1" 
                  action="{{ route('admin.popular.category.save') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf

                <fieldset class="name">
                    <div class="body-title">Title <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" name="title" value="{{ old('title') }}" required>
                </fieldset>
                @error('title') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Count Text <span class="tf-color-1">*</span> <small>(e.g. 4 Products)</small></div>
                    <input class="flex-grow" type="text" name="count_text" value="{{ old('count_text') }}" required>
                </fieldset>
                @error('count_text') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Link URL <span class="tf-color-1">*</span> <small>(e.g. fridahspice.com/product_xxxx)</small></div>
                    <input class="flex-grow" type="text" name="link_url" value="{{ old('link_url') }}" placeholder="link to product" required>
                </fieldset>
                @error('link_url') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Sort Order <small>(lower = appears first)</small></div>
                    <input class="flex-grow" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                </fieldset>

                <fieldset>
                    <div class="body-title">Status</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="status" id="status" value="1" 
                               {{ old('status', 1) ? 'checked' : '' }} checked class="w-4 h-4">
                        <span class="body-text">Active (show on homepage)</span>
                    </label>
                </fieldset>

                <fieldset>
                    <div class="body-title">Image <span class="tf-color-1">*</span> <small>(Recommended: 341x200)</small></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none;">
                            <img src="" class="effect8" alt="">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">Drop your image here or select (341px by 200px)<span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function(){
        $("#myFile").on("change", function(){
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });
    });
</script>
@endpush