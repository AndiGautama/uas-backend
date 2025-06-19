<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu Utama</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- CSS Lokal --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <div class="sidebar">
        <h2>BCA Online</h2>
        <a href="{{ route('cek.saldo') }}">1. Cek Saldo</a>
        <a href="{{ route('transfer.index') }}">2. Transfer Saldo</a>
        <a href="{{ route('transfer.riwayat') }}">3. Riwayat Transfer</a>
        <a href="{{ route('withdrawal.index') }}">4. Penarikan Saldo</a>
        <a href="{{ route('withdrawal.riwayat') }}">5. Riwayat Penarikan</a>
        <a href="{{ route('topup.form') }}">6. Top Up Pulsa</a>
        <a href="{{ route('topup.index') }}">7. Top Up Game</a>
<a href="{{ route('topupgame.riwayat') }}">8. Riwayat Top Up</a>


        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">9. Logout</button>
        </form>
    </div>

    <div class="content">
        <div style="text-align: right; margin-top: 10px;">
            <p id="tanggal" style="margin: 0; font-weight: bold;"></p>
            <p id="clock" style="margin: 0; font-weight: bold;"></p>
        </div>

        <h2>Selamat Datang di Menu Utama</h2>
        <p>Silakan pilih menu dari sidebar di sebelah kiri.</p>
    </div>

    {{-- MODAL INVOICE --}}
    @if(session('invoice'))
        <!-- Modal Bootstrap -->
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

        {{-- Auto-popup on page load --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'));
                invoiceModal.show();
            });
        </script>
    @endif

    {{-- Jam & Tanggal Real-Time --}}
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
        updateWaktu(); // panggil pertama kali
    </script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
