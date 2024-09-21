<meta charset="utf-8" />
<meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<title>CRM - @yield('title')</title>
<meta name="color-scheme" content="dark light">
<meta name="description" content="ACISeed Receive & Delivery admin panel" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ asset('admin/assets/img/icon/favicon.ico') }}" />
<link rel="stylesheet" href="{{ asset('admin/assets/icons/boxicons.css') }}" />
<link rel="stylesheet" href="{{ asset('css/template.css') }}" />
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<style>
    {!! selected_theme() !!} .btn-primary {
        color: #fff;
        background-color: #4169E1 !important;
        border-color: #4169E1 !important;
        box-shadow: 0 0.125rem 0.25rem 0 rgba(140, 105, 255, 0.4);
    }
</style>
