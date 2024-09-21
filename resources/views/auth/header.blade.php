<div class="container-fluid">
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
        id="layout-navbar">
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0" id="layout-menu-toggle">
                <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                    <i class="bx bx-menu bx-sm"></i>
                </a>
            </div>

            <div class="app-brand demo mx-3">
                <a href="#" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        {{-- <div class="avatar">
                            <img src="{{ asset('admin/assets/img/avatars/aci-group-logo.png') }}" alt="Logo"
                                class="w-px-35 h-auto rounded-circle">
                        </div> --}}
                    </span>
                    <span class="app-brand-text menu-text fw-bolder ms-2">CRM</span>
                </a>
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <ul class="navbar-nav flex-row align-items-center ms-auto">

                <div class="">
                    <a class="btn p-0 ps-0" type="button" id="menudd"
                        href="{{ route('theme.update', ['theme' => session('theme') === 'light' ? 'dark' : 'light']) }}">
                        <i class='bx bx-sm {{ session('theme') === 'light' ? 'bx-moon' : 'bx-sun' }}'></i>
                    </a>
                </div>

                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('admin/assets/img/avatars/1.png') }}" alt="user profile image"
                                style="border-radius:50%">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ url('user/profile') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('admin/assets/img/avatars/1.png') }}"
                                                alt="user profile image" class="w-px-40 h-auto rounded-circle">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        {{-- <span
                                            class="fw-semibold d-block">{{ auth()->guard('user_manager')->user()->name }}</span>
                                        <small class="badge bg-label-success">
                                            {{ ucfirst(auth()->guard('user_manager')->user()->designation) }}
                                        </small> --}}
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>

                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle text-primary">Logout</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>
    </nav>
</div>
