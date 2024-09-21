@extends('auth.layout')
@section('title', 'Edit Role')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div name="content">
            @include('auth.alert_component')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('roles.update', $role->id) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Role Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter Role Name" required value="{{ $role->name }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="guard_name" class="form-label">Guard Name</label>
                                        <input type="text" name="guard_name" class="form-control" placeholder="Enter Guard Name" required value="{{ $role->guard_name }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="permissions" class="form-label">Permissions</label>
                                        <select name="permissions[]" class="form-control select2" multiple required>
                                            @foreach($permissions as $permission)
                                                <option value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) ? 'selected' : '' }}>{{ $permission->name }}</option>
                                            @endforeach
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
    <script src="{{ asset('js/select2.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
