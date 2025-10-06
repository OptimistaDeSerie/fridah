@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Add Carrier</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Dashboard</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.carriers') }}"><div class="text-tiny">Carriers</div></a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Add Carrier</div></li>
            </ul>
        </div>
        <form class="tf-section-2 form-add-product" method="POST" action="{{ route('admin.carrier.save') }}">
            @csrf
            <div class="wg-box">
                <fieldset class="name">
                    <div class="body-title mb-10">Title <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter Title" name="title" value="{{ old('title') }}" required>
                </fieldset>
                @error('title') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <div class="cols gap10">
                    <button class="tf-button w-full" type="submit">Add Carrier</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection