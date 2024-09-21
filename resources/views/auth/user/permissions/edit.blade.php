@extends('auth.layout')
@section('title', 'Edit Permission')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div name="content">
            @include('auth.alert_component')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('permissions.update', $permission->id) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Permission Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Permission Name" required value="{{ $permission->name }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="guard_name" class="form-label">Guard Name</label>
                                        <input type="text" name="guard_name" class="form-control" placeholder="Enter Guard Name" required value="{{ $permission->guard_name }}" />
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
   
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
