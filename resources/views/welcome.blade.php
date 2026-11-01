<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Angkor Hotel - Hotel Management System</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #07111E 0%, #0B192C 60%, #152B44 100%);
            min-height: 100vh;
            color: #ffffff;
            display: flex;
            align-items: center;
        }
        .font-luxury { font-family: 'Playfair Display', Georgia, serif; }
        .brand-gold { color: #D4AF37; }
        .hotel-logo-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            border: 3px solid #D4AF37;
            border-radius: 50%;
            background: #0B192C;
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.45);
        }
        .hotel-logo-img {
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }
        .btn-gold {
            background: linear-gradient(135deg, #E0A96D 0%, #D4AF37 100%);
            border: none;
            color: #07111E;
            font-weight: 700;
        }
        .btn-gold:hover {
            background: #c59b27;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="hotel-logo-wrapper mb-4">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Angkor Hotel Logo" class="hotel-logo-img" style="width: 140px; height: 140px;">
                </div>
                <h1 class="display-3 fw-bold font-luxury mb-2 text-white">ANGKOR HOTEL</h1>
                <h4 class="brand-gold tracking-widest text-uppercase mb-4 fw-semibold" style="letter-spacing: 4px;">
                    Luxury Hospitality Management System
                </h4>
                <p class="lead text-light opacity-75 mb-5 mx-auto" style="max-width: 620px;">
                    SETEC Institute &bull; Final Project Exam &bull; Laravel 13 Relational Database System with Migrations, Seeders & CRUD Operations.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-gold btn-lg px-4 rounded-pill">
                            <i class="bi bi-speedometer2 me-1"></i> Open Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-gold btn-lg px-4 rounded-pill">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Staff Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">
                            <i class="bi bi-person-plus me-1"></i> Register New Staff
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</body>
</html>
