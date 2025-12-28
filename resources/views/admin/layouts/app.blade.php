<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - FandhFood</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <style>
        :root {
            --admin-primary: #ff7e20;
            --admin-primary-dark: #e86a0a;
            --admin-bg: #f5f7fa;
            --admin-sidebar: #1e293b;
            --admin-sidebar-hover: #334155;
            --admin-card: #ffffff;
            --admin-text: #1e293b;
            --admin-text-light: #64748b;
            --admin-border: #e2e8f0;
            --admin-success: #10b981;
            --admin-warning: #f59e0b;
            --admin-danger: #ef4444;
            --admin-info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background: var(--admin-bg);
            color: var(--admin-text);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        body.dark-mode {
            --admin-bg: #0f172a;
            --admin-sidebar: #0f172a;
            --admin-sidebar-hover: #1e293b;
            --admin-card: #1e293b;
            --admin-text: #f1f5f9;
            --admin-text-light: #94a3b8;
            --admin-border: #334155;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: var(--admin-sidebar);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--admin-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-logo span {
            font-size: 0.9rem;
            background: var(--admin-primary);
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .sidebar-nav {
            padding: 20px 15px;
        }

        .nav-section {
            margin-bottom: 25px;
        }

        .nav-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #64748b;
            padding: 0 15px;
            margin-bottom: 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .nav-link:hover {
            background: var(--admin-sidebar-hover);
            color: white;
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
            color: white;
        }

        .nav-link i {
            font-size: 1.3rem;
            width: 25px;
        }

        .nav-link .badge {
            margin-left: auto;
            background: var(--admin-primary);
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.75rem;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            min-height: 100vh;
        }

        .admin-header {
            background: var(--admin-card);
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--admin-border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-title h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--admin-text);
        }

        .header-title p {
            font-size: 0.9rem;
            color: var(--admin-text-light);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-btn {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: var(--admin-bg);
            border: 1px solid var(--admin-border);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--admin-text);
            transition: all 0.3s ease;
        }

        .header-btn:hover {
            background: var(--admin-primary);
            color: white;
            border-color: var(--admin-primary);
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 15px 8px 8px;
            background: var(--admin-bg);
            border-radius: 12px;
        }

        .header-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .header-user-info {
            display: flex;
            flex-direction: column;
        }

        .header-user-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .header-user-role {
            font-size: 0.8rem;
            color: var(--admin-text-light);
        }

        /* Content Area */
        .admin-content {
            padding: 30px;
        }

        /* Cards */
        .admin-card {
            background: var(--admin-card);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid var(--admin-border);
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--admin-card);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .stat-icon.primary {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
        }

        .stat-icon.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .stat-icon.info {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .stat-icon.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-info p {
            font-size: 0.9rem;
            color: var(--admin-text-light);
        }

        /* Tables */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th,
        .admin-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-table th {
            font-weight: 600;
            color: var(--admin-text-light);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-table tbody tr:hover {
            background: var(--admin-bg);
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-preparing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-on_way {
            background: #d1fae5;
            color: #065f46;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-family: 'Quicksand', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            border: none;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 126, 32, 0.4);
        }

        .btn-secondary {
            background: var(--admin-bg);
            color: var(--admin-text);
            border: 1px solid var(--admin-border);
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .btn-danger {
            background: var(--admin-danger);
            color: white;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--admin-text);
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--admin-border);
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Quicksand', sans-serif;
            background: var(--admin-card);
            color: var(--admin-text);
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 4px rgba(255, 126, 32, 0.1);
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-main {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @stack('styles')
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    FandhFood <span>Admin</span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Ana Menü</div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="las la-home"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Yönetim</div>
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="las la-utensils"></i>
                        <span>Ürünler</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="las la-shopping-bag"></i>
                        <span>Siparişler</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="las la-layer-group"></i>
                        <span>Kategoriler</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="las la-users"></i>
                        <span>Kullanıcılar</span>
                    </a>
                    <a href="{{ route('admin.tables.index') }}"
                        class="nav-link {{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
                        <i class="las la-chair"></i>
                        <span>Masalar</span>
                    </a>
                    <a href="{{ route('admin.allergens.index') }}"
                        class="nav-link {{ request()->routeIs('admin.allergens.*') ? 'active' : '' }}">
                        <i class="las la-exclamation-triangle"></i>
                        <span>Alerjenler</span>
                    </a>
                    <a href="{{ route('admin.calls.index') }}"
                        class="nav-link {{ request()->routeIs('admin.calls.index') ? 'active' : '' }}">
                        <i class="las la-bell-slash"></i>
                        <span>Masa Talepleri</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Pazarlama</div>
                    <a href="{{ route('admin.coupons.index') }}"
                        class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <i class="las la-ticket-alt"></i>
                        <span>Kuponlar</span>
                    </a>
                    <a href="{{ route('admin.campaigns.index') }}"
                        class="nav-link {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}">
                        <i class="las la-fire"></i>
                        <span>Kampanyalar</span>
                    </a>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Diğer</div>
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="las la-external-link-alt"></i>
                        <span>Siteye Git</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link"
                            style="width: 100%; background: none; border: none; cursor: pointer;">
                            <i class="las la-sign-out-alt"></i>
                            <span>Çıkış Yap</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div class="header-title">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-subtitle', 'Admin paneline hoş geldiniz')</p>
                </div>

                <div class="header-actions">
                    <button class="header-btn" id="toggleDarkMode">
                        <i class="las la-moon"></i>
                    </button>
                    <div class="header-user">
                        <div class="header-user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="header-user-info">
                            <span class="header-user-name">{{ auth()->user()->name }}</span>
                            <span class="header-user-role">Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            <div class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="las la-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="las la-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Dark mode toggle
        const isDarkMode = localStorage.getItem('adminDarkMode') === 'true';
        if (isDarkMode) {
            document.body.classList.add('dark-mode');
            document.getElementById('toggleDarkMode').innerHTML = '<i class="las la-sun"></i>';
        }

        document.getElementById('toggleDarkMode').addEventListener('click', function () {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('adminDarkMode', isDark);
            this.innerHTML = isDark ? '<i class="las la-sun"></i>' : '<i class="las la-moon"></i>';
        });
    </script>
    @stack('scripts')
</body>

</html>