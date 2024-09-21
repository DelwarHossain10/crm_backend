@extends('auth.layout')
@section('title', 'Edit Order')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div name="content">
            @include('auth.alert_component')
            <div class="row">
                <div class="col-sm-12"></div>
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('/order/' . $order->id) }}" method="post" class="needs-validation" role="form" novalidate enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="client_order_id" class="form-label">Client Order ID</label>
                                        <input type="text" name="client_order_id" class="form-control" value="{{ $order->client_order_id }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="sale_order_subject" class="form-label">Sale Order Subject</label>
                                        <input type="text" name="sale_order_subject" class="form-control" value="{{ $order->sale_order_subject }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="prospect_id" class="form-label">Prospect ID</label>
                                        <input type="text" name="prospect_id" class="form-control" value="{{ $order->prospect_id }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="company_attention_person" class="form-label">Company Attention Person</label>
                                        <input type="text" name="company_attention_person" class="form-control" value="{{ $order->company_attention_person }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $order->phone }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="designation" class="form-label">Designation</label>
                                        <input type="text" name="designation" class="form-control" value="{{ $order->designation }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="order_item" class="form-label">Order Item</label>
                                        <textarea name="order_item" class="form-control" required>{{ $order->order_item }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="key_account_person_id" class="form-label">Key Account Person ID</label>
                                        <input type="text" name="key_account_person_id" class="form-control" value="{{ $order->key_account_person_id }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="sale_order_description" class="form-label">Sale Order Description</label>
                                        <textarea name="sale_order_description" class="form-control">{{ $order->sale_order_description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="attachment" class="form-label">Attachment</label>
                                        <input type="file" name="attachment" class="form-control" />
                                        @if ($order->attachment)
                                            <a href="{{ url('storage/' . $order->attachment) }}" target="_blank">View current attachment</a>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="lead_name" class="form-label">Lead Name</label>
                                        <input type="text" name="lead_name" class="form-control" value="{{ $order->lead_name }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="sale_order_date" class="form-label">Sale Order Date</label>
                                        <input type="date" name="sale_order_date" class="form-control" value="{{ $order->sale_order_date }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="client_order_date" class="form-label">Client Order Date</label>
                                        <input type="date" name="client_order_date" class="form-control" value="{{ $order->client_order_date }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="email_address" class="form-label">Email Address</label>
                                        <input type="email" name="email_address" class="form-control" value="{{ $order->email_address }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="Department" class="form-label">Department</label>
                                        <input type="text" name="Department" class="form-control" value="{{ $order->Department }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="quotation_id" class="form-label">Quotation ID</label>
                                        <input type="text" name="quotation_id" class="form-control" value="{{ $order->quotation_id }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="ordered_amount" class="form-label">Ordered Amount</label>
                                        <input type="text" name="ordered_amount" class="form-control" value="{{ $order->ordered_amount }}" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="delivered" class="form-label">Delivered</label>
                                        <select name="delivered" class="form-control">
                                            <option value="0" {{ $order->delivered == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $order->delivered == 1 ? 'selected' : '' }}>Yes</option>
                                        </select>
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
