<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CleanFresh Laundry</title>
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
            display: none;
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
        }

        .form-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 40px;
        }

        .register-card {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .register-card h1 {
            font-size: 26px;
            font-weight: 600;
            color: #0288d1;
            margin-bottom: 8px;
        }

        .register-card p {
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
            width: 100%;
        }

        .btn-primary:hover {
            background: #0288d1;
        }

        .hidden {
            display: none;
        }

        .success {
            color: #2e7d32;
            margin-top: 10px;
            font-weight: 600;
        }

        /* --- Modal Styling --- */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal.active {
            visibility: visible;
            opacity: 1;
        }

        .modal-content {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-content h2 {
            color: #0288d1;
            margin-bottom: 20px;
        }

        .modal-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .btn-option {
            background-color: #03a9f4;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-option:hover {
            background-color: #0288d1;
        }
    </style>
</head>

<body>
    <!-- Popup Modal -->
    <div id="bookingModal" class="modal active">
        <div class="modal-content">
            <h2>Apakah Anda sudah pernah melakukan booking di Batavia Laundry sebelumnya?</h2>
            <div class="modal-buttons">
                <button class="btn-option" onclick="window.location.href='{{ route('login') }}'">Sudah Pernah</button>
                <button class="btn-option" onclick="closeModal()">Belum Pernah</button>
            </div>
        </div>
    </div>

    <!-- Form Register -->
    <div class="container" id="registerContainer">
        <div class="image-section">
            <img src="{{ asset('images/background2.png') }}" alt="Laundry Illustration" />
        </div>

        <div class="form-section">
            <div class="register-card">
                <h1>Register Batavia Laundry</h1>
                <p>Mulai langkah bersihmu bersama Batavia Laundry 🧺</p>
                <form id="registerForm" action="{{ route('register') }}" method="POST" onsubmit="return finishRegister(event)">


            <form id="registerForm" action="{{ route('register') }}" method="POST" onsubmit="return finishRegister(event)">
            @csrf

            <!-- Step 1 -->
            <div id="step1">
                <div class="input-group">
                    <label for="phone">Nomor HP</label>
                    <input type="text" id="phone" name="phone" placeholder="Masukkan nomor HP" required />
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda" required />
                </div>
                <button type="button" class="btn-primary" onclick="nextStep1()">Lanjut</button>
            </div>

            <!-- Step 2 -->
            <div id="step2" class="hidden">
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Buat password" required />
                </div>
                <button type="button" class="btn-primary" onclick="nextStep2()">Lanjut</button>
            </div>

            <!-- Step 3 -->
            <div id="step3" class="hidden">
                <div class="input-group">
                    <label for="username">Nama Lengkap</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan nama lengkap" required />
                </div>
                <button type="submit" class="btn-primary">Selesai & Login</button>
            </div>
        </form>

        </div>
    </div>

    <script>
        // Tutup modal dan tampilkan form register
        function closeModal() {
            document.getElementById("bookingModal").classList.remove("active");
            document.getElementById("registerContainer").style.display = "flex";
        }

        function nextStep1() {
            const phone = document.getElementById("phone").value.trim();
            const email = document.getElementById("email").value.trim();
            if (phone.length >= 10 && email.includes("@")) {
                document.getElementById("step1").classList.add("hidden");
                document.getElementById("step2").classList.remove("hidden");
            } else {
                alert("Nomor HP atau Email tidak valid!");
            }
        }

        function nextStep2() {
            const password = document.getElementById("password").value.trim();
            if (password.length >= 6) {
                document.getElementById("step2").classList.add("hidden");
                document.getElementById("step3").classList.remove("hidden");
            } else {
                alert("Password minimal 6 karakter!");
            }
        }

        function finishRegister(event) {
            const username = document.getElementById("username").value.trim();
            if (username.length < 3) {
                alert("Nama lengkap harus valid!");
                event.preventDefault();
                return false;
            }
            return true; // lanjutkan submit ke Laravel
        }
    </script>
</body>

</html>
