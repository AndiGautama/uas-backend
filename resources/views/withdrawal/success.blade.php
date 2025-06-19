<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penarikan Berhasil</title>
    <link rel="stylesheet" href="{{ asset('css/withdrawal.css') }}">
</head>
<body>
    <div class="container">
        <div class="success-container">
            <div class="success-icon">✅</div>
            <h2>Penarikan Berhasil!</h2>
            
            <div class="withdrawal-details">
                <div class="detail-card">
                    <h3>Detail Penarikan</h3>
                    <div class="detail-row">
                        <span>Kode Penarikan:</span>
                        <strong class="withdrawal-code">{{ $withdrawal->withdrawal_code }}</strong>
                    </div>
                    <div class="detail-row">
                        <span>Jumlah:</span>
                        <strong>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</strong>
                    </div>
                    <div class="detail-row">
                        <span>Tanggal:</span>
                        <strong>{{ $withdrawal->created_at->format('d F Y H:i:s') }}</strong>
                    </div>
                    <div class="detail-row">
                        <span>Status:</span>
                        <span class="status status-{{ $withdrawal->status }}">{{ $withdrawal->status_label }}</span>
                    </div>
                </div>

                <div class="instructions">
                    <h4>📝 Cara Mengambil Uang:</h4>
                    <ol>
                        <li>Datang ke petugas atau mesin ATM terdekat</li>
                        <li>Tunjukkan <strong>kode penarikan</strong> di atas</li>
                        <li>Sebutkan jumlah yang akan diambil</li>
                        <li>Tunggu proses verifikasi</li>
                        <li>Ambil uang tunai Anda</li>
                    </ol>
                </div>

                <div class="important-note">
                    <h4>⚠️ Penting:</h4>
                    <p>Simpan kode penarikan ini dengan baik. Kode ini diperlukan untuk mengambil uang tunai Anda.</p>
                </div>
            </div>

            <div class="action-buttons">
                <button onclick="window.print()" class="print-btn">
                    🖨️ Cetak Bukti
                </button>
                <a href="{{ route('withdrawal.riwayat') }}" class="history-btn">
                    📋 Lihat Riwayat
                </a>
                <a href="{{ route('home') }}" class="home-btn">
                    🏠 Kembali ke Menu Utama
                </a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .action-buttons { display: none !important; }
            body { background: white !important; }
            .container { box-shadow: none !important; }
        }
    </style>
</body>
</html>