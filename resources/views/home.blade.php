<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu Utama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- CSS Lokal --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <div class="sidebar">
        <h2><i class="bi bi-bank"></i> BCA Online</h2>
        <a href="{{ route('cek.saldo') }}"><i class="bi bi-cash-coin me-2"></i> Cek Saldo</a>
        <a href="{{ route('transfer.index') }}"><i class="bi bi-arrow-left-right me-2"></i> Transfer Saldo</a>
        <a href="{{ route('transfer.riwayat') }}"><i class="bi bi-clock-history me-2"></i> Riwayat Transfer</a>
        <a href="{{ route('withdrawal.index') }}"><i class="bi bi-box-arrow-up me-2"></i> Penarikan Saldo</a>
        <a href="{{ route('withdrawal.riwayat') }}"><i class="bi bi-clock me-2"></i> Riwayat Penarikan</a>
        <a href="{{ route('topup.form') }}"><i class="bi bi-phone me-2"></i> Top Up Pulsa</a>
        <a href="{{ route('topup.index') }}"><i class="bi bi-controller me-2"></i> Top Up Game</a>
        <a href="{{ route('topupgame.riwayat') }}"><i class="bi bi-journal-text me-2"></i> Riwayat Top Up</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
        </form>
    </div>

    <div class="content">
        <div class="d-flex justify-content-end mb-3">
            <span id="tanggal" class="badge bg-primary me-2"></span>
            <span id="clock" class="badge bg-primary"></span>
        </div>

        <h2>Selamat Datang di Menu Utama</h2>
        <p>Silakan pilih menu dari sidebar di sebelah kiri.</p>
    </div>

    {{-- Modal Invoice Pulsa --}}
    @if(session('invoice'))
        <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="invoiceModalLabel">Invoice Top-Up Pulsa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nomor Tujuan:</strong> {{ session('invoice')['nomor'] }}</p>
                        <p><strong>Jumlah Pulsa:</strong> Rp {{ number_format(session('invoice')['jumlah'], 0, ',', '.') }}</p>
                        <p><strong>Waktu:</strong> {{ session('invoice')['waktu'] }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'));
                invoiceModal.show();
            });
        </script>
    @endif

    {{-- Jam & Tanggal --}}
    <script>
        function updateWaktu() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const tanggal = now.toLocaleDateString('id-ID', options);
            const jam = now.toLocaleTimeString('id-ID');
            document.getElementById("tanggal").innerText = tanggal;
            document.getElementById("clock").innerText = "Jam: " + jam;
        }

        setInterval(updateWaktu, 1000);
        updateWaktu();
    </script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
