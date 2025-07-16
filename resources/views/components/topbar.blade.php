<nav class="navbar navbar-expand topbar mb-4 static-top theme-topbar">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3 text-white">
        <i class="fa fa-bars"></i>
    </button>
         <!--//<pre class="text-white">{{ json_encode(session()->all(), JSON_PRETTY_PRINT) }}</pre>
-->
                <!-- Warung Aktif -->
        @if (session('nama_warung'))
            <li class="nav-item d-none d-sm-inline-block font-weight-bold text-warning bg-dark p-2 rounded mr-3">
                Warung Aktif: {{ session('nama_warung') }}
            </li>
        @endif

    <ul class="navbar-nav ml-auto align-items-center">
        <!-- Tombol Toggle Theme -->
        <li class="nav-item mr-2">
<button id="themeToggle" class="btn btn-outline-light btn-sm" title="Toggle Tema">
    <i class="fas fa-adjust"></i>
</button>
        </li>




        <!-- Notifikasi / Search / Pesan -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw text-white"></i>
            </a>
            <!-- Dropdown Search -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-1 small" placeholder="Search..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Notifikasi Bell -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw text-white"></i>
                <span class="badge badge-danger badge-counter">3+</span>
            </a>
            <!-- Dropdown Notifikasi -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts Center</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">Today</div>
                        <span class="font-weight-bold">New report available!</span>
                    </div>
                </a>
            </div>
        </li>

        <!-- Profile Dropdown -->
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle"
                    src="{{ asset((auth()->user()->avatar) ? 'storage/'.auth()->user()->avatar : 'dist/img/boy.png') }}"
                    style="max-width: 40px">
                <span class="ml-2 d-none d-lg-inline text-white small">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ route('admin.logs') }}">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
