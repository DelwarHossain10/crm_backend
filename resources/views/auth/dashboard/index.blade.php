@extends('auth.layout')
@section('title', 'Attendance')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" />
@endpush

@section('content')
    <admin-dashboard></admin-dashboard>

@endsection

@push('js')

@endpush
