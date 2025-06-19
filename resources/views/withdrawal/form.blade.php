<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Tanpa Kartu</title>
    <link rel="stylesheet" href="{{ asset('css/withdrawal.css') }}">
</head>
<body>
    <div class="container">
        <h2>Transaksi Tanpa Kartu</h2>
        <p class="subtitle">Tarik saldo Anda menjadi uang tunai</p>

        <div class="balance-info">
            <h3>Saldo Anda: <span class="balance">Rp {{ number_format($user->saldo, 0, ',', '.') }}</span></h3>
        </div>

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('withdrawal.store') }}" class="withdrawal-form">
            @csrf
            
            <div class="amount-section">
                <label>Pilih Nominal Penarikan:</label>
                
                <div class="quick-amounts">
                    <button type="button" class="amount-btn" data-amount="50000">
                        Rp 50.000
                    </button>
                    <button type="button" class="amount-btn" data-amount="100000">
                        Rp 100.000
                    </button>
                    <button type="button" class="amount-btn" data-amount="200000">
                        Rp 200.000
                    </button>
                </div>

                <div class="custom-amount">
                    <label for="amount">Atau masukkan nominal lain:</label>
                    <input type="number" 
                           id="amount" 
                           name="amount" 
                           min="50000" 
                           max="{{ $user->saldo }}"
                           placeholder="Minimal Rp 50.000"
                           value="{{ old('amount') }}">
                    <small>Maksimal: Rp {{ number_format($user->saldo, 0, ',', '.') }}</small>
                </div>
            </div>

            <div class="info-section">
                <div class="info-box">
                    <h4>⚠️ Informasi Penting:</h4>
                    <ul>
                        <li>Minimal penarikan: Rp 50.000</li>
                        <li>Maksimal penarikan per hari: Rp 2.000.000</li>
                        <li>Kode penarikan akan diberikan setelah transaksi</li>
                        <li>Tunjukkan kode penarikan ke petugas untuk mengambil uang</li>
                        <li>Proses penarikan membutuhkan waktu 1-5 menit</li>
                    </ul>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="submit-btn">
                    💳 Proses Penarikan
                </button>
                <a href="{{ route('home') }}" class="back-btn">
                    ← Kembali ke Menu
                </a>
            </div>
        </form>

        <div class="links">
            <a href="{{ route('withdrawal.riwayat') }}" class="link">📋 Riwayat Penarikan</a>
        </div>
    </div>

    <script>
        // JavaScript untuk quick amount buttons
        document.querySelectorAll('.amount-btn').forEach(button => {
            button.addEventListener('click', function() {
                const amount = this.dataset.amount;
                const input = document.getElementById('amount');
                input.value = amount;
                
                // Remove active class from all buttons
                document.querySelectorAll('.amount-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
            });
        });

        // Format input number
        document.getElementById('amount').addEventListener('input', function() {
            // Remove active class from all quick buttons when typing
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.classList.remove('active');
            });
        });
    </script>
</body>
</html>