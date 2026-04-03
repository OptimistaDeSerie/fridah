@extends('layouts.admin')
@section('main-content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="all-product.html"><div class="text-tiny">Products</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.save')}}" >
                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="{{ old('name') }}" aria-required="true">
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    </fieldset>
                    @error("name") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0" value="{{ old('slug') }}" aria-required="true">
                    </fieldset>
                    @error("slug") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="category_id">
                                    <option value="">Choose category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                    @endforeach                                                                 
                                </select>
                            </div>
                        </fieldset>
                        @error("category_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>
                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true" maxlength="255">{{ old('short_description') }}</textarea>
                    </fieldset>
                    @error("short_description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true">{{ old('description') }}</textarea>
                    </fieldset>
                    @error("description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <!-- Images & Gallery -->
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload Feature Image <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">                            
                                <img src="{{asset('images/upload/upload-1.png')}}" class="effect8" alt="">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset> 
                    @error("image") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">                            
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>                        
                    </fieldset>
                    @error("images") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <!-- Dynamic Sizes Section (Replaces old price/quantity) -->
                    <div class="wg-box mt-20">
                        <div class="body-title mb-10">Product Sizes & Pricing <span class="tf-color-1">*</span></div>
                        <div id="sizes-container">
                            <!-- First row (always visible) -->
                            <div class="size-row gap22 cols mb-20">
                                <fieldset class="name">
                                    <input class="mb-10" type="text" name="sizes[0][size]" placeholder="Size (e.g. 100g)" required>
                                </fieldset>
                                <fieldset class="name">
                                    <input class="mb-10" type="number" step="0.01" name="sizes[0][regular_price]" placeholder="Regular Price" required>
                                </fieldset>
                                <fieldset class="name">
                                    <input class="mb-10" type="number" step="0.01" name="sizes[0][sale_price]" placeholder="Sale Price" required>
                                </fieldset>
                                <fieldset class="name">
                                    <input class="mb-10" type="number" min="0" name="sizes[0][quantity]" placeholder="Quantity" required>
                                </fieldset>
                                <button type="button" class="tf-button remove-size-btn" style="display:none;">Remove</button>
                            </div>
                        </div>

                        <button type="button" id="add-size-btn" class="tf-button style-2">+ Add Another Size</button>
                        @error('sizes') <span class="alert alert-danger text-center d-block mt-10">{{$message}}</span> @enderror
                        @error('sizes.*') <span class="alert alert-danger text-center d-block mt-10">{{$message}}</span> @enderror
                    </div>

                    <!-- Stock & Featured -->
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock">InStock</option>
                                    <option value="outofstock">Out of Stock</option>                                                        
                                </select>
                            </div>                                                
                        </fieldset>
                        @error("stock_status") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>                                                        
                                </select>
                            </div>
                        </fieldset>
                        @error("featured") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Add product</button>                                            
                    </div>
                </div>
            </form>
            <!-- /form-add-product -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection

@push("scripts")
    <script>
        $(function(){
            // Main image preview
            $("#myFile").on("change",function(e){
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file));
                    $("#imgpreview").show();                        
                }
            });

            // Gallery preview
            $("#gFile").on("change",function(e){
                $(".gitems").remove();
                $.each(this.files, function(key, val){                        
                    $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt=""></div>`);                        
                });                    
            });

            // Auto-generate slug from name
            $("input[name='name']").on("input", function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

            // Dynamic Sizes Management
            let sizeIndex = 1;

            $("#add-size-btn").on("click", function() {
                let newRow = `
                    <div class="size-row gap22 cols mb-20">
                        <fieldset class="name">
                            <input class="mb-10" type="text" name="sizes[${sizeIndex}][size]" placeholder="Size (e.g. 300g)" required>
                        </fieldset>
                        <fieldset class="name">
                            <input class="mb-10" type="number" step="0.01" name="sizes[${sizeIndex}][regular_price]" placeholder="Regular Price" required>
                        </fieldset>
                        <fieldset class="name">
                            <input class="mb-10" type="number" step="0.01" name="sizes[${sizeIndex}][sale_price]" placeholder="Sale Price" required>
                        </fieldset>
                        <fieldset class="name">
                            <input class="mb-10" type="number" min="0" name="sizes[${sizeIndex}][quantity]" placeholder="Quantity" required>
                        </fieldset>
                        <button type="button" class="tf-button remove-size-btn">Remove</button>
                    </div>`;
                $("#sizes-container").append(newRow);
                sizeIndex++;
                updateRemoveButtons();
            });

            // Remove size row
            $(document).on("click", ".remove-size-btn", function() {
                $(this).closest(".size-row").remove();
                updateRemoveButtons();
            });

            function updateRemoveButtons() {
                if ($(".size-row").length === 1) {
                    $(".remove-size-btn").hide();
                } else {
                    $(".remove-size-btn").show();
                }
            }
            updateRemoveButtons(); // Initial state
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }      
    </script>
@endpush