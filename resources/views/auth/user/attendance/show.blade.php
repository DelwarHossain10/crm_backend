@extends('auth.layout')
@section('title', 'Show Attendance')
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
                            <form action="{{ route('attendance.update', $attendance->id) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="col-3">

                                        <input type="date" name="from_date" class="form-control" placeholder="From Date"  required />

                                    </div>
                                    <div class="col-3">

                                        <input type="date" name="to_date" class="form-control" placeholder="To Date"  required />

                                    </div>

                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary" style="vertical-align: baseline;">Filter</button>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12"><h3 >Attendance Report</h3></div>
                                <hr>
                            </div>

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
