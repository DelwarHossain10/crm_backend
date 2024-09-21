@extends('auth.layout')
@section('title', 'Tasks')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div name="content">
            @include('auth.alert_component')

            <div class="row mt-4">
                <div class="col mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold">Task List</h4>
                    <li class="pointer publish-post btn btn-primary" data-bs-target="#basicModal" data-backdrop="static"
                        data-keyboard="false" data-bs-toggle="modal">Add New
                    </li>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    {{ generate_table_columns(['Sl', 'Sub Category', 'Name', 'Status', 'Action']) }}
                </div>
            </div>

            @include('auth.user.tasks.create')
            <div class="edit-modal"></div>
            @include('auth.user.business.export')
        </div>
    </div>
    <div class="content-backdrop fade"></div>
@endsection

@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script type="text/javascript">
        const columns = ['id', 'sl', 'sub_category', 'name', 'status'];
        const route = "{{ url('task') }}";
        const order = "asc";
        const button = true;
        const table = 'tasks';
        generate_datatable(route, columns, order, button, table);
    </script>
@endpush
