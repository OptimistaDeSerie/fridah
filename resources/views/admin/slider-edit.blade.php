@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <!-- main-content-wrap -->
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Slider Information</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}"><div class="text-tiny">Dashboard</div></a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{route('admin.sliders')}}"><div class="text-tiny">Sliders</div></a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Slider</div>
                </li>
            </ul>
        </div>

        <!-- edit-slider -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" 
                  action="{{ route('admin.slider.update') }}" 
                  method="POST" 
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $slider->id }}" />

                <fieldset class="name">
                    <div class="body-title">Title</div>
                    <input class="flex-grow" type="text" name="title" value="{{ old('title', $slider->title) }}">
                </fieldset>
                @error('title') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Subtitle</div>
                    <input class="flex-grow" type="text" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}">
                </fieldset>
                @error('subtitle') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Short Text <small>(e.g. Fresh!, Sugar-Free)</small></div>
                    <input class="flex-grow" type="text" name="short_text" value="{{ old('short_text', $slider->short_text) }}">
                </fieldset>
                @error('short_text') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Description</div>
                    <textarea class="flex-grow" name="description" rows="3">{{ old('description', $slider->description) }}</textarea>
                </fieldset>
                @error('description') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Offer Text <small>(e.g. up to 50%)</small></div>
                    <input class="flex-grow" type="text" name="offer_text" value="{{ old('offer_text', $slider->offer_text) }}">
                </fieldset>
                @error('offer_text') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Text Position</div>
                    <select name="text_position" class="flex-grow">
                        <option value="left" {{ old('text_position', $slider->text_position) == 'left' ? 'selected' : '' }}>Left</option>
                        <option value="right" {{ old('text_position', $slider->text_position) == 'right' ? 'selected' : '' }}>Right</option>
                    </select>
                </fieldset>
                @error('text_position') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Sort Order</div>
                    <input class="flex-grow" type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order) }}">
                </fieldset>
                @error('sort_order') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset>
                    <div class="body-title">Status</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox" 
                            name="status" 
                            id="status" 
                            value="1"
                            {{ old('status', $slider->status) ? 'checked' : '' }}
                            class="w-4 h-4">
                        <span class="body-text">Active (show on frontend)</span>
                    </label>
                </fieldset>

                <fieldset>
                    <div class="body-title">Slider Image</div>
                    <div class="upload-image flex-grow">
                        @if($slider->image)
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('backend/uploads/sliders/' . $slider->image) }}" class="effect8" alt="Current slider image">
                        </div>
                        @else
                        <div class="item" id="imgpreview" style="display:none;">
                            <img src="" class="effect8" alt="">
                        </div>
                        @endif

                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                    <small class="text-muted">Leave empty to keep current image.</small>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
        <!-- /edit-slider -->
    </div>
    <!-- /main-content-wrap -->
</div>
@endsection

@push('scripts')
<script>
    $(function(){
        $("#myFile").on("change", function(e){
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });
    });
</script>
@endpush