@extends('layouts.admin')
@section('main-content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3> <!-- Changed from "Add Product" -->
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a> <!--  Fixed route -->
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('admin.products') }}"><div class="text-tiny">Products</div></a> <!-- Fixed route -->
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit product</div>
                    </li>
                </ul>
            </div>
            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('admin.product.update')}}" >
                <input type="hidden" name="id" value="{{$product->id}}" />
                @csrf
                @method("PUT")
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="{{$product->name}}" aria-required="true" required="">
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    </fieldset>
                    @error("name") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0" value="{{$product->slug}}" aria-required="true" required="">
                    </fieldset>
                    @error("slug") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select class="" name="category_id">
                                    @foreach ($categories as $category)
                                    <option value="{{$category->id}}" {{$product->category_id == $category->id ? "selected":""}}>{{$category->name}}</option>
                                    @endforeach                                                                 
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    @error("category_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Short Description" tabindex="0" aria-required="true" required="">{{$product->short_description}}</textarea>
                    </fieldset>
                    @error("short_description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    
                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true" required="">{{$product->description}}</textarea>
                    </fieldset>
                    @error("description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>
                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload Feature Image <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            @if($product->image)
                            <div class="item" id="imgpreview">                            
                                <img src="{{asset('backend/uploads/products')}}/{{$product->image}}" class="effect8" alt="">
                            </div>
                            @endif
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
                            @if($product->images)
                                @foreach(explode(",",$product->images) as $img)                               
                                    <div class="item gitems">                            
                                        <img src="{{asset('backend/uploads/products')}}/{{trim($img)}}" class="effect8" alt="">
                                    </div>
                                @endforeach
                            @endif
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

                    <!--  Dynamic Sizes Section (Replaces old price/quantity fields) -->
                    <div class="wg-box mt-20">
                        <div class="body-title mb-10">Product Sizes & Pricing <span class="tf-color-1">*</span></div>
                        <div id="sizes-container">
                            @forelse($product->sizes as $index => $size)
                                <div class="size-row gap22 cols mb-20" data-size-id="{{ $size->id }}">
                                    <fieldset class="name">
                                        <input class="mb-10" type="text" name="sizes[{{ $index }}][size]" value="{{ $size->size }}" placeholder="Size (e.g. 100g)" required>
                                    </fieldset>
                                    <fieldset class="name">
                                        <input class="mb-10" type="number" step="0.01" name="sizes[{{ $index }}][regular_price]" value="{{ $size->regular_price }}" placeholder="Regular Price" required>
                                    </fieldset>
                                    <fieldset class="name">
                                        <input class="mb-10" type="number" step="0.01" name="sizes[{{ $index }}][sale_price]" value="{{ $size->sale_price }}" placeholder="Sale Price" required>
                                    </fieldset>
                                    <fieldset class="name">
                                        <input class="mb-10" type="number" min="0" name="sizes[{{ $index }}][quantity]" value="{{ $size->quantity }}" placeholder="Quantity" required>
                                    </fieldset>
                                    <button type="button" class="tf-button remove-size-btn" {{ $product->sizes->count() == 1 ? 'style=display:none' : '' }}>Remove</button>
                                    <input type="hidden" name="sizes[{{ $index }}][id]" value="{{ $size->id }}">
                                </div>
                            @empty
                                <!-- Fallback: empty first row -->
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
                            @endforelse
                        </div>
                        <button type="button" id="add-size-btn" class="tf-button style-2">+ Add Another Size</button>
                        @error('sizes') <span class="alert alert-danger text-center d-block mt-10">{{$message}}</span> @enderror
                    </div>

                    <!-- Stock & Featured -->
                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU</div>
                            <input class="mb-10" type="text" name="SKU" value="{{$product->SKU}}" required readonly>
                        </fieldset>
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select class="" name="stock_status">
                                    <option value="instock" {{$product->stock_status == "instock" ? "selected":"" }}>InStock</option>
                                    <option value="outofstock" {{$product->stock_status == "outofstock" ? "selected":"" }}>Out of Stock</option>                                                        
                                </select>
                            </div>                                                
                        </fieldset>
                        @error("stock_status") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select class="" name="featured">
                                    <option value="0" {{$product->featured == "0" ? "selected":"" }}>No</option>
                                    <option value="1" {{$product->featured == "1" ? "selected":"" }}>Yes</option>                                                        
                                </select>
                            </div>
                        </fieldset>
                        @error("featured") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Save product</button>                                            
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
                    $("#imgpreview img").attr('src',URL.createObjectURL(file));
                    $("#imgpreview").show();                        
                }
            });

            // Gallery preview (clear new ones, keep existing)
            $("#gFile").on("change",function(e){
                $(".gitems.new").remove(); // Only remove new preview items
                $.each(this.files,function(key,val){                        
                    $("#galUpload").before(`<div class="item gitems new"><img src="${URL.createObjectURL(val)}" alt=""></div>`);                        
                });                    
            });

            // Auto-generate slug from name
            $("input[name='name']").on("input",function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

            // Dynamic Sizes Management
            let sizeIndex = {{ $product->sizes->count() ?? 0 }};

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
            updateRemoveButtons();
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }      
    </script>
@endpush