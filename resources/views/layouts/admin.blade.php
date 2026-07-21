<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply Chain Risk - @yield('title', 'Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f1f3f6;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            width: 170px;
            height: 100vh;
            background: #7A1F1F;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
        }

        .logo {
            text-align: center;
            padding: 18px 10px;
            font-size: 18px;
            font-weight: bold;
            line-height: 28px;
            border-bottom: 1px solid rgba(255, 255, 255, .15);
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 16px;
            font-size: 13px;
            transition: .3s;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            background: #611818;
        }

        .sidebar a.active {
            background: #611818;
            border-left: 4px solid #f6e52c;
            font-weight: bold;
        }

        .logout-btn {
            width: 100%;
            background: none;
            border: none;
            color: white;
            text-align: left;
            padding: 12px 16px;
            font-size: 13px;
            cursor: pointer;
            transition: .3s;
        }

        .logout-btn:hover {
            background: #611818;
        }

        /* ================= CONTENT ================= */
        .content {
            margin-left: 170px;
            padding: 18px;
        }

        .topbar {
            background: #fff;
            border-radius: 10px;
            padding: 14px 22px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
        }

        .topbar h5 {
            margin: 0;
            font-size: 17px;
            font-weight: 600;
        }

        .topbar span {
            font-size: 15px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .dashboard-card {
            width: 175px;
            height: 95px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .card-top {
            height: 4px;
            background: #7A1F1F;
        }

        .modal-content {
            border: none;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <div class="logo">
        Supply Chain<br>
        Risk
    </div>

    <a href="{{ url('/admin/dashboard') }}"
       class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
        Dashboard
    </a>

    <a href="{{ route('users.index') }}"
       class="{{ request()->is('users*') ? 'active' : '' }}">
        Kelola User
    </a>

    <a href="{{ route('ports.index') }}"
       class="{{ request()->is('ports*') ? 'active' : '' }}">
        Dataset Pelabuhan
    </a>

    {{-- Perubahan link Artikel Analisis di sini --}}
    <a href="{{ route('articles.index') }}"
       class="{{ request()->is('articles*') ? 'active' : '' }}">
        Artikel Analisis
    </a>

    <button
        type="button"
        class="logout-btn"
        data-bs-toggle="modal"
        data-bs-target="#logoutModal">
        Logout
    </button>
</div>

<div class="content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h5>Dashboard Admin</h5>
        <span>{{ Auth::user()->role ?? 'Admin' }}</span>
    </div>

    @yield('content')
</div>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Apakah Anda yakin ingin logout?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn text-white" style="background:#7A1F1F">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>