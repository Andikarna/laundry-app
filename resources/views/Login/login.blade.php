<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Laundry</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png" sizes="16x16">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #e0f7fa, #b3e5fc);
        }

        .container {
            display: flex;
            width: 85%;
            max-width: 1200px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border-radius: 16px;
            overflow: hidden;
        }

        .image-section {
            flex: 1;
            background: linear-gradient(135deg, #81d4fa, #29b6f6);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .image-section img {
            width: 300px;
            max-width: 90%;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.2));
        }

        .form-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-card h1 {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #0288d1;
        }

        .login-card p {
            font-size: 14px;
            margin-bottom: 25px;
            color: #607d8b;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 14px;
            color: #0288d1;
        }

        .input-group input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #b3e5fc;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
        }

        .input-group input:focus {
            border-color: #03a9f4;
            box-shadow: 0 0 6px rgba(3, 169, 244, 0.3);
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .btn-primary {
            background: #03a9f4;
            color: #fff;
            padding: 10px 24px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #0288d1;
        }

        .forgot-password {
            font-size: 13px;
            color: #03a9f4;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .signup-link {
            font-size: 14px;
            margin-top: 25px;
        }

        .signup-link a {
            color: #0288d1;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .logo {
            margin-bottom: 25px;
        }

        .logo img {
            width: 90px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
            }

            .image-section {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sisi Kiri -->
        <div class="image-section">
            <img src="{{ asset('images/background2.png') }}" alt="Ilustrasi Laundry">
        </div>

        <!-- Sisi Kanan -->
        <div class="form-section">
            <div class="login-card">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Laundry">
                </div>

                <h1>Selamat Datang di Batavia Laundry</h1>
                <p>Login untuk mengelola pesanan dan melacak progres</p>

                @if (session('error'))
                    <div style="background-color: #ffebee; color: #c62828; border-radius: 8px; padding: 10px 14px; margin-bottom: 20px; border: 1px solid #ef9a9a; text-align: left;">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" required>
                    </div>

                    <div class="actions">
                        <button type="submit" class="btn-primary">Login</button>
                        <a href="#" class="forgot-password">Lupa Kata Sandi?</a>
                    </div>
                </form>

                <div class="signup-link">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
