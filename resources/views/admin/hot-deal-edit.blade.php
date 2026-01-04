@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Hot Deal Product</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.hot.deals') }}"><div class="text-tiny">Hot Deals</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit</div></li>
            </ul>
        </div>

        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.hot.deal.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $item->id }}">

                <fieldset class="category">
                    <div class="body-title mb-10">Select Product <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select name="product_id" required>
                            <option value="">Choose product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ old('product_id', $item->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('product_id') <span class="alert alert-danger d-block mt-2">{{ $message }}</span> @enderror
                </fieldset>

                @if($item->product)
                <fieldset class="name">
                    <div class="body-title">Current Product Preview</div>
                    <div class="p-3 bg-light border rounded d-flex align-items-center gap-3">
                        @if($item->product->image)
                            <img src="{{ asset('backend/uploads/products/' . $item->product->image) }}"
                                 style="max-height:80px; object-fit:cover; border-radius:4px;">
                        @endif
                        <div>
                            <strong>{{ $item->product->name }}</strong><br>
                            <small>Price: {{ $item->product->price ?? 'N/A' }}</small>
                        </div>
                    </div>
                </fieldset>
                @endif

                <fieldset>
                    <div class="body-title">Show HOT Label?</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="show_hot_label" value="1"
                               {{ old('show_hot_label', $item->show_hot_label) ? 'checked' : '' }}
                               class="w-4 h-4">
                        <span class="body-text">Display the red "HOT" badge</span>
                    </label>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Sort Order</div>
                    <input class="flex-grow" type="number" name="sort_order"
                           value="{{ old('sort_order', $item->sort_order) }}" min="0">
                </fieldset>

                <fieldset>
                    <div class="body-title">Status</div>
                    <label class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="status" value="1"
                               {{ old('status', $item->status) ? 'checked' : '' }}
                               class="w-4 h-4">
                        <span class="body-text">Active (show on homepage)</span>
                    </label>
                </fieldset>

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection