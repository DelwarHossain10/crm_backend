@extends('auth.layout')
@section('title', 'Category')

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
                    <h4 class="fw-bold">Category List</h4>
                    <li class="pointer publish-post btn btn-primary" data-bs-target="#basicModal" data-backdrop="static"
                        data-keyboard="false" data-bs-toggle="modal">Add New
                    </li>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    {{ generate_table_columns(['Sl', 'Service', 'Date', 'Name','Phone No', 'Image Path','Assign By','Work Status','Action']) }}
                </div>
            </div>

            @include('auth.user.category.create')
            <div class="edit-modal"></div>

        </div>
    </div>
    <div class="content-backdrop fade"></div>
@endsection

@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script type="text/javascript">
        const columns = ['id','sl','service_name', 'date', 'category_name', 'phone_no', 'image_path','assign_by','work_status'];
        const route = "{{ url('category') }}";
        const order = "asc";
        const button = true;
        const table = 'categories';
        generate_datatable(route, columns, order, button, table);
    </script>
@endpush
