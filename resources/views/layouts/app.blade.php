<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Hotel Management System') - Angkor Hotel</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --brand-navy: #0B192C;
            --brand-navy-light: #1E3E62;
            --brand-gold: #D4AF37;
            --brand-gold-hover: #b89726;
            --brand-gold-soft: #fbf5e6;
            --brand-amber: #E0A96D;
            --brand-bg: #F5F7FB;
            --brand-card-border: #E5E9F2;
            --brand-text-dark: #1E293B;
            --brand-text-muted: #64748B;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--brand-bg);
            color: var(--brand-text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .font-luxury {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .hotel-logo-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px;
            border: 2px solid var(--brand-gold);
            border-radius: 50%;
            background: #0B192C;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hotel-logo-wrapper:hover {
            transform: scale(1.04);
            box-shadow: 0 0 14px rgba(212, 175, 55, 0.6);
        }

        .hotel-logo-img {
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }

        /* Top Luxury Navbar */
        .navbar-hotel {
            background: linear-gradient(135deg, #07111E 0%, #0B192C 50%, #152B44 100%);
            border-bottom: 2px solid rgba(212, 175, 55, 0.4);
            box-shadow: 0 4px 20px rgba(7, 17, 30, 0.15);
        }

        .navbar-hotel .navbar-brand {
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.3px;
        }

        .navbar-hotel .brand-gold {
            color: var(--brand-gold);
            text-shadow: 0 0 12px rgba(212, 175, 55, 0.35);
        }

        .navbar-hotel .nav-link {
            color: #CBD5E1;
            font-weight: 500;
            font-size: 0.92rem;
            padding: 0.55rem 0.95rem;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .navbar-hotel .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.08);
        }

        .navbar-hotel .nav-link.active {
            color: #ffffff;
            background-color: rgba(212, 175, 55, 0.18);
            border: 1px solid rgba(212, 175, 55, 0.35);
        }

        /* Custom Cards */
        .card-hotel {
            background: #ffffff;
            border: 1px solid var(--brand-card-border);
            border-radius: 16px;
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        /* Stat Cards */
        .stat-badge-card {
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            background: #ffffff;
            border: 1px solid var(--brand-card-border);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .stat-icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* Gold Button */
        .btn-gold {
            background: linear-gradient(135deg, #E0A96D 0%, #D4AF37 100%);
            border: none;
            color: #07111E;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.25);
            transition: all 0.2s ease;
        }

        .btn-gold:hover {
            background: linear-gradient(135deg, #d39857 0%, #c59b27 100%);
            color: #000000;
            box-shadow: 0 6px 16px rgba(212, 175, 55, 0.35);
            transform: translateY(-1px);
        }

        .btn-navy {
            background-color: var(--brand-navy);
            border: 1px solid var(--brand-navy-light);
            color: #ffffff;
            font-weight: 600;
        }

        .btn-navy:hover {
            background-color: var(--brand-navy-light);
            color: #ffffff;
        }

        /* Status Badges */
        .badge-available {
            background-color: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .badge-occupied {
            background-color: #FEF2F2;
            color: #991B1B;
            border: 1px solid #FECACA;
        }

        .badge-reserved {
            background-color: #FFFBEB;
            color: #92400E;
            border: 1px solid #FDE68A;
        }

        .badge-maintenance {
            background-color: #F1F5F9;
            color: #475569;
            border: 1px solid #CBD5E1;
        }

        /* Form elements */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #CBD5E1;
            padding: 0.6rem 0.9rem;
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand-gold);
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.2);
        }

        /* Custom Table */
        .table-hotel th {
            background-color: #F8FAFC;
            color: #475569;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            border-bottom: 2px solid var(--brand-card-border);
            padding: 0.9rem 1rem;
        }

        .table-hotel td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #F1F5F9;
        }

        .table-hotel tbody tr:hover {
            background-color: #FAFCFE;
        }

        /* Footer */
        footer {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid var(--brand-card-border);
            padding: 1.5rem 0;
            font-size: 0.88rem;
            color: var(--brand-text-muted);
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-hotel sticky-top py-3">
        <div class="container-xl">
            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center gap-2.5" href="{{ route('dashboard') }}">
                <div class="hotel-logo-wrapper">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel Logo" class="hotel-logo-img" style="width: 44px; height: 44px;">
                </div>
                <div>
                    <span class="fw-bold tracking-tight text-white fs-5 font-luxury">ANGKOR HOTEL</span>
                    <span class="brand-gold small d-block fw-semibold" style="font-size: 0.68rem; letter-spacing: 1.5px;">LUXURY HOSPITALITY</span>
                </div>
            </a>

            <!-- Toggle Button for Mobile -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarContent">
                @auth
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard', 'home') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">
                            <i class="bi bi-door-closed me-1"></i> Rooms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('room-types.*', 'room_types.*') ? 'active' : '' }}" href="{{ route('room-types.index') }}">
                            <i class="bi bi-grid-1x2 me-1"></i> Room Types
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reservations.*', 'bookings.*') ? 'active' : '' }}" href="{{ route('reservations.index') }}">
                            <i class="bi bi-calendar-check me-1"></i> Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="bi bi-people me-1"></i> Users
                        </a>
                    </li>
                </ul>

                <!-- User Profile & Logout -->
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-light btn-sm border-white border-opacity-25 rounded-pill px-3 py-1.5 d-flex align-items-center gap-2 dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="badge rounded-circle bg-warning text-dark fw-bold" style="width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.75rem;">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </span>
                            <span class="small fw-semibold text-white">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="userMenu">
                            <li class="px-3 py-2 border-bottom bg-light">
                                <div class="fw-bold small text-dark">{{ Auth::user()->name }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email }}</div>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-dark" href="{{ route('users.index') }}">
                                    <i class="bi bi-people-fill text-primary"></i> Manage Staff Users
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2 py-2 text-dark" href="{{ route('users.create') }}">
                                    <i class="bi bi-person-plus-fill text-warning"></i> Add New User
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2 py-2">
                                        <i class="bi bi-box-arrow-right"></i> Sign Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @else
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-gold btn-sm px-3 rounded-pill" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i> Register Staff
                        </a>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="py-4 flex-grow-1">
        <div class="container-xl">
            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2 mb-1 fw-bold">
                        <i class="bi bi-x-circle-fill"></i> Please fix the following errors:
                    </div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Hotel Footer -->
    <footer>
        <div class="container-xl d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="hotel-logo-wrapper" style="padding: 1px;">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel" class="hotel-logo-img" style="width: 26px; height: 26px;">
                </div>
                <span class="fw-semibold text-dark">Angkor Hotel Management System</span>
                <span class="badge bg-secondary-subtle text-secondary border">Laravel 13 Exam</span>
            </div>
            <div class="text-muted small">
                SETEC Institute &bull; Final Exam Project &bull; Built with Relational Eloquent ORM & MySQL
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
