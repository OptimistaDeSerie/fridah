@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Delivery Fee</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.delivery-fees') }}"><div class="text-tiny">Delivery Fees</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add Delivery Fee</div></li>
            </ul>
        </div>
        <form class="tf-section-2 form-add-product" method="POST" action="{{ route('admin.delivery-fee.save') }}">
            @csrf
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">State <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select name="state_id" required>
                            <option value="">Choose state</option>
                            @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
                @error('state_id') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Carrier <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select name="carrier_id" required>
                            <option value="">Choose carrier</option>
                            @foreach ($carriers as $carrier)
                            <option value="{{ $carrier->id }}">{{ $carrier->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
                @error('carrier_id') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Weight <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select name="weight_id" required>
                            <option value="">Choose weight</option>
                            @foreach ($weights as $weight)
                            <option value="{{ $weight->id }}">{{ $weight->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
                @error('weight_id') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title mb-10">Price <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="number" step="0.01" placeholder="Enter price" name="price" required>
                </fieldset>
                @error('price') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add Delivery Fee</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection