<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol - FandhFood</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&family=Marck+Script&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
        :root {
            --main-color: #ff7e20;
            --main-color-dark: #e86a0a;
            --text-color: rgb(72, 72, 72);
            --bg-color: #fff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #fff5eb 0%, #fff 100%);
        }

        .auth-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .auth-hero {
            flex: 1;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .auth-hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }

        .hero-content {
            text-align: center;
            color: white;
            z-index: 1;
        }

        .hero-logo {
            font-family: 'Marck Script', cursive;
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .hero-tagline {
            font-size: 1.3rem;
            opacity: 0.95;
            max-width: 350px;
            line-height: 1.6;
        }

        .hero-image {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            margin-top: 40px;
            border: 6px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .auth-form-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            overflow-y: auto;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(255, 126, 32, 0.15);
        }

        .auth-title {
            font-size: 2rem;
            color: var(--text-color);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .auth-subtitle {
            color: #888;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-color);
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 1.2rem;
        }

        .form-group input {
            width: 100%;
            padding: 14px 14px 14px 50px;
            border: 2px solid #eee;
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Quicksand', sans-serif;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--main-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(255, 126, 32, 0.1);
        }

        .input-wrapper:focus-within i {
            color: var(--main-color);
        }

        .btn-primary {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--main-color) 0%, var(--main-color-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Quicksand', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 126, 32, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 126, 32, 0.5);
        }

        .auth-footer {
            text-align: center;
            margin-top: 25px;
            color: #888;
        }

        .auth-footer a {
            color: var(--main-color);
            text-decoration: none;
            font-weight: 600;
        }

        .back-home {
            position: absolute;
            top: 30px;
            left: 30px;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            opacity: 0.9;
            z-index: 2;
        }

        .back-home i {
            font-size: 1.4rem;
        }

        .error-message {
            background: #ffe6e6;
            color: #d63031;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .error-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        @media (max-width: 968px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-hero {
                padding: 40px 30px;
                min-height: 35vh;
            }

            .hero-logo {
                font-size: 3rem;
            }

            .hero-image {
                width: 150px;
                height: 150px;
                margin-top: 20px;
            }

            .auth-form-section {
                padding: 30px 20px 50px;
            }

            .auth-card {
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-hero">
            <a href="{{ route('home') }}" class="back-home">
                <i class="las la-arrow-left"></i>
                Ana Sayfa
            </a>
            <div class="hero-content">
                <h1 class="hero-logo">FandhFood</h1>
                <p class="hero-tagline">Ailemize katılın ve lezzetli yemeklerin tadını çıkarın!</p>
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400" alt="Lezzetli Yemekler"
                    class="hero-image">
            </div>
        </div>

        <div class="auth-form-section">
            <div class="auth-card">
                <h2 class="auth-title">Hesap Oluştur ✨</h2>
                <p class="auth-subtitle">Hemen ücretsiz kayıt olun</p>

                @if($errors->any())
                    <div class="error-message">
                        <ul class="error-list">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Ad Soyad</label>
                        <div class="input-wrapper">
                            <input type="text" id="name" name="name" placeholder="Adınız Soyadınız"
                                value="{{ old('name') }}" required>
                            <i class="las la-user"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">E-posta</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" placeholder="ornek@email.com"
                                value="{{ old('email') }}" required>
                            <i class="las la-envelope"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone">Telefon (Opsiyonel)</label>
                        <div class="input-wrapper">
                            <input type="tel" id="phone" name="phone" placeholder="05XX XXX XX XX"
                                value="{{ old('phone') }}">
                            <i class="las la-phone"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Şifre</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="En az 6 karakter"
                                required>
                            <i class="las la-lock"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Şifre Tekrar</label>
                        <div class="input-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Şifrenizi tekrar girin" required>
                            <i class="las la-lock"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Kayıt Ol</button>
                </form>

                <div class="auth-footer">
                    Zaten hesabınız var mı? <a href="{{ route('login') }}">Giriş Yap</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>