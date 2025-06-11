<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu Utama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <div class="sidebar">
        <h2>BCA Online</h2>
        <a href="{{ route('cek.saldo') }}">1. Cek Saldo</a>
        <a href="{{ route('transfer.index') }}">2. Transfer Saldo</a>
        <a href="{{ route('transfer.riwayat') }}">3. Riwayat Transfer</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">4. Logout</button>
        </form>
    </div>

    <div class="content">
        <h2>Selamat Datang di Menu Utama</h2>
        <p>Silakan pilih menu dari sidebar di sebelah kiri.</p>
    </div>
</body>
</html>
