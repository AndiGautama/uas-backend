@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Riwayat Transaksi Pulsa</h2>

    @if($transaksi->isEmpty())
        <div class="alert alert-info">
            Belum ada transaksi pulsa yang dilakukan.
        </div>
    @else
        <table class="table table-bordered mt-3">
            <thead class="table-secondary">
                <tr>
                    <th>No</th>
                    <th>Nomor HP Tujuan</th>
                    <th>Jumlah Pulsa</th>
                    <th>Tanggal & Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->nomor }}</td>
                        <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
