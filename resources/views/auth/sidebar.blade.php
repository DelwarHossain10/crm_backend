<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme bold">
    @php
        $route = request()->segments();
    @endphp
    <ul class="menu-inner py-1">
        <!-- User Info -->
        <li class="menu-item first_menu">
            <a href="#" class="d-flex justify-content-between menu-link">
                <div class="d-flex">
                    {{-- Uncomment and adjust the following lines if you want to display the user's avatar --}}
                    {{-- <div>
                        <img src="{{ asset('admin/assets/img/avatars/1.png') }}" class="img-fluid rounded-circle me-2" alt="User Avatar" style="width:40px;height:40px">
                    </div> --}}
                    <div>
                        <h6 class="m-0">{{ auth()->user()->name ?? null }}</h6>
                        {{-- Uncomment and adjust the following line if you want to display the user's designation --}}
                        {{-- <p class="text-info">
                            <small>{{ ucfirst(auth()->user()->designation) }}</small>
                        </p> --}}
                    </div>
                </div>
            </a>
        </li>

        <!-- Dashboard -->
        <li class="menu-item">
            <a href="{{ url('/') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-dashboard"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- System Module Header -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">System Module</span>
        </li>

        <!-- Attendence -->
        <li class="menu-item">
            <a href="{{ url('attendance') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Attendence</div>
            </a>
        </li>

        <!-- Order -->
        <li class="menu-item">
            <a href="{{ url('order') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Order</div>
            </a>
        </li>

        <!-- Prospect -->
        <li class="menu-item">
            <a href="{{ url('prospect') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Prospect</div>
            </a>
        </li>

        <!-- Quotation -->
        <li class="menu-item">
            <a href="{{ url('quotation') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Quotation</div>
            </a>
        </li>

        <!-- Supplier -->
        <li class="menu-item">
            <a href="{{ url('supplier') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Supplier</div>
            </a>
        </li>



        <!-- Lead -->
        <li class="menu-item">
            <a href="{{ url('lead') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Lead</div>
            </a>
        </li>

        <!-- Followup -->
        <li class="menu-item">
            <a href="{{ url('followup') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Followup</div>
            </a>
        </li>



        <!-- SMS -->
        <li class="menu-item">
            <a href="{{ url('sms') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">SMS</div>
            </a>
        </li>

        <!-- Tasks -->
        <li class="menu-item">
            <a href="{{ url('task') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Task</div>
            </a>
        </li>

        <!-- Collection -->
        <li class="menu-item">
            <a href="{{ url('collection') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-business"></i>
                <div data-i18n="Analytics">Collection</div>
            </a>
        </li>


        <!--User Manager-->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">User Manager</span>
        </li>

        <!-- Users -->
        <li class="menu-item">
            <a href="{{ url('users') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Users</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('roles') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Roles</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ url('permissions') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Permissions</div>
            </a>
        </li>
    </ul>
</aside>
