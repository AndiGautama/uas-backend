<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login BCA</title>

    <!-- Link ke CSS eksternal -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="login-container">
        <!-- Logo BCA -->
        <div class="logo">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo BCA">
        </div>

        <!-- Notifikasi sukses -->
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi error -->
        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Judul Form -->
        <h2>Login ke Akun Anda</h2>

        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Masuk</button>
        </form>
    </div>

    <!-- Auto-hide alert -->
    <script>
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => el.style.display = 'none');
        }, 3000);
    </script>
</body>
</html>
