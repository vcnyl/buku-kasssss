<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penerimaan dan Pengeluaran</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        h4 {
            color: #555;
            margin: 10px 0;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .summary {
            margin-top: 30px;
            text-align: center;
            font-weight: bold;
        }
        .summary div {
            display: inline-block;
            border: 1px solid #ddd;
            margin: 5px;
            padding: 15px;
            width: calc(25% - 20px);
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .summary strong {
            display: block;
            margin-bottom: 5px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Cabang {{ ucwords($cabang) }}</h2>
        <h4>Filter yang Digunakan</h4>
        <p><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($tanggalMulai)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
        <p><strong>Tanggal Akhir:</strong> {{ \Carbon\Carbon::parse($tanggalAkhir)->locale('id')->isoFormat('D MMMM YYYY') }}</p>
        <p><strong>Kategori:</strong> {{ $kategoriId ? $kategoriList->firstWhere('id_kategori', $kategoriId)->nama_kategori : 'Semua Kategori' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Penerimaan (Rp)</th>
                <th>Pengeluaran (Rp)</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                    <td>{{ $item->kategori ?? '-' }}</td>
                    <td>{{ $item->penerimaan !== null ? number_format($item->penerimaan, 2) : '-' }}</td>
                    <td>{{ $item->pengeluaran !== null ? number_format($item->pengeluaran, 2) : '-' }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h4>Summary</h4>
        <div>
            <strong>Total Penerimaan:</strong> Rp {{ number_format($totalPenerimaan, 2) }}
        </div>
        <div>
            <strong>Total Pengeluaran:</strong> Rp {{ number_format($totalPengeluaran, 2) }}
        </div>
        <div>
            <strong>Net Total:</strong> Rp {{ number_format($totalPenerimaan - $totalPengeluaran, 2) }}
        </div>
        <div>
            <strong>Overall Total:</strong> Rp {{ number_format($overallTotal, 2) }}
        </div>
    </div>
</body>
</html>
