@extends('layouts.plain')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/topup.css') }}">
</head>

<div class="riwayat-container">
    <div class="riwayat-header">
        <h4>Riwayat Top Up Game</h4>
    </div>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Riwayat --}}
    @if($topups->count())
        <table class="table-topup">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Game</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topups as $topup)
                    <tr>
                        <td>{{ $topup->id }}</td>
                        <td>{{ $topup->game }}</td>
                        <td>Rp {{ number_format($topup->amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $topup->status === 'pending' ? 'warning' : 'success' }}">
                                {{ ucfirst($topup->status) }}
                            </span>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($topup->created_at)->setTimezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning">Belum ada data top up game.</div>
    @endif

    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">← Kembali ke Menu Utama</a>
</div>
@endsection
