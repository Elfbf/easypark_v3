<header id="header" class="header fixed-top d-flex align-items-center">

    {{-- Logo --}}
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <span class="d-none d-lg-block fw-bold">EasyPark</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    {{-- Right Side --}}
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            {{-- User Dropdown --}}
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

                    {{-- Avatar --}}
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" alt="Profile"
                        class="rounded-circle">

                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        {{ auth()->user()->name }}
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                    {{-- User Info --}}
                    <li class="dropdown-header">
                        <h6>{{ auth()->user()->name }}</h6>
                        <span>{{ ucfirst(auth()->user()->role->name ?? 'User') }}</span>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    {{-- Profile (optional) --}}
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    {{-- Logout --}}
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>
            </li>

        </ul>
    </nav>

</header>
