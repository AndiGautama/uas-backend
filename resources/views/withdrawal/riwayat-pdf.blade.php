<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
                @if(isset(Auth::user()->role) && Auth::user()->role === 'admin')
                    <th>User</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($withdrawals as $index => $w)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $w->withdrawal_code }}</td>
                    <td>Rp {{ number_format($w->amount, 0, ',', '.') }}</td>
                    <td>{{ $w->status_label }}</td>
                    <td>{{ $w->created_at->format('d/m/Y H:i') }}</td>
                    @if(isset(Auth::user()->role) && Auth::user()->role === 'admin')
                        <td>{{ $w->user->username }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
