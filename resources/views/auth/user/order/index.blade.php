@extends('auth.layout')
@section('title', 'Attendance')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
@endpush

@section('content')

    {{-- <div class="container-xxl flex-grow-1 container-p-y"> --}}
    <div name="content">
        @include('auth.alert_component')

        <div class="row mt-4">
            <div class="col mt-2">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="fw-bold">Order List</h4>
                    </div>
                    <div class="col-md-8 text-end">
                        <li class="pointer publish-post btn btn-primary" data-bs-target="#basicModal" data-backdrop="static"
                            data-keyboard="false" data-bs-toggle="modal">Add New
                        </li>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                {{ generate_table_columns(['Sl','Client Order', 'Sale Order Subject','Lead Name', 'Sale Order Date', 'Client Order Date', 'Order Amount', 'Delivered', 'Action']) }}
            </div>
        </div>

        @include('auth.user.order.create')
        <div class="edit-modal"></div>

    </div>
    {{-- </div> --}}

@endsection

@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script type="text/javascript">
        const columns = ['id', 'sl', 'client_order_id', 'sale_order_subject','lead_name', 'sale_order_date', 'client_order_date', 'ordered_amount', 'delivered'];
        const route = "{{ url('order') }}";
        const order = "asc";
        const button = true;
        const table = 'sale_orders';
        generate_datatable(route, columns, order, button, table);
    </script>
@endpush
