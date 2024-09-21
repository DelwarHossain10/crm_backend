@extends('auth.layout')
@section('title', 'Business')
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
                <div class="col mt-2" style="display:inline-flex;">
                    <h4 class="fw-bold">List</h4>
                    <li class="pointer publish-post" data-bs-target="#basicModal" data-backdrop="static"
                        data-keyboard="false" data-bs-toggle="modal">Add New
                    </li>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    {{ generate_table_columns(['business id', 'business name', 'active', 'action']) }}
                </div>
            </div>



            @include('auth.user.business.create')

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
        const columns = ['id', 'business_id', 'business_name', 'active'];
        const route = "{{ url('user/business') }}";
        const order = "asc";
        const button = true;
        const table = 'business';
        generate_datatable(route, columns, order, button, table);
    </script>
    <script></script>
@endpush
