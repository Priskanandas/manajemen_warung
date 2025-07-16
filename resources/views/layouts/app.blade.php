<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <link rel="shortcut icon" href="{{ asset('dist/img/logo/logo.png') }}" type="image/x-icon">

    {{-- Fonts dan CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('dist/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/ruang-admin.min.css') }}" rel="stylesheet">

    {{-- Theme Styles --}}
    <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
/* Top Bar */
.theme-topbar {
    background-color: #1e1e2f !important;
    border-bottom: 1px solid #2d2f44;
}

body.light-mode .theme-topbar {
    background-color: #f8f9fc !important;
    border-bottom: 1px solid #dee2e6;
}

        /* Dark Mode */
        body.dark-mode .card,
body.dark-mode .card-header,
body.dark-mode .card-body {
    background-color: #1e1e2f !important;
    color: #ffffff !important;
    border: none;
}

body.dark-mode .border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
body.dark-mode .border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
body.dark-mode .border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
body.dark-mode .border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

        body.dark-mode {
            background-color: #1b1c2e;
            color: #e5e5e5;
        }

        body.dark-mode .sidebar {
            background-color: #151627 !important;
        }

        body.dark-mode .sidebar .nav-link,
        body.dark-mode .sidebar .nav-link span,
        body.dark-mode .sidebar .nav-link i {
            color: #f0f0f0 !important;
        }

        body.dark-mode .sidebar .nav-link.active,
        body.dark-mode .sidebar .nav-link:hover {
            background-color: #27293d !important;
            color: #ffffff !important;
        }

        body.dark-mode .card,
        body.dark-mode .card-body,
        body.dark-mode .collapse-inner,
        body.dark-mode .collapse-item {
            background-color: #1e1e2f !important;
            color: #ffffff !important;
        }

        body.dark-mode .container-fluid {
            background-color: #1e1e2f !important;
            color: #ffffff !important;
        }

        body.dark-mode .breadcrumb .breadcrumb-item {
            color: #ccc !important;
        }

        body.dark-mode .bg-topbar {
            background-color: #2a2d48 !important;
        }

        body.dark-mode h1, body.dark-mode h2, body.dark-mode h3, 
        body.dark-mode h4, body.dark-mode h5, body.dark-mode h6 {
            color: #ffffff !important;
        }

        /* Light Mode */
        body.light-mode {
            background-color: #ffffff;
            color: #111111;
        }

        body.light-mode .sidebar {
            background-color: #f8f9fc !important;
        }

        body.light-mode .sidebar .nav-link,
        body.light-mode .sidebar .nav-link span,
        body.light-mode .sidebar .nav-link i {
            color: #000000 !important;
        }

        body.light-mode .sidebar .nav-link.active,
        body.light-mode .sidebar .nav-link:hover {
            background-color: #e0e0e0 !important;
        }

        body.light-mode .card,
        body.light-mode .card-body,
        body.light-mode .collapse-inner,
        body.light-mode .collapse-item {
            background-color: #ffffff !important;
            color: #111111 !important;
        }

        body.light-mode .container-fluid {
            background-color: #f9f9f9 !important;
            color: #000000 !important;
        }

        body.light-mode .bg-topbar {
            background-color: #ffffff !important;
        }

        body.light-mode .breadcrumb .breadcrumb-item {
            color: #666 !important;
        }
    </style>

    {{ $head ?? '' }}
</head>

<body id="page-top">
    <div id="wrapper">
        {{-- Sidebar --}}
        <x-sidebar></x-sidebar>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                {{-- Topbar --}}
                <x-topbar></x-topbar>

                {{-- Main Content --}}
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0">{{ $title ?? 'Dashboard' }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title ?? '' }}</li>
                        </ol>
                    </div>

                    {{ $slot }}

                    {{-- Logout Modal --}}
                    <x-modal-logout />
                </div>
            </div>

            {{-- Footer --}}
            <footer class="sticky-footer mt-3">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>
                            &copy; <script>document.write(new Date().getFullYear());</script> -
                            developed by <b><a href="https://github.com/priskanandas" class="text-decoration-none text-light" target="_blank">priskanandas</a></b>
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    {{-- Scroll Top --}}
    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    {{-- JS --}}
    <script src="{{ asset('dist/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('dist/js/ruang-admin.min.js') }}"></script>
    <script src="{{ asset('dist/vendor/chart.js/Chart.min.js') }}"></script>

    {{-- Theme Toggle --}}
    <script>
        const toggleButton = document.getElementById('themeToggle');
        const body = document.body;

        function applyTheme(theme) {
            body.classList.remove('dark-mode', 'light-mode');
            body.classList.add(theme);
            localStorage.setItem('theme', theme);
        }

        // Load theme saat pertama
        const savedTheme = localStorage.getItem('theme') || 'dark-mode';
        applyTheme(savedTheme);

        toggleButton?.addEventListener('click', () => {
            const currentTheme = body.classList.contains('dark-mode') ? 'dark-mode' : 'light-mode';
            const newTheme = currentTheme === 'dark-mode' ? 'light-mode' : 'dark-mode';
            applyTheme(newTheme);
        });
    </script>

    {{ $script ?? '' }}
</body>
</html>
