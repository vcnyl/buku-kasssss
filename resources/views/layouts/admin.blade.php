<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Buku Kas Kecil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                    
                    <!-- Transaksi Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="transaksiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Transaksi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="transaksiDropdown">
                            <li><a class="dropdown-item" href="{{ url('admin/penerimaan') }}">Penerimaan</a></li>
                            <li><a class="dropdown-item" href="{{ url('admin/pengeluaran') }}">Pengeluaran</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/laporan') }}">Laporan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('admin/profile') }}">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/logout') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
