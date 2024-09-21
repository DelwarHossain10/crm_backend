@extends('auth.layout')
@section('title', 'Profile')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}">
    <style></style>
@endpush
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div name="content">
            @include('auth.alert_component')
            <h4 class="fw-bold py-3 mb-4">Profile</h4>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                @if (auth()->guard('user_manager')->user()->image)
                                    <img src="{{ storage_asset_path(auth()->guard('user_manager')->user()->image?->image) }}"
                                        alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img"
                                        style="width: 150px; height:150px; border-radius:50%; margin-top:25px;">
                                @else
                                    <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="user image"
                                        class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img"
                                        style="width: 150px; height:150px; border-radius:50%; margin-top:25px;">
                                @endif
                            </div>
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4>{{ auth()->guard('user_manager')->user()->name }}</h4>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item fw-semibold">
                                                <i class="bx bx-pen"></i>
                                                <small class="text-muted">
                                                    {{ auth()->guard('user_manager')->user()->designation }}
                                                </small>
                                            </li>
                                            <li class="list-inline-item fw-semibold">
                                                <i class="bx bx-calendar-alt"></i> Joined
                                                {{ auth()->guard('user_manager')->user()->created_at->toFormattedDateString() }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-5">
                    <div class="card mb-4">
                        <div class="card-body">
                            <small class="text-muted text-uppercase">About</small>
                            <ul class="list-unstyled mb-4 mt-3">
                                <li class="d-flex align-items-center mb-3"><i class="bx bx-user"></i><span
                                        class="fw-semibold mx-2">Full Name:</span>
                                    <span>{{ auth()->guard('user_manager')->user()->name }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-3">
                                    <i class=" bx bxs-id-card"></i>
                                    <span class="fw-semibold mx-2">User ID:</span>
                                    <span>{{ auth()->guard('user_manager')->user()->user_id }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-3"><i class="bx bx-pen"></i><span
                                        class="fw-semibold mx-2">Designation:</span> <span>
                                        <small class="text-muted">
                                            {{ auth()->guard('user_manager')->user()->designation }}
                                        </small>
                                    </span>
                                </li>
                                <li class="d-flex align-items-center mb-3"><i class="bx bx-check"></i><span
                                        class="fw-semibold mx-2">Status:</span> <span>
                                        @if (auth()->guard('user_manager')->user()->active == 'Y')
                                            <span class='badge bg-label-success'>Active</span>
                                        @else
                                            <span class='badge bg-label-secondary'>Inactive</span>
                                        @endif
                                    </span>
                                </li>

                            </ul>
                            <small class="text-muted text-uppercase">Contacts</small>
                            <ul class="list-unstyled mb-4 mt-3">
                                <li class="d-flex align-items-center mb-3"><i class="bx bx-phone"></i><span
                                        class="fw-semibold mx-2">Contact:</span>
                                    <span>{{ auth()->guard('user_manager')->user()->mobile }}</span>
                                </li>
                                <li class="d-flex align-items-center mb-3"><i class="bx bx-envelope"></i><span
                                        class="fw-semibold mx-2">Email:</span>
                                    <span>{{ auth()->guard('user_manager')->user()->email }}</span>
                                </li>
                            </ul>
                            <small class="text-muted text-uppercase">Join Info</small>
                            <ul class="list-unstyled mt-3 mb-0">
                                <li class="d-flex align-items-center mb-3"><i
                                        class="bx bx-window-open text-primary me-2"></i>
                                    <div class="d-flex flex-wrap"><span
                                            class="fw-semibold me-2">Joined</span><span>{{ \Carbon\Carbon::parse(auth()->guard('user_manager')->user()->created_at)->toDayDateTimeString() }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7">
                    <div class="card">
                        <div class="card-body align-items-center">
                            <form id="formAccountSettings" method="POST"
                                action="{{ url('user/profile/' .auth()->guard('user_manager')->user()->id) }}"
                                enctype="multipart/form-data" class="needs-validation" role="form" novalidate>
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name"
                                            value="{{ auth()->guard('user_manager')->user()->name }}" class="form-control"
                                            required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="user_id" class="form-label">User Id</label>
                                        <input type="text" name="user_id"
                                            value="{{ auth()->guard('user_manager')->user()->user_id }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input class="form-control" type="email" id="email" name="email"
                                            value="{{ auth()->guard('user_manager')->user()->email }}" required disabled>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="phoneNumber">Mobile</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ auth()->guard('user_manager')->user()->mobile }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="designation" class="form-label">Designation</label><br />
                                        <input type="text" class="form-control" id="designation" name="designation"
                                            value="{{ auth()->guard('user_manager')->user()->designation }}">
                                    </div>
                                    <div class="mb-3 col-md-6">

                                        <div class="col mb-3">
                                            <label for="active" class="form-label">Active</label>
                                            <span class="bg-red"> *</span>
                                            <select name="active" class="form-control" required>
                                                <option value="Y"
                                                    {{ auth()->guard('user_manager')->user()->active == 'Y'? 'selected': '' }}>
                                                    Yes
                                                </option>
                                                <option value="N"
                                                    {{ auth()->guard('user_manager')->user()->active == 'N'? 'selected': '' }}>
                                                    No
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="publish-post me-2">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="content-backdrop fade"></div>
@endsection
@push('js')
@endpush
