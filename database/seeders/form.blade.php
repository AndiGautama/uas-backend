<h2>Form Transfer Saldo</h2>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<form method="POST" action="{{ route('transfer.store') }}">
    @csrf
    <label>Username Tujuan:</label><br>
    <input type="text" name="username_tujuan" required><br><br>

    <label>Jumlah Transfer:</label><br>
    <input type="number" name="jumlah" min="1" required><br><br>

    <button type="submit">Kirim</button>
</form>

<br>
<a href="{{ route('home') }}">← Kembali ke menu utama</a>
