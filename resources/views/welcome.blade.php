<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Welcome - BCA</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body>
    <div class="welcome-container">
        <div class="logo">
            <img src="{{ asset('images/Logo.png') }}" alt="BCA Logo">
        </div>
        <h1>Selamat Datang di Portal BCA</h1>
        <p>Silakan masuk dengan akun Anda untuk mengakses layanan kami.</p>
        <a href="{{ route('login.form') }}" class="btn-login">Login</a>
    </div>
</body>
</html>
