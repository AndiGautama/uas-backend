<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Penarikan</title>
    <link rel="stylesheet" href="{{ asset('css/riwayat.css') }}">
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h2>Riwayat Penarikan</h2>
            <div class="action-buttons">
                <a href="{{ route('withdrawal.form') }}" class="pdf-btn">Penarikan Baru</a>
                <a href="{{ route('withdrawal.cetak-pdf') }}" class="pdf-btn">📄 Cetak PDF</a>
            </div>
        </div>

        <ul class="transfer-list">
            @forelse ($withdrawals as $withdrawal)
                <li>
                    <div><strong>Kode:</strong> <span style="color:#e74c3c">{{ $withdrawal->withdrawal_code }}</span></div>
                    <div><strong>Status:</strong> {{ ucfirst($withdrawal->status) }}</div>
                    <div><strong>Jumlah:</strong> <span class="amount">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</span></div>
                    <div class="date"><strong>Tanggal:</strong> {{ $withdrawal->created_at->format('d M Y H:i') }}</div>
                    @if ($withdrawal->notes)
                        <div><strong>Catatan:</strong> {{ $withdrawal->notes }}</div>
                    @endif
                </li>
            @empty
                <li class="empty">Belum ada data penarikan.</li>
            @endforelse
        </ul>

        <a href="{{ route('home') }}" class="back-btn">← Kembali ke Menu Utama</a>
    </div>
</body>
</html>
