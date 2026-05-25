<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cafe Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ICON -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #1e293b;
            color: white;
            padding: 20px;
        }

        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #cbd5e1;
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 8px;
            text-decoration: none;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #334155;
            color: white;
        }

        .sidebar a.active {
            background: #3b82f6;
            color: white;
        }

        /* CONTENT */
        .main-content {
            margin-left: 240px;
            padding: 25px;
        }

        /* TOPBAR */
        .topbar {
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card {
            border-radius: 14px;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h4><i class="fa-solid fa-mug-hot"></i> Cafe</h4>

    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line"></i>
        Dashboard
    </a>

    <a href="{{ route('products.index') }}"
       class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
        <i class="fa-solid fa-box"></i>
        Sản phẩm
    </a>

    <a href="{{ route('orders.create') }}"
       class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
        <i class="fa-solid fa-cash-register"></i>
        Bán hàng
    </a>
    <a href="{{ route('revenue.index') }}"
       class="{{ request()->routeIs('revenue.*') ? 'active' : '' }}">
        <i class="fa-solid fa-money-bill-trend-up"></i>
        Doanh thu
    </a>
    <hr>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-right-from-bracket"></i>
        Đăng xuất
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
</div>

<div class="main-content">

    <div class="topbar">
        <strong>Hệ thống quản lý quán cà phê</strong>
        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
    </div>

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>