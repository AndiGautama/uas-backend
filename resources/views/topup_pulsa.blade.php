<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Top-Up Pulsa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Top-Up Pulsa</h2>

    {{-- Tampilkan error jika saldo tidak cukup --}}
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- Form top-up --}}
    <form action="{{ route('topup.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nomor" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="nomor" name="nomor" required placeholder="08xxxxxxxxxx">
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Pulsa (Rp)</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required placeholder="Contoh: 20000">
        </div>

        <button type="submit" class="btn btn-primary">Top Up</button>
    </form>
</div>

{{-- Modal Invoice (ditampilkan jika session invoice ada) --}}
@if(session('invoice'))
    <!-- Modal (Pop-up invoice langsung tampil) -->
    <div class="modal fade show" tabindex="-1" style="display:block; background-color: rgba(0,0,0,0.5);" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Invoice Top-Up Pulsa</h5>
                </div>
                <div class="modal-body">
                    <p><strong>Nomor Tujuan:</strong> {{ session('invoice')['nomor'] }}</p>
                    <p><strong>Jumlah Pulsa:</strong> Rp {{ number_format(session('invoice')['jumlah'], 0, ',', '.') }}</p>
                    <p><strong>Waktu:</strong> {{ session('invoice')['waktu'] }}</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('topup.form') }}" class="btn btn-secondary">Tutup</a>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
