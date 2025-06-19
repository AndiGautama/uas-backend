<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Top Up Game')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tambahkan CSS jika perlu --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/topup.css') }}">
</head>
<body>
    <div class="sidebar">
        <h2>Menu</h2>
        <a href="{{ route('cek.saldo') }}">1. Cek Saldo</a><br>
        <a href="{{ route('transfer.index') }}">2. Transfer</a><br>
        <a href="{{ route('withdrawal.index') }}">3. Penarikan</a><br>
        <a href="{{ route('topup.index') }}">4. Top Up Game</a><br>
        <a href="{{ route('topup.riwayat') }}">5. Riwayat Top Up</a><br>
        <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>