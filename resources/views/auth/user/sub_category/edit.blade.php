@extends('auth.layout')
@section('title', 'Edit SubCategory')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div name="content">
            @include('auth.alert_component')
            <div class="row">
                <div class="col-sm-12"></div>
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('/sub_category/' . $subCategory->id) }}" method="post" class="needs-validation" role="form" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-6">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select name="category_id" class="form-control" required>
                                            <option value="" disabled>Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $subCategory->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="service_id" class="form-label">Service</label>
                                        <select name="service_id" class="form-control" required>
                                            <option value="" disabled>Select Service</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}" {{ $subCategory->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="sub_category_name" class="form-label">Sub Category Name</label>
                                        <input type="text" name="sub_category_name" class="form-control" placeholder="Please Enter Sub Category Name Here" required value="{{ $subCategory->sub_category_name }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" placeholder="Please Enter Address Here" value="{{ $subCategory->address }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="phone_no" class="form-label">Phone Number</label>
                                        <input type="text" name="phone_no" class="form-control" placeholder="Please Enter Phone Number Here" value="{{ $subCategory->phone_no }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_path" class="form-label">Image</label>
                                        <input type="file" name="image_path" class="form-control" accept="image/*" />
                                        @if($subCategory->image_path)
                                            <img src="{{ asset('images/'.$subCategory->image_path) }}" alt="Current Image" style="max-width: 200px; margin-top: 10px;">
                                        @endif
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
@endpush
