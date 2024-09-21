@extends('auth.layout')
@section('title', 'Edit Attendance')
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
                            <form action="{{ route('attendance.update', $id) }}" method="post" class="needs-validation" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="check_in_latitude" class="form-label">Check-in Latitude</label>
                                        <input type="text" name="check_in_latitude" class="form-control" placeholder="Enter Check-in Latitude" value="{{ $attendance->check_in_latitude ?? null }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="check_in_longitude" class="form-label">Check-in Longitude</label>
                                        <input type="text" name="check_in_longitude" class="form-control" placeholder="Enter Check-in Longitude" value="{{ $attendance->check_in_longitude ?? null }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="check_in_location" class="form-label">Check-in Location</label>
                                        <input type="text" name="check_in_location" class="form-control" placeholder="Enter Check-in Location" value="{{ $attendance->check_in_location ?? null }}" required />
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
@endpush
