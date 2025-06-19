<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transfer</title>
    <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h2>Riwayat Transfer</h2>
            <div class="action-buttons">
                <a href="{{ route('riwayat.cetak-pdf') }}" class="pdf-btn" target="_blank">
                    📄 Cetak PDF
                </a>
            </div>
        </div>

        <!-- Filter Form (Opsional) -->
        <div class="filter-section">
            <form method="POST" action="{{ route('riwayat.cetak-pdf-filter') }}" class="filter-form">
                @csrf
                <div class="filter-row">
                    <div class="filter-item">
                        <label>Dari Tanggal:</label>
                        <input type="date" name="start_date" class="date-input">
                    </div>
                    <div class="filter-item">
                        <label>Sampai Tanggal:</label>
                        <input type="date" name="end_date" class="date-input">
                    </div>
                    <div class="filter-item">
                        <button type="submit" class="filter-pdf-btn">📄 PDF Filter</button>
                    </div>
                </div>
            </form>
        </div>

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