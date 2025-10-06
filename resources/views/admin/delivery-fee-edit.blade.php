@extends('layouts.admin')
@section('main-content')
    <!-- main-content-wrap -->
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Delivery Fee</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.delivery-fees') }}">
                            <div class="text-tiny">Delivery Fees</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Edit Delivery Fee</div></li>
                </ul>
            </div>

            <!-- form-edit-delivery-fee -->
            <form class="tf-section-2 form-add-product" method="POST" 
                  action="{{ route('admin.delivery-fee.update', ['id' => $fee->id]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $fee->id }}" />
                <div class="wg-box">
                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">State <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="state_id" required>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}" 
                                            {{ $fee->state_id == $state->id ? 'selected' : '' }}>
                                            {{ $state->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>

                        <fieldset class="category">
                            <div class="body-title mb-10">Carrier <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="carrier_id" required>
                                    @foreach ($carriers as $carrier)
                                        <option value="{{ $carrier->id }}" 
                                            {{ $fee->carrier_id == $carrier->id ? 'selected' : '' }}>
                                            {{ $carrier->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>

                        <fieldset class="category">
                            <div class="body-title mb-10">Weight <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="weight_id" required>
                                    @foreach ($weights as $weight)
                                        <option value="{{ $weight->id }}" 
                                            {{ $fee->weight_id == $weight->id ? 'selected' : '' }}>
                                            {{ $weight->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                    </div>

                    <fieldset class="name">
                        <div class="body-title mb-10">Price <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" name="price" placeholder="Enter delivery fee price" 
                               value="{{ $fee->price }}" required>
                        <div class="text-tiny">Enter amount in Naira (₦). Example: 1500.00</div>
                    </fieldset>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Save Delivery Fee</button>
                    </div>
                </div>
            </form>
            <!-- /form-edit-delivery-fee -->
        </div>
        <!-- /main-content-wrap -->
    </div>
    <!-- /main-content-wrap -->
@endsection