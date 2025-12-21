<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FandhFood - Lezzetli Türk Mutfağı')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Marck+Script&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --main-color: #ff7e20;
            --main-color-dark: #e86a0a;
            --text-color: rgb(72, 72, 72);
            --bg-color: #ffffff;
            --shadow-color: #ddd;
            --footer-bg: #1a1a2e;
            --footer-text: #ffffff;
            --footer-link: #aaa;
            --footer-border: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .font-marck {
            font-family: 'Marck Script', cursive;
        }

        .font-quicksand-m {
            font-family: 'Quicksand', sans-serif;
            font-weight: 500;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-family: 'Marck Script', cursive;
            font-size: 2rem;
            color: var(--main-color);
            text-decoration: none;
        }

        .header-navigation {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .header-button {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f8f8 0%, #e8e8e8 100%);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .header-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .header-button i {
            font-size: 1.3rem;
            color: var(--text-color);
        }

        /* Cart Popup */
        .cart-popup {
            position: absolute;
            top: 60px;
            right: 0;
            width: 380px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 1001;
        }

        .cart-popup.active {
            display: block;
        }

        .cart-popup-arrow {
            position: absolute;
            top: -10px;
            right: 20px;
            width: 20px;
            height: 20px;
            background: white;
            transform: rotate(45deg);
        }

        .cart-popup-box {
            padding: 20px;
        }

        .cart-popup-cards {
            max-height: 300px;
            overflow-y: auto;
        }

        .cart-popup-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-popup-card-left {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .cart-popup-image {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
        }

        .cart-popup-food-name {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cart-popup-food-price {
            color: var(--main-color);
            font-weight: 600;
        }

        .cart-popup-number-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cart-popup-number {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .cart-popup-number-arrows {
            display: flex;
            flex-direction: column;
        }

        .cart-popup-number-arrows i {
            cursor: pointer;
            padding: 2px;
            transition: color 0.2s;
        }

        .cart-popup-number-arrows i:hover {
            color: var(--main-color);
        }

        .cart-popup-footer {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .cart-popup-total-price {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .cart-popup-go-cart {
            display: block;
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .cart-popup-go-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 126, 32, 0.4);
            color: white;
        }

        .cart-popup-alert {
            text-align: center;
            padding: 30px 20px;
            color: #888;
        }

        .cart-popup-alert i {
            font-size: 3rem;
            color: #ddd;
        }

        .cart-popup-login-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 25px;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Main Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 100px 50px 50px;
        }

        /* Hero Section */
        .home-page-welcome {
            padding: 100px 0;
        }

        .home-page-welcome h2 {
            font-size: 4rem;
            color: var(--main-color);
            margin-bottom: 20px;
        }

        .home-page-welcome h3 {
            font-size: 1.3rem;
            font-weight: 400;
            color: var(--text-color);
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .home-page-welcome button {
            padding: 15px 35px;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Quicksand', sans-serif;
        }

        .home-page-welcome button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 126, 32, 0.4);
        }

        .background-1 {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .background-1 img {
            width: 400px;
            height: 400px;
            object-fit: cover;
            border-radius: 50%;
            z-index: 1;
        }

        .home-page-back-circle {
            position: absolute;
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-40%, -40%);
        }

        .background-text {
            position: absolute;
            font-size: 10rem;
            font-weight: 700;
            color: rgba(0, 0, 0, 0.03);
            z-index: 0;
            white-space: nowrap;
        }

        /* Alert Container */
        .main-alert-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
        }

        .main-alert {
            padding: 15px 25px;
            background: #4CAF50;
            color: white;
            border-radius: 10px;
            display: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .main-alert.show {
            display: block;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Products Section */
        .products-section {
            padding: 80px 0;
        }

        .products-title-and-navigation {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .products-title-and-navigation h2 {
            font-size: 3rem;
            color: var(--main-color);
        }

        .products-title-and-navigation nav ul {
            display: flex;
            gap: 20px;
            list-style: none;
            flex-wrap: wrap;
        }

        .products-navigation-button {
            padding: 10px 25px;
            background: #f5f5f5;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .products-navigation-button:hover,
        .products-navigation-active {
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            color: white;
        }

        .products {
            display: none;
        }

        .products:first-of-type {
            display: flex;
        }

        .product {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .product:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product:hover .product-image img {
            transform: scale(1.1);
        }

        .product-image-blur {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5), transparent);
        }

        .product-price-and-addtocart {
            position: absolute;
            bottom: 15px;
            left: 15px;
            right: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-price {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
        }

        .product-price-wrap {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .product-price-old {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: line-through;
            margin: 0;
        }

        .product-price-discounted {
            color: #4ade80 !important;
            text-shadow: 0 2px 10px rgba(74, 222, 128, 0.4);
        }

        .product-discount-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 12px;
            z-index: 10;
            text-align: center;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            animation: pulse-badge 2s infinite;
        }

        .product-discount-badge span {
            display: block;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .product-discount-badge small {
            display: block;
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        @keyframes pulse-badge {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .product-addtocart,
        .product-addtocart-login {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .product-addtocart:hover,
        .product-addtocart-login:hover {
            background: var(--main-color);
            color: white;
        }

        .product-addtocart i,
        .product-addtocart-login i {
            font-size: 1.3rem;
        }

        .product-no-stock {
            background: rgba(255, 0, 0, 0.8);
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 600;
        }

        .product-info {
            padding: 20px;
        }

        .product-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .product-point-and-stars {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .product-stars i {
            color: #ffc107;
        }

        .product-point {
            font-weight: 600;
            color: var(--main-color);
        }

        .product-description {
            color: #888;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* Comments Section */
        .comments-section {
            padding: 80px 0;
            background: #f9f9f9;
        }

        .comments-section h2 {
            font-size: 3rem;
            color: var(--main-color);
            text-align: center;
            margin-bottom: 50px;
        }

        .comment-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            opacity: 0.5;
            transform: scale(0.95);
            transition: all 0.5s ease;
        }

        .comment-card-active {
            opacity: 1;
            transform: scale(1);
        }

        .comment-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .comment-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .comment-user-name {
            font-weight: 600;
        }

        .comment-stars i {
            color: #ffc107;
        }

        .comment-text {
            color: #666;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .comment-actions {
            display: flex;
            gap: 15px;
        }

        .comment-action-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 15px;
            border: 1px solid #eee;
            border-radius: 20px;
            background: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Quicksand', sans-serif;
        }

        .comment-action-btn:hover {
            border-color: var(--main-color);
            color: var(--main-color);
        }

        /* Branches Section */
        .branches-section {
            padding: 80px 0;
        }

        .branches-section h2 {
            font-size: 3rem;
            color: var(--main-color);
            text-align: center;
            margin-bottom: 50px;
        }

        .branch-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .branch-card:hover,
        .branch-card.active {
            border-left: 4px solid var(--main-color);
            transform: translateX(5px);
        }

        .branch-name {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .branch-address,
        .branch-phone {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        #our-branches-map {
            height: 400px;
            border-radius: 20px;
            overflow: hidden;
        }

        /* Footer */
        .footer {
            background: var(--footer-bg);
            color: var(--footer-text);
            padding: 60px 50px 30px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .footer-logo {
            font-family: 'Marck Script', cursive;
            font-size: 2.5rem;
            color: var(--main-color);
        }

        .footer-brand p {
            color: var(--footer-link);
        }

        .footer-links h4 {
            margin-bottom: 20px;
            font-weight: 600;
            color: var(--footer-text);
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--footer-link);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--main-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid var(--footer-border);
            color: var(--footer-link);
        }

        /* Add to Cart Popup */
        .addtocart-popup-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .addtocart-popup-container.active {
            display: flex;
        }

        .addtocart-popup {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 30px;
            position: relative;
        }

        .addtocart-popup-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #f5f5f5;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .addtocart-popup-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .addtocart-popup-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .addtocart-popup-price {
            font-size: 1.3rem;
            color: var(--main-color);
            font-weight: 600;
            margin-bottom: 20px;
        }

        .option-group {
            margin-bottom: 20px;
        }

        .option-group-title {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .option-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 10px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .option-item:hover {
            border-color: var(--main-color);
        }

        .option-item input {
            margin-right: 10px;
        }

        .option-price {
            margin-left: auto;
            color: var(--main-color);
            font-weight: 600;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--main-color);
            background: none;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--main-color);
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--main-color);
            color: white;
        }

        .cart-item-quantity {
            width: 50px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 600;
            border: none;
            background: none;
        }

        .addtocart-textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 10px;
            resize: none;
            font-family: 'Quicksand', sans-serif;
            margin-bottom: 20px;
        }

        .addtocart-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Quicksand', sans-serif;
        }

        .addtocart-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 126, 32, 0.4);
        }

        /* Sidebar Menu */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .sidebar-menu {
            position: fixed;
            top: 0;
            right: -320px;
            width: 320px;
            height: 100vh;
            background: white;
            z-index: 2000;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu.active {
            right: 0;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            border-bottom: 1px solid #eee;
        }

        .sidebar-logo {
            font-family: 'Marck Script', cursive;
            font-size: 1.8rem;
            color: var(--main-color);
            text-decoration: none;
        }

        .sidebar-close {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f5f5f5;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }

        .sidebar-close:hover {
            background: var(--main-color);
            color: white;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            color: var(--text-color);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            margin-bottom: 5px;
            background: none;
            border: none;
            width: 100%;
            font-family: 'Quicksand', sans-serif;
            font-size: 1rem;
            cursor: pointer;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(255, 126, 32, 0.1) 0%, rgba(232, 106, 10, 0.1) 100%);
            color: var(--main-color);
        }

        .sidebar-link i {
            font-size: 1.4rem;
            width: 25px;
        }

        .sidebar-divider {
            height: 1px;
            background: #eee;
            margin: 15px 0;
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
        }

        .sidebar-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .sidebar-user-info {
            display: flex;
            flex-direction: column;
        }

        .sidebar-user-name {
            font-weight: 600;
            color: var(--text-color);
        }

        .sidebar-user-email {
            font-size: 0.85rem;
            color: #888;
        }

        .sidebar-logout {
            color: #dc3545 !important;
        }

        .sidebar-logout:hover {
            background: rgba(220, 53, 69, 0.1) !important;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #eee;
        }

        .sidebar-theme-toggle {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            color: var(--text-color);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar-theme-toggle:hover {
            background: #f5f5f5;
        }

        .sidebar-theme-toggle i {
            font-size: 1.4rem;
        }


        @media (max-width: 768px) {
            .header {
                padding: 15px 20px;
            }

            .container {
                padding: 80px 20px 30px;
            }

            .home-page-welcome h2 {
                font-size: 2.5rem;
            }

            .background-1 img {
                width: 250px;
                height: 250px;
            }

            .home-page-back-circle {
                width: 200px;
                height: 200px;
            }

            .background-text {
                font-size: 5rem;
            }

            .products-title-and-navigation {
                flex-direction: column;
                align-items: flex-start;
            }

            .products-title-and-navigation nav ul {
                margin-top: 20px;
            }

            .cart-popup {
                width: 320px;
                right: -50px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('components.header')
    @include('components.sidebar-menu')

    <div class="main-alert-container">
        <div class="main-alert" id="mainAlert"></div>
    </div>

    @yield('content')

    @include('components.footer')

    <div class="addtocart-popup-container" id="addtocartPopupContainer"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // CSRF Token for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Show Alert
        function showAlert(message, type = 'success') {
            const alert = document.getElementById('mainAlert');
            alert.textContent = message;
            alert.style.background = type === 'success' ? '#4CAF50' : '#f44336';
            alert.classList.add('show');
            setTimeout(() => alert.classList.remove('show'), 3000);
        }

        // Dark Mode
        let isDarkMode = localStorage.getItem('darkMode') === 'true';

        function enableDarkMode() {
            document.documentElement.style.setProperty('--bg-color', '#1a1a2e');
            document.documentElement.style.setProperty('--text-color', '#eee');
            document.documentElement.style.setProperty('--shadow-color', '#0a0a15');
            document.documentElement.style.setProperty('--footer-bg', '#0d0d1a');
            document.documentElement.style.setProperty('--footer-text', '#ffffff');
            document.documentElement.style.setProperty('--footer-link', '#888');
            document.documentElement.style.setProperty('--footer-border', '#222');
            document.querySelector('.button-night-mode').innerHTML = `<i class='las la-sun'></i>`;
            isDarkMode = true;
        }

        function disableDarkMode() {
            document.documentElement.style.setProperty('--bg-color', '#ffffff');
            document.documentElement.style.setProperty('--text-color', 'rgb(72, 72, 72)');
            document.documentElement.style.setProperty('--shadow-color', '#ddd');
            document.documentElement.style.setProperty('--footer-bg', '#1a1a2e');
            document.documentElement.style.setProperty('--footer-text', '#ffffff');
            document.documentElement.style.setProperty('--footer-link', '#aaa');
            document.documentElement.style.setProperty('--footer-border', '#333');
            document.querySelector('.button-night-mode').innerHTML = `<i class='las la-moon'></i>`;
            isDarkMode = false;
        }

        function toggleDarkMode() {
            if (isDarkMode) {
                disableDarkMode();
                localStorage.setItem('darkMode', 'false');
            } else {
                enableDarkMode();
                localStorage.setItem('darkMode', 'true');
            }
        }

        // Initialize dark mode on load
        if (isDarkMode) {
            enableDarkMode();
        }

        // Sidebar Menu Toggle
        function openSidebar() {
            document.getElementById('sidebarMenu').classList.add('active');
            document.getElementById('sidebarOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            document.getElementById('sidebarMenu').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Hamburger button click
        document.querySelector('.button-hamburger')?.addEventListener('click', openSidebar);

        // Cart Popup Toggle
        document.getElementById('buttonCart')?.addEventListener('click', function () {
            document.getElementById('cart_popup').classList.toggle('active');
        });

        // Close cart popup when clicking outside
        document.addEventListener('click', function (e) {
            const cartPopup = document.getElementById('cart_popup');
            const cartButton = document.getElementById('buttonCart');
            if (cartPopup && !cartPopup.contains(e.target) && !cartButton.contains(e.target)) {
                cartPopup.classList.remove('active');
            }
        });

        // Product Category Tabs
        function getMenu(index) {
            const products = document.querySelectorAll('.products');
            const buttons = document.querySelectorAll('.products-navigation-button');

            products.forEach((p, i) => {
                p.style.display = i === index ? 'flex' : 'none';
            });

            buttons.forEach((b, i) => {
                b.classList.toggle('products-navigation-active', i === index);
            });
        }

        // Add to Cart
        function openProductPopup(productId) {
            fetch(`/urun/${productId}/secenekler`)
                .then(res => res.text())
                .then(html => {
                    const container = document.getElementById('addtocartPopupContainer');
                    container.innerHTML = html;
                    container.classList.add('active');
                });
        }

        function closeProductPopup() {
            document.getElementById('addtocartPopupContainer').classList.remove('active');
        }

        function addToCart(productId) {
            const form = document.getElementById('addtocartForm');
            const formData = new FormData(form);
            formData.append('product_id', productId);

            // Collect selected options
            const options = [];
            form.querySelectorAll('input[type="checkbox"]:checked, input[type="radio"]:checked').forEach(input => {
                options.push(parseInt(input.value));
            });
            formData.append('options', JSON.stringify(options));

            fetch('/sepet/ekle', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(formData.get('quantity')) || 1,
                    note: formData.get('note') || '',
                    options: options,
                }),
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message);
                        closeProductPopup();
                        updateCartBadge(data.cart_count);
                        refreshCartPopup(); // Refresh cart popup content
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(() => showAlert('Bir hata oluştu!', 'error'));
        }

        function updateCartBadge(count) {
            let badge = document.getElementById('cartBadge');
            if (!badge) {
                // Create badge if it doesn't exist
                const cartButton = document.querySelector('.button-cart');
                if (cartButton) {
                    badge = document.createElement('span');
                    badge.id = 'cartBadge';
                    badge.style.cssText = 'position: absolute; top: -5px; right: -5px; background: var(--main-color); color: white; font-size: 0.7rem; width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center;';
                    cartButton.appendChild(badge);
                }
            }
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
        }

        // Refresh cart popup content via AJAX
        function refreshCartPopup() {
            fetch('/sepet/popup')
                .then(res => res.text())
                .then(html => {
                    const cartPopupBox = document.querySelector('.cart-popup-box');
                    if (cartPopupBox) {
                        cartPopupBox.innerHTML = html;
                    }
                })
                .catch(err => console.error('Cart popup refresh failed:', err));
        }

        // Quantity Controls
        function increaseQuantity() {
            const input = document.querySelector('.cart-item-quantity');
            if (input) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.querySelector('.cart-item-quantity');
            if (input && parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        // Cart Item Quantity Update
        function updateCartItemQuantity(itemId, action) {
            fetch(`/sepet/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: action }),
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        updateCartBadge(data.cart_count);
                        refreshCartPopup();
                    } else {
                        showAlert(data.message || 'Bir hata oluştu!', 'error');
                    }
                })
                .catch(() => showAlert('Bir hata oluştu!', 'error'));
        }

        function removeCartItem(itemId) {
            fetch(`/sepet/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message);
                        updateCartBadge(data.cart_count);
                        refreshCartPopup();
                    } else {
                        showAlert(data.message || 'Bir hata oluştu!', 'error');
                    }
                })
                .catch(() => showAlert('Bir hata oluştu!', 'error'));
        }

        // Comment Like/Dislike
        function likeComment(commentId) {
            fetch(`/yorum/${commentId}/begeni`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`helpful-${commentId}`).textContent = data.helpful;
                    }
                });
        }

        function dislikeComment(commentId) {
            fetch(`/yorum/${commentId}/begenme`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`not-helpful-${commentId}`).textContent = data.not_helpful;
                    }
                });
        }

        // Branch Map
        let map;
        function initMap() {
            // Will be initialized when Google Maps loads
        }

        function selectBranch(name, lat, lng, element) {
            document.querySelectorAll('.branch-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');

            if (typeof google !== 'undefined' && google.maps) {
                const position = { lat: parseFloat(lat), lng: parseFloat(lng) };
                map = new google.maps.Map(document.getElementById('our-branches-map'), {
                    zoom: 15,
                    center: position,
                });
                new google.maps.Marker({
                    position: position,
                    map: map,
                    title: name,
                });
            }
        }

        // Comments Slider
        let currentComment = 0;
        const commentCards = document.querySelectorAll('.comment-card');

        function showNextComment() {
            if (commentCards.length > 0) {
                commentCards[currentComment].classList.remove('comment-card-active');
                currentComment = (currentComment + 1) % commentCards.length;
                commentCards[currentComment].classList.add('comment-card-active');
            }
        }

        if (commentCards.length > 0) {
            commentCards[0].classList.add('comment-card-active');
            setInterval(showNextComment, 6000);
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>