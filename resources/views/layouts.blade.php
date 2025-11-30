<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Laundry App</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="icon" href="{{ asset('images/logo2.png') }}" type="image/png" sizes="16x16">

    <style>
        :root {
            --primary-blue: #5dade2;
            /* biru muda */
            --accent-yellow: #f7dc6f;
            --light-bg: #f0f8ff;
            /* Alice Blue */
            --text-dark: #1b1b1b;
            --text-gray: #6c757d;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--primary-blue);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar .logo img {
            width: 80px;
            margin-bottom: 10px;
        }

        .sidebar .logo h5 {
            font-size: 16px;
            font-weight: bold;
            color: white;
        }

        .sidebar .nav-link {
            color: white;
            font-size: 15px;
            display: flex;
            align-items: center;
            padding: 10px 12px;
            border-radius: 6px;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--accent-yellow);
            color: var(--text-dark);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .content {
            margin-left: 240px;
            padding: 90px 30px 30px;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 240px;
            right: 0;
            height: 60px;
            background-color: var(--light-bg);
            border-bottom: 2px solid var(--primary-blue);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            z-index: 1000;
        }

        .card {
            border-left: 4px solid var(--primary-blue);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-primary:hover {
            background-color: #3498db;
            border-color: #3498db;
        }

        footer {
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: var(--text-gray);
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo">
            <h5>Batavia Laundry Fresh</h5>
        </div>
        <ul class="nav flex-column">
            @php
                $role = auth()->user()->role_id;
            @endphp

            {{-- Menu untuk Admin --}}
            @if ($role == 1)
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin') }}" class="nav-link {{ request()->is('admin*') ? 'active' : '' }}">
                        <i class="bi bi-bag-fill"></i> List Order
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('customer') }}"
                        class="nav-link {{ request()->is('customers*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> Pelanggan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('reports') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-text-fill"></i> Laporan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('settings') }}"
                        class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="bi bi-gear-fill"></i> Pengaturan
                    </a>
                </li>
            @endif

            {{-- Menu untuk Operator --}}
            @if ($role == 2)
                <li class="nav-item">
                    <a href="{{ route('operator') }}"
                        class="nav-link {{ request()->is('operator*') ? 'active' : '' }}">
                        <i class="bi bi-list-check"></i> Tugas Saya
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('task-history') }}"
                        class="nav-link {{ request()->is('task-history*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> Riwayat Tugas
                    </a>
                </li>

                
            @endif

            @if ($role == 3)
                <li class="nav-item">
                    <a href="{{ route('order') }}" class="nav-link {{ request()->is('order') ? 'active' : '' }}">
                        <i class="bi bi-bag-fill"></i> Pesanan
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('payment') }}" class="nav-link {{ request()->is('payment*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card-fill"></i> Pembayaran
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('customer-support') }}"
                        class="nav-link {{ request()->is('customer-support*') ? 'active' : '' }}">
                        <i class="bi bi-headset"></i> Bantuan Pelanggan
                    </a>
                </li>
            @endif
        </ul>

    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="d-flex align-items-center">
            <h4 class="mb-0">@yield('title')</h4>
        </div>
        <div class="d-flex align-items-center gap-4">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://picsum.photos/id/{{ Auth::user()->id }}/200/300" alt="User"
                        class="rounded-circle me-2" width="40" height="40">
                    <span>{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i>Profil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="px-3">
                            @csrf
                            <button type="submit" class="btn btn-sm text-danger w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2025 Laundry Fresh. All Rights Reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
