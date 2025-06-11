<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Saldo</title>
    <link rel="stylesheet" href="{{ asset('css/saldo.css') }}">
</head>
<body>
    <div class="container">
        <h2>Informasi Saldo</h2>

        <div class="info">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Saldo:</strong> Rp {{ number_format($user->saldo, 0, ',', '.') }}</p>
        </div>

        <a href="{{ route('home') }}" class="back-btn">← Kembali ke Menu</a>
    </div>
</body>
</html>
