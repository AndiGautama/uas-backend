@extends('layouts.blank')

@section('content')
<div class="form-container" style="max-width: 600px; margin: 0 auto; padding: 20px; background: #fdfdfd; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

    <h2 style="text-align: center; margin-bottom: 20px;">Form Top Up Game</h2>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('topup.store') }}" method="POST">
        @csrf

        {{-- Pilihan Game --}}
        <label for="game" style="font-weight: bold;">Pilih Game:</label>
        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin: 10px 0;">
            <label style="text-align: center;">
                <input type="radio" name="game" value="Mobile Legends" required style="display: none;">
                <img src="{{ asset('images/mobilelegends.jpeg') }}" alt="Mobile Legends" style="width: 100px; border-radius: 8px; border: 3px solid transparent; cursor: pointer;" onclick="selectGame(this)">
                <div>Mobile Legends</div>
            </label>
            <label style="text-align: center;">
                <input type="radio" name="game" value="PUBG Mobile" style="display: none;">
                <img src="{{ asset('images/pubg.png') }}" alt="PUBG Mobile" style="width: 100px; border-radius: 8px; border: 3px solid transparent; cursor: pointer;" onclick="selectGame(this)">
                <div>PUBG Mobile</div>
            </label>
            <label style="text-align: center;">
                <input type="radio" name="game" value="Free Fire" style="display: none;">
                <img src="{{ asset('images/freefire.png') }}" alt="Free Fire" style="width: 100px; border-radius: 8px; border: 3px solid transparent; cursor: pointer;" onclick="selectGame(this)">
                <div>Free Fire</div>
            </label>
            <label style="text-align: center;">
                <input type="radio" name="game" value="Free Fire" style="display: none;">
                <img src="{{ asset('images/genshin.jpeg') }}" alt="genshin" style="width: 100px; border-radius: 8px; border: 3px solid transparent; cursor: pointer;" onclick="selectGame(this)">
                <div>Genshin impact</div>
            </label>
            
        </div>

        {{-- Jumlah Top Up --}}
        <label for="amount" style="font-weight: bold;">Jumlah Top Up:</label>
        <input type="number" id="amount" name="amount" placeholder="Contoh: 100000" required style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-bottom: 20px;">

        <button type="submit" style="width: 100%; padding: 10px; background-color: #28a745; color: white; font-weight: bold; border: none; border-radius: 5px;">Kirim</button>
    </form>

    <div class="back-link" style="margin-top: 20px; text-align: center;">
        <a href="{{ route('home') }}" style="text-decoration: none; color: #007bff;">← <strong>Kembali ke Menu Utama</strong></a>
    </div>
</div>

{{-- Script untuk highlight gambar terpilih --}}
<script>
    function selectGame(img) {
        document.querySelectorAll('img').forEach(function(i) {
            i.style.border = '3px solid transparent';
        });
        img.style.border = '3px solid #007bff';
        img.previousElementSibling.checked = true;
    }
</script>
@endsection
