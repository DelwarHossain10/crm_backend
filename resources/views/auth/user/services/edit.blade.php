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
            <div class="row">
                <div class="col-sm-12">
                            </div>
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('/service/'.$service->id) }}" method="post" class="needs-validation"
                                role="form" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">
                                   <div class="col-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Service Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Please Enter Service Name Here" required value="{{ $service->name }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="1" {{ $service->status == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $service->status == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_path" class="form-label">Image Upload</label>
                                        <input type="file" name="image_path" class="form-control" accept="image/*">
                                    </div>
                                   
                                    @if($service->image_path)
                                    <div class="mb-3">
                                        <label>Existing Image:</label><br>
                                        <img src="{{ asset('images/'.$service->image_path) }}" alt="Existing Image" style="max-width: 200px;">
                                    </div>
                                    @endif
                                   </div>
                                </div>
                                <div class="row">
                                    <div class="modal-footer justify-content-end">
                                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
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
    <script></script>
@endpush




