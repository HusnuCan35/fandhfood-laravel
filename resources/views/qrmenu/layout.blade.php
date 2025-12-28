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
            --bg-card: #ffffff;
            --text-main: #2d3436;
            --text-muted: #636e72;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --radius-lg: 24px;
            --radius-md: 16px;
        }

        body.dark-mode {
            --bg-color: #1a1a2e;
            --bg-card: #16213e;
            --text-main: #eaeaea;
            --text-muted: #a0a0a0;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
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
            transition: background-color 0.3s, color 0.3s;
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--bg-card);
            border: none;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--text-main);
            cursor: pointer;
            transition: all 0.3s;
        }

        .dark-mode-toggle:hover {
            transform: scale(1.1);
        }

        /* Hero Section */
        .hero-banner {
            background: var(--bg-card);
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
            background: var(--bg-card);
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
            background: transparent;
            color: var(--text-main);
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
            background: var(--bg-card);
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
            background: var(--bg-card);
            border-radius: var(--radius-md);
            padding: 12px;
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s;
            border: 1px solid rgba(0, 0, 0, 0.01);
            position: relative;
            cursor: pointer;
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
            background: var(--bg-card);
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

        /* Product Detail Modal */
        .product-modal .modal-content {
            background: var(--bg-card);
            border: none;
            border-radius: var(--radius-lg);
        }

        .product-modal .modal-header {
            border-bottom: none;
            padding: 20px 20px 10px;
        }

        .product-modal .modal-body {
            padding: 20px;
        }

        .product-modal-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: var(--radius-md);
            margin-bottom: 20px;
        }

        .product-modal-title {
            font-weight: 800;
            font-size: 1.4rem;
            margin-bottom: 8px;
        }

        .product-modal-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .product-modal-price {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .allergen-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
        }

        .allergen-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 126, 32, 0.1);
            color: var(--primary-color);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Cart Add Animation */
        @keyframes flyToCart {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.2);
                opacity: 0.8;
            }

            100% {
                transform: scale(0.5) translateY(-50px);
                opacity: 0;
            }
        }

        .fly-animation {
            animation: flyToCart 0.5s ease-out forwards;
        }

        .pulse-animation {
            animation: pulse 0.3s ease-in-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Loader Dark Mode */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-color);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <!-- Dark Mode Toggle -->
    <button class="dark-mode-toggle" id="darkModeToggle">
        <i class="las la-moon" id="darkModeIcon"></i>
    </button>

    <div id="loader">
        <div class="spinner-grow text-warning" role="status"></div>
    </div>

    @yield('content')

    <!-- Product Detail Modal -->
    <div class="modal fade product-modal" id="productDetailModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalProductImage" class="product-modal-image" src="" alt="">
                    <h3 id="modalProductName" class="product-modal-title"></h3>
                    <p id="modalProductDesc" class="product-modal-desc"></p>
                    <div id="modalAllergens" class="allergen-list"></div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <span id="modalProductPrice" class="product-modal-price"></span>
                        <button id="modalAddToCart" class="add-to-cart-btn"
                            style="width: auto; padding: 12px 25px; border-radius: 12px;">
                            <i class="las la-cart-plus"></i> Sepete Ekle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(window).on('load', function () {
            $('#loader').fadeOut('slow');
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');

        if (localStorage.getItem('qrDarkMode') === 'true') {
            document.body.classList.add('dark-mode');
            darkModeIcon.classList.replace('la-moon', 'la-sun');
        }

        darkModeToggle.addEventListener('click', function () {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('qrDarkMode', isDark);
            if (isDark) {
                darkModeIcon.classList.replace('la-moon', 'la-sun');
            } else {
                darkModeIcon.classList.replace('la-sun', 'la-moon');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>