@extends('auth.layout')
@section('title', 'Supplier')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
@endpush

@section('content')

        <div name="content">
            @include('auth.alert_component')

            <div class="row mt-4">
                <div class="col mt-2 d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold">Supplier List</h4>
                    <li class="pointer publish-post btn btn-primary" data-bs-target="#basicModal" data-backdrop="static"
                        data-keyboard="false" data-bs-toggle="modal">Add New
                    </li>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    {{ generate_table_columns(['Sl', 'Supplier Name','Supplier Item','Category','Reputation','Important Note','Phone','Action']) }}
                </div>
            </div>

            @include('auth.user.supplier.create')
            <div class="edit-modal"></div>

        </div>

@endsection

@push('js')
    <script src="{{ asset('js/datatable.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script type="text/javascript">
        const columns = ['id','sl','supplier_name','supplier_item','category_name','reputation_name','important_note','phone'];
        const route = "{{ url('supplier') }}";
        const order = "asc";
        const button = true;
        const table = 'suppliers';
        generate_datatable(route, columns, order, button, table);
    </script>
      <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#addConcernPersonForCreate').click(function() {
                $('#concernPersonsForCreate').append(`
                    <div class="concern-person mb-2">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="concern_person[]" class="form-control" placeholder="Concern Person" required />
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="mobile[]" class="form-control" placeholder="Mobile" required />
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="designation[]" class="form-control" placeholder="Designation" />
                            </div>
                            <div class="col-md-3">
                                <input type="email" name="email_address[]" class="form-control" placeholder="Email Address" />
                            </div>
                        </div>
                    </div>
                `);
            });
        });
    </script>
@endpush

