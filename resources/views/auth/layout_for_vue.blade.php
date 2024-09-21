<!DOCTYPE html>
<html class="light-style layout-menu-fixed">

<head>
    @include('auth.header_component')
    @stack('css')
    @vite('resources/css/app.css')
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <div class="layout-page">
                @include('auth.header')
                <div class="content-wrapper">
                    @include('auth.sidebar')

                    <!--begin::Content-->
                    <div class="container-xxl flex-grow-1 container-p-y" id="app">
                    @yield('content')
                    </div>

                    <!--end::Content-->
                </div>
            </div>
        </div>
    </div>
    @include('auth.footer_component')
    @stack('js')
    @if ((new \Jenssegers\Agent\Agent())->isMobile())
    <script>
        $('#layout-menu-toggle').click(function() {
            $('#layout-menu').toggle();
            });
            </script>
    @endif
    @vite('resources/js/app.js')
</body>

</html>
