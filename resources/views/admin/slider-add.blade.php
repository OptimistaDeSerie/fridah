@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slider Information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{route('admin.sliders')}}"><div class="text-tiny">Sliders</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">New Slider</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.slider.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset class="name">
                    <div class="body-title">Title</div>
                    <input class="flex-grow" type="text" name="title" value="{{ old('title') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Subtitle</div>
                    <input class="flex-grow" type="text" name="subtitle" value="{{ old('subtitle') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Short Text (e.g. Fresh!)</div>
                    <input class="flex-grow" type="text" name="short_text" value="{{ old('short_text') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Description</div>
                    <textarea class="flex-grow" name="description">{{ old('description') }}</textarea>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Offer Text (e.g. up to 50%)</div>
                    <input class="flex-grow" type="text" name="offer_text" value="{{ old('offer_text') }}">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Text Position</div>
                    <select name="text_position" class="flex-grow">
                        <option value="left" {{ old('text_position', 'left') == 'left' ? 'selected' : '' }}>Left</option>
                        <option value="right" {{ old('text_position') == 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Sort Order</div>
                    <input class="flex-grow" type="number" name="sort_order" value="{{ old('sort_order', 0) }}">
                </fieldset>

                <fieldset>
                    <div class="body-title">Status</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox" 
                            name="status" 
                            id="status" 
                            value="1"
                            {{ old('status', 1) ? 'checked' : '' }}
                            class="w-4 h-4" checked>
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
                                <span class="body-text">Drop your image here or select (1903px by 520px)<span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*" required>
                            </label>
                        </div>
                    </div>
                </fieldset>

                @error('image') <span class="alert alert-danger">{{$message}}</span> @enderror

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
        $("#myFile").on("change",function(){
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });
    });
</script>
@endpush