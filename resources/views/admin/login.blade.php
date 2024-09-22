<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-template="vertical-menu-template-free">

<head>
    @section('title', 'Login')
    @include('auth.header_component')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        @include('auth.alert_component')
                            <form class="login-action-area" id="" action="{{ route('login-user') }}" method="POST">
                                @csrf
                            @csrf
                            <div class="app-brand justify-content-center">
                                <a href="/login" class="app-brand-link">
                                    <span class="app-brand-text text-body fw-bolder">CRM</span>
                                </a>
                            </div>
                            <h3 class="mb-2 app-brand-text text-body fw-bolder text-center">Welcome to CRM</h3>
                            <p class="mb-4 text-center">Please Login to start your journey</p>
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email" required value="{{ old('email') }}"
                                    autocomplete="off">
                            </div>

                            <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    {{-- <a href="#">
                                        <small>Forgot Password?</small>
                                    </a> --}}
                                </div>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="password" id="password" class="form-control" name="password"
                                        autocomplete="off" placeholder="Enter your Password" aria-describedby="password"
                                        required value="{{ old('password') }}">
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>

                            </div>

                            {{-- <div class="divider my-4">
                                <div class="divider-text">or</div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                                    <i class="tf-icons bx bxl-facebook"></i>
                                </a>

                                <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                                    <i class="tf-icons bx bxl-google-plus"></i>
                                </a>

                                <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                                    <i class="tf-icons bx bxl-twitter"></i>
                                </a>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('auth.footer_component')
</body>

</html>
