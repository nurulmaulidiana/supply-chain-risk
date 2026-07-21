<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply Chain Risk</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body {
            margin: 0;
            background: #f1f3f6;
            font-family: Arial, Helvetica, sans-serif;
        }

        .sidebar {
            width: 200px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #7A1F1F;
            color: white;
        }

        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,.15);
        }

        .logo h3 {
            margin: 0;
            font-weight: bold;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 11px 16px;
            font-size: 13px;
            border-left: 4px solid transparent;
            transition: .3s;
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
            border: none;
            background: none;
            color: white;
            text-align: left;
            padding: 14px 18px;
        }

        .logout-btn:hover {
            background: #611818;
        }

        .content {
            margin-left: 200px;
            padding: 20px;
        }

        .topbar {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            margin-bottom: 20px;
        }
    </style>

</head>

<body>

<div class="sidebar">

    <div class="logo">
        <h3>Supply Chain Risk</h3>
    </div>

    <a href="{{ route('user.country') }}"
        class="{{ request()->is('user/country') ? 'active' : '' }}">
        🌍 Global Country Dashboard
    </a>

    <a href="{{ route('user.risk-scoring') }}"
        class="{{ request()->is('user/risk-scoring') ? 'active' : '' }}">
        📊 Risk Scoring Engine
    </a>

    <a href="{{ route('user.weather') }}"
        class="{{ request()->is('user/weather') ? 'active' : '' }}">
        ⛅ Weather Monitor
    </a>

    <a href="{{ route('user.currency') }}"
        class="{{ request()->is('user/currency') ? 'active' : '' }}">
        💱 Currency Impact
    </a>

    <a href="{{ route('user.news') }}"
        class="{{ request()->is('user/news') ? 'active' : '' }}">
        📰 News Intelligence
    </a>

    <a href="{{ route('user.port') }}"
        class="{{ request()->is('user/port-location') ? 'active' : '' }}">
        ⚓ Port Location
    </a>

    <a href="{{ route('user.visualization') }}"
        class="{{ request()->is('user/visualization') ? 'active' : '' }}">
        📈 Data Visualization
    </a>

    <a href="{{ route('user.comparison') }}"
        class="{{ request()->is('user/comparison') ? 'active' : '' }}">
        ⚖️ Country Comparison
    </a>

    <a href="{{ route('user.watchlist') }}"
        class="{{ request()->is('user/watchlist') ? 'active' : '' }}">
        ⭐ Watchlist
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout-btn">
            Logout
        </button>
    </form>

</div>

<div class="content">

    <div class="topbar d-flex justify-content-between">

        <h5 class="mb-0">

            @if(request()->is('user/country'))
                🌍 Global Country Dashboard

            @elseif(request()->is('user/risk-scoring'))
                📊 Risk Scoring Engine

            @elseif(request()->is('user/weather'))
                ⛅ Weather Monitor

            @elseif(request()->is('user/currency'))
                💱 Currency Impact

            @elseif(request()->is('user/news'))
                📰 News Intelligence

            @elseif(request()->is('user/port-location'))
                ⚓ Port Location

            @elseif(request()->is('user/visualization'))
                📈 Data Visualization

            @elseif(request()->is('user/comparison'))
                ⚖️ Country Comparison

            @elseif(request()->is('user/watchlist'))
                ⭐ Watchlist

            @else
                Supply Chain Risk
            @endif

        </h5>

        <strong>{{ Auth::user()->name }}</strong>

    </div>

    @yield('content')

</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- Leaflet -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script dari masing-masing halaman -->
@stack('scripts')

</body>
</html>