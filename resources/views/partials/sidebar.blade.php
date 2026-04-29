<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- DASHBOARD --}}
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">

                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>


        {{-- ========================= --}}
        {{-- ADMIN MENU --}}
        {{-- ========================= --}}
        @if (auth()->user()->role->name === 'admin')
            {{-- DATA MASTER --}}
            <li class="nav-item">

                <a class="nav-link {{ request()->is('admin/*') ? '' : 'collapsed' }}" data-bs-target="#master-nav"
                    data-bs-toggle="collapse" href="#">

                    <i class="bi bi-database"></i>
                    <span>Data Master</span>

                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <ul id="master-nav" class="nav-content collapse {{ request()->is('admin/*') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">

                    {{-- ROLE --}}
                    <li>
                        <a href="{{ route('admin.roles.index') }}"
                            class="{{ request()->is('admin/roles*') ? 'active' : '' }}">

                            <i class="bi bi-circle"></i>
                            <span>Role</span>
                        </a>
                    </li>

                    {{-- USER --}}
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i>
                            <span>User</span>
                        </a>
                    </li>

                    {{-- JURUSAN --}}
                    <li>
                        <a href="{{ route('admin.departments.index') }}"
                            class="{{ request()->is('admin/departments*') ? 'active' : '' }}">

                            <i class="bi bi-circle"></i>
                            <span>Jurusan</span>
                        </a>
                    </li>

                    {{-- PRODI --}}
                    <li>
                        <a href="{{ route('admin.study-programs.index') }}"
                            class="{{ request()->is('admin/study-programs*') ? 'active' : '' }}">

                            <i class="bi bi-circle"></i>
                            <span>Program Studi</span>
                        </a>
                    </li>

                    {{-- TIPE KENDARAAN --}}
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i>
                            <span>Tipe Kendaraan</span>
                        </a>
                    </li>

                    {{-- MODEL KENDARAAN --}}
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i>
                            <span>Model Kendaraan</span>
                        </a>
                    </li>

                    {{-- MEREK KENDARAAN --}}
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i>
                            <span>Merek Kendaraan</span>
                        </a>
                    </li>

                    {{-- KENDARAAN --}}
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i>
                            <span>Kendaraan</span>
                        </a>
                    </li>

                </ul>
            </li>
        @endif

    </ul>

</aside>
