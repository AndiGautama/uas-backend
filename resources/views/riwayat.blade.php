<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transfer</title>
    <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">
</head>
<body>
    <div class="container">
        <h2>Riwayat Transfer</h2>

        <ul class="transfer-list">
            @forelse($transfers as $transfer)
                <li>
                    <span class="date">{{ $transfer->created_at->format('d M Y H:i') }}</span> –
                    <span class="from">Dari: <strong>{{ $transfer->fromUser->username }}</strong></span> ke
                    <span class="to"><strong>{{ $transfer->toUser->username }}</strong></span> –
                    <span class="amount">Jumlah: <strong>Rp {{ number_format($transfer->amount, 0, ',', '.') }}</strong></span>
                </li>
            @empty
                <li class="empty">Tidak ada riwayat transfer.</li>
            @endforelse
        </ul>

        <a href="{{ route('home') }}" class="back-btn">← Kembali ke Menu Utama</a>
    </div>
</body>
</html>
