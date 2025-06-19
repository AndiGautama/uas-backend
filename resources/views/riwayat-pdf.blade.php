<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transfer</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0a3d62;
            padding-bottom: 15px;
        }
        
        .header h2 {
            color: #0a3d62;
            margin: 0;
            font-size: 18px;
        }
        
        .info {
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .transfer-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .transfer-table th {
            background-color: #0a3d62;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        
        .transfer-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        .transfer-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .amount {
            text-align: right;
            font-weight: bold;
        }
        
        .empty {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #0a3d62;
        }
        
        .summary-item {
            margin: 5px 0;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Riwayat Transfer</h2>
        <p>Laporan per tanggal: {{ date('d F Y H:i') }}</p>
    </div>

    @if($transfers->count() > 0)
        <table class="transfer-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Dari</th>
                    <th>Kepada</th>
                    <th class="amount">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transfers as $index => $transfer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $transfer->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $transfer->fromUser->username }}</td>
                        <td>{{ $transfer->toUser->username }}</td>
                        <td class="amount">{{ number_format($transfer->amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="summary">
            <div class="summary-item"><strong>Total Transaksi:</strong> {{ $transfers->count() }} transaksi</div>
            <div class="summary-item"><strong>Total Nilai:</strong> Rp {{ number_format($transfers->sum('amount'), 0, ',', '.') }}</div>
        </div>
    @else
        <div class="empty">
            Tidak ada riwayat transfer yang ditemukan.
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis pada {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>