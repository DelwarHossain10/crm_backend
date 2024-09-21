@extends('auth.layout')
@section('title', 'Edit User')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}" /> <!-- Include select2 CSS if using select2 -->
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
                            <form action="{{ url('/users/' . $user->id) }}" method="post" class="needs-validation" role="form" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="full_name" class="form-label">Full Name</label>
                                        <input type="text" name="full_name" class="form-control" placeholder="Enter Full Name" required value="{{ $user->full_name }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone Number" required value="{{ $user->phone_number }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required value="{{ $user->email }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="state_name" class="form-label">State</label>
                                        <input type="text" name="state_name" class="form-control" placeholder="Enter State Name" value="{{ $user->state_name }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="address" class="form-control" placeholder="Enter Address">{{ $user->address }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="roles" class="form-label">Roles</label>
                                        <select name="roles[]" class="form-control select2" multiple="multiple" required>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ in_array($role->id, $user->roles->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
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
    <script src="{{ asset('js/select2.js') }}"></script> <!-- Include select2 JS if using select2 -->
    <script>
        $(document).ready(function() {
            $('.select2').select2(); // Initialize select2 for roles multi-select
        });
    </script>
@endpush
