<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bank Sampah Diansati</title>

    <!-- Bootstrap CSS -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/additional.css') }}">

    <style>
        body {
            background: linear-gradient(to right, #cbe6ff, #ffffff);
            min-height: 100vh;
        }
    </style>
</head>
<body class="d-flex flex-column justify-content-center align-items-center">

    <div class="container py-5">
        <div class="row align-items-center justify-content-between">
            <!-- Kiri: Judul -->
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <h1 class="fw-bold text-primary"> <i class="fas fa-fw fa-trash fst-italic"></i> Bank Sampah Diansati</h1>
                <p class="text-muted">Selamat datang di sistem informasi penimbangan sampah</p>
            </div>

            <!-- Kanan: Login/Register -->
            <div class="col-md-6 text-center text-md-end">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-lg btn-outline-dark me-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-lg btn-outline-primary me-2">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-lg btn-primary">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>

</body>
</html>
