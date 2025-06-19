@extends('layouts.blank')


@section('content')
<div class="form-container">
    <h2>Form Top Up Game</h2>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('topup.store') }}" method="POST">
        @csrf

        <label for="game">Nama Game:</label>
        <input type="text" id="game" name="game" placeholder="Contoh: Mobile Legends" required>

        <label for="amount">Jumlah Top Up:</label>
        <input type="number" id="amount" name="amount" placeholder="Contoh: 100000" required>

        <button type="submit">Kirim</button>
    </form>

    <div class="back-link">
        <a href="{{ route('home') }}">← <strong>Kembali ke Menu Utama</strong></a>
    </div>
    
</div>
@endsection