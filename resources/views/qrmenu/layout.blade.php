<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Menü') - AtomFood</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Line Awesome -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary-color: #ff7e20;
            --primary-dark: #e66a10;
            --bg-color: #f8f9fc;
            --text-main: #2d3436;
            --text-muted: #636e72;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --radius-lg: 24px;
            --radius-md: 16px;
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            padding-bottom: 100px;
        }

        /* Hero Section */
        .hero-banner {
            background: white;
            padding: 40px 20px 30px;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
            text-align: center;
            box-shadow: var(--card-shadow);
            position: relative;
            z-index: 10;
        }

        .shop-logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 8px 20px rgba(255, 126, 32, 0.2);
            object-fit: cover;
            margin-bottom: 20px;
            background: white;
        }

        .hero-banner h1 {
            font-weight: 800;
            font-size: 1.6rem;
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }

        .table-info {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 126, 32, 0.1);
            color: var(--primary-color);
            padding: 6px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        /* Search Bar */
        .search-container {
            padding: 0 20px;
            margin-top: -25px;
            position: relative;
            z-index: 20;
        }

        .search-wrapper {
            background: white;
            border-radius: var(--radius-md);
            padding: 5px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.02);
        }

        .search-input {
            border: none;
            outline: none;
            padding: 12px;
            flex: 1;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .search-wrapper i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Categories Scroll */
        .categories-nav {
            padding: 20px 0;
            overflow-x: auto;
            white-space: nowrap;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .categories-nav::-webkit-scrollbar {
            display: none;
        }

        .category-pill {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 8px;
            background: white;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-muted);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
            text-decoration: none !important;
            transition: all 0.3s;
            border: 1px solid transparent;
        }

        .category-pill.active {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 8px 15px rgba(255, 126, 32, 0.25);
        }

        /* Product Cards */
        .menu-section {
            padding: 10px 20px;
        }

        .section-title {
            font-weight: 800;
            font-size: 1.2rem;
            margin: 20px 0 15px;
            color: var(--text-main);
        }

        .product-card {
            background: white;
            border-radius: var(--radius-md);
            padding: 12px;
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s;
            border: 1px solid rgba(0, 0, 0, 0.01);
            position: relative;
        }

        .product-card:active {
            transform: scale(0.98);
        }

        .product-image {
            width: 90px;
            height: 90px;
            border-radius: 12px;
            object-fit: cover;
            background: #eee;
        }

        .product-details {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .p-name {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .p-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 6px;
        }

        .p-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .p-price {
            font-weight: 800;
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .allergen-icons {
            display: flex;
            gap: 5px;
            margin-top: 5px;
        }

        .allergen-icon {
            width: 22px;
            height: 22px;
            background: #f1f2f6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: #b2bec3;
            cursor: help;
        }

        .add-to-cart-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 5px 15px rgba(255, 126, 32, 0.3);
        }

        /* Fixed Footer Cart */
        .footer-cart {
            position: fixed;
            bottom: 25px;
            left: 20px;
            right: 20px;
            background: #2d3436;
            padding: 16px 24px;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            cursor: pointer;
            visibility: hidden;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .footer-cart.show {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }

        .badge-count {
            background: var(--primary-color);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 12px;
            font-size: 0.9rem;
        }

        .total-amount {
            font-weight: 800;
            font-size: 1.2rem;
        }

        /* Modal Customization */
        .modal-content {
            border-radius: var(--radius-lg);
            border: none;
        }

        .modal-header {
            border: none;
            padding: 25px 25px 10px;
        }

        .modal-footer {
            border: none;
            padding: 10px 25px 25px;
        }

        .cart-item {
            padding: 15px 0;
            border-bottom: 1px solid #f1f2f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qty-box {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8f9fc;
            padding: 5px 12px;
            border-radius: 12px;
        }

        .qty-btn {
            background: white;
            border: 1px solid #eee;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--text-main);
        }

        /* Waiter Call FAB */
        .waiter-fab {
            position: fixed;
            bottom: 30px;
            right: 20px;
            z-index: 900;
            display: flex;
            flex-direction: column;
            gap: 15px;
            transition: all 0.3s;
        }

        .fab-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border: none;
            font-size: 1.5rem;
            transition: transform 0.2s;
        }

        .fab-btn:active {
            transform: scale(0.9);
        }

        .fab-waiter {
            background: var(--primary-color);
        }

        .fab-bill {
            background: #2d3436;
        }

        .order-status-card {
            background: white;
            border-radius: var(--radius-md);
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: var(--card-shadow);
        }

        .status-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 20px;
        }

        .status-steps::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: #eee;
            z-index: 1;
        }

        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 60px;
        }

        .step-icon {
            width: 30px;
            height: 30px;
            background: #eee;
            border-radius: 50%;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: #999;
        }

        .step.active .step-icon {
            background: var(--primary-color);
            color: white;
        }

        .step.completed .step-icon {
            background: #27ae60;
            color: white;
        }

        .step-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
        }

        .step.active .step-label {
            color: var(--primary-color);
        }

        /* ... existing footer cart styles ... */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div id="loader">
        <div class="spinner-grow text-warning" role="status"></div>
    </div>

    @yield('content')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(window).on('load', function () {
            $('#loader').fadeOut('slow');
        });
    </script>
    @stack('scripts')
</body>

</html>