<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transfer Saldo</title>
    <link rel="stylesheet" href="{{ asset('css/transfer.css') }}">
</head>
<body>
    <div class="container">
        <h2>Form Transfer Saldo</h2>

        {{-- Pesan sukses / error --}}
        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        {{-- Validasi error --}}
        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transfer.store') }}" method="POST">
            @csrf
            <label for="tujuan">Username Tujuan:</label>
            <input type="text" name="tujuan" id="tujuan" required>

            <label for="jumlah">Jumlah Transfer:</label>
            <input type="number" name="jumlah" id="jumlah" min="1" required>

            <button type="submit">Kirim</button>
        </form>

        <a href="{{ route('home') }}" class="back-btn">← Kembali ke Menu Utama</a>
    </div>
</body>
</html>
