@extends('layouts.admin')
@section('main-content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit User</h3>
            <ul class="breadcrumbs">
                <li><a href="{{ route('admin.index') }}">Dashboard</a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li><a href="{{ route('admin.users') }}">Users</a></li>
                <li><i class="icon-chevron-right"></i></li>
                <li>Edit</li>
            </ul>
        </div>

        <div class="wg-box">
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                @csrf @method('PUT')

                <fieldset class="name mb-4">
                    <div class="body-title mb-2">First Name <span class="tf-color-1">*</span></div>
                    <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}" class="flex-grow" required>
                </fieldset>

                <fieldset class="name mb-4">
                    <div class="body-title mb-2">Last Name <span class="tf-color-1">*</span></div>
                    <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" class="flex-grow" required>
                </fieldset>

                <fieldset class="name mb-4">
                    <div class="body-title mb-2">Email <span class="tf-color-1">*</span></div>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="flex-grow" required>
                </fieldset>

                <fieldset class="name mb-4">
                    <div class="body-title mb-2">Phone</div>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="flex-grow">
                </fieldset>

                <fieldset class="name mb-4">
                    <div class="body-title mb-2">User Type</div>
                    <select name="user_type" class="flex-grow">
                        <option value="user" {{ $user->user_type == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </fieldset>

                <fieldset class="name mb-4">
                    <div class="body-title mb-2">New Password (leave blank to keep current)</div>
                    <input type="password" name="password" class="flex-grow" placeholder="Minimum 8 characters">
                </fieldset>

                <fieldset class="name mb-4">
                    <div class="body-title mb-2">Confirm Password</div>
                    <input type="password" name="password_confirmation" class="flex-grow">
                </fieldset>

                <div class="bot">
                    <a href="{{ route('admin.users') }}" class="tf-button">Back</a>
                    <button type="submit" class="tf-button style-1">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection