@extends('auth.layout')
@section('title', 'Edit Supplier')
@push('css')

@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div name="content">
            @include('auth.alert_component')
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('/supplier/' . $supplier->id) }}" method="post" class="needs-validation" role="form" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="col-6">
                                        <label for="supplier_name" class="form-label">Supplier Name</label>
                                        <input type="text" name="supplier_name" class="form-control" placeholder="Enter Supplier Name" required value="{{ $supplier->supplier_name }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="supplier_item" class="form-label">Supplier Item</label>
                                        <textarea name="supplier_item" class="form-control" placeholder="Enter Supplier Item">{{ $supplier->supplier_item }}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="supplier_category_id" class="form-label">Category</label>
                                        <input type="text" name="category_name" class="form-control" placeholder="Enter Category" value="{{ $supplier->category_name }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="supplier_reputation_id" class="form-label">Reputation</label>
                                        <input type="text" name="reputation_name" class="form-control" placeholder="Enter Reputation" value="{{ $supplier->reputation_name }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="important_note" class="form-label">Important Note</label>
                                        <textarea name="important_note" class="form-control" placeholder="Enter Important Note">{{ $supplier->important_note }}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="attachment" class="form-label">Attachment</label>
                                        <input type="file" name="attachment" class="form-control" />
                                        @if($supplier->attachment)
                                            <a href="{{ asset('storage/' . $supplier->attachment) }}" target="_blank">View Attachment</a>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea name="address" class="form-control" placeholder="Enter Address">{{ $supplier->address }}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone" value="{{ $supplier->phone }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="zone" class="form-label">Zone</label>
                                        <input type="text" name="zone" class="form-control" placeholder="Enter Zone" value="{{ $supplier->zone }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="fax" class="form-label">Fax</label>
                                        <input type="text" name="fax" class="form-control" placeholder="Enter Fax" value="{{ $supplier->fax }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="text" name="website" class="form-control" placeholder="Enter Website" value="{{ $supplier->website }}" />
                                    </div>
                                    <div class="col-6">
                                        <label for="zip_po" class="form-label">ZIP/PO</label>
                                        <input type="text" name="zip_po" class="form-control" placeholder="Enter ZIP/PO" value="{{ $supplier->zip_po }}" />
                                    </div>
                                    <div class="col-12">
                                        <label for="concern_person" class="form-label">Concern Persons</label>
                                        <div id="concernPersons">
                                            @foreach ($supplier->concerns as $concern)
                                                <div class="concern-person mb-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <input type="text" name="concern_person[]" class="form-control" placeholder="Concern Person" value="{{ $concern->concern_person }}" required />
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" name="mobile[]" class="form-control" placeholder="Mobile" value="{{ $concern->mobile }}" required />
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" name="designation[]" class="form-control" placeholder="Designation" value="{{ $concern->designation }}" />
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="email" name="email_address[]" class="form-control" placeholder="Email Address" value="{{ $concern->email_address }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-secondary" id="addConcernPerson">Add More</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="modal-footer justify-content-end">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script>
        $(document).ready(function() {
            $('#addConcernPerson').click(function() {
                $('#concernPersons').append(`
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
