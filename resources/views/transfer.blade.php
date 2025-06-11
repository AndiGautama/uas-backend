<h2>Transfer Saldo</h2>

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if (session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('transfer.store') }}">
    @csrf
    <label>Username Tujuan:</label>
    <input type="text" name="tujuan" required>
    <br>

    <label>Jumlah Saldo:</label>
    <input type="number" name="jumlah" required min="1">
    <br>

    <button type="submit">Kirim</button>
</form>
