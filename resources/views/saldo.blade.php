<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Saldo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- CSS Lokal --}}
    <link rel="stylesheet" href="{{ asset('css/saldo.css') }}">
</head>
<body>
    <div class="saldo-wrapper">
        <div class="saldo-card shadow-lg">
            <div class="icon-saldo mb-3 text-center">
                <i class="bi bi-wallet2"></i>
            </div>
            <h4 class="text-center mb-4">Informasi Saldo</h4>

            <div class="info-item"><strong>👤 Nama:</strong> {{ $user->name }}</div>
            <div class="info-item"><strong>🆔 Username:</strong> {{ $user->username }}</div>
            <div class="info-item saldo">
                <strong>💰 Saldo:</strong> Rp {{ number_format($user->saldo, 0, ',', '.') }}
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-primary">← Kembali ke Menu</a>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
