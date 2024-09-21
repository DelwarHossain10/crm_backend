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
                        <h4 class="fw-bold">Attendance List</h4>
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
                {{ generate_table_columns(['Sl','User Id','User Name' ,'Check In Latitude', 'Check In Longitude', 'Check In Location', 'Action']) }}
            </div>
        </div>

        @include('auth.user.attendance.create')
        <div class="edit-modal"></div>

    </div>
    {{-- </div> --}}

@endsection

@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script type="text/javascript">
        const columns = ['id', 'sl', 'id','full_name','check_in_latitude', 'check_in_longitude', 'check_in_location'];
        const route = "{{ url('attendance') }}";
        const order = "asc";
        const button = true;
        const table = 'attendances';
        generate_datatable(route, columns, order, button, table);

        $('#filter_date_range').click(function() {
            let start_date = $('#start_date').val();
            let end_date = $('#end_date').val();

            if (start_date && end_date) {

                fetchAttendances(start_date, end_date);


            } else {
                alert('Please select both start and end date.');
            }
        });
    </script>
@endpush
