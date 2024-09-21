@extends('auth.layout')
@section('title', 'User')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
    <style></style>
@endpush
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div name="content">
            @include('auth.alert_component')
            <div class="row mt-4">
                <div class="col mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold">User List</h4>
                    <li class="pointer publish-post btn btn-primary" data-bs-target="#basicModal" data-backdrop="static"
                        data-keyboard="false" data-bs-toggle="modal">Add New
                    </li>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    {{ generate_table_columns(['ID', 'Full Name', 'Phone Number','Email','Roles','action']) }}
                </div>
            </div>



            @include('auth.user.user_manager.create')
            <div class="edit-modal"></div>
            @include('auth.user.user_manager.export')
        </div>
    </div>
    <div class="content-backdrop fade"></div>
@endsection
@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>


    <script type="text/javascript">
        const columns = ['id','id','full_name', 'phone_number', 'email','roles'];
        const route = "{{ url('users') }}";
        const order = "asc";
        const button = true;
        const table = 'user_manager';
        generate_datatable(route, columns, order, button, table);
    </script>
    <script></script>
@endpush
