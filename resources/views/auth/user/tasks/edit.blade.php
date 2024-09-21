

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
                            <form action="{{ url('/task/' . $task->id) }}" method="post" class="needs-validation" role="form" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="subcategory_id" class="form-label">Subcategory</label>
                                        <select name="subcategory_id" class="form-control" required>
                                            <option value="" disabled>Select Subcategory</option>
                                            <!-- Populate options dynamically from database or other source -->
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}" {{ $task->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->sub_category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Task Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Please Enter Task Name Here" required value="{{ $task->name }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="1" {{ $task->status == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $task->status == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
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

