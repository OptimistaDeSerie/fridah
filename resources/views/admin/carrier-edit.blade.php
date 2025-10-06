@extends('layouts.admin')
@section('main-content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Carrier</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.carriers') }}">
                            <div class="text-tiny">Carriers</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Edit Carrier</div></li>
                </ul>
            </div>

            <!-- form-edit-carrier -->
            <form class="tf-section-2 form-add-product" method="POST" 
                  action="{{ route('admin.carrier.update', ['id' => $carrier->id]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $carrier->id }}" />
                <div class="wg-box">
                    <div class="gap22 cols">
                        <fieldset class="name">
                            <div class="body-title mb-10">Title <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter Title" name="title" value="{{ $carrier->title }}" required>
                        </fieldset>
                        @error('title') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </div>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Save Carrier</button>
                    </div>
                </div>
            </form>
            <!-- /form-edit-carrier -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection