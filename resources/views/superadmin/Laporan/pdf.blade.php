@extends('layouts.superadmin')

@section('content')
<form action="{{ route('superadmin.laporan') }}" method="GET">
    <div>
        <label for="tanggal_hari">Hari:</label>
        <select name="tanggal_hari" id="tanggal_hari">
            <option value="">Semua Hari</option>
            @for ($i = 1; $i <= 31; $i++)
                <option value="{{ $i }}" {{ request('tanggal_hari') == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>
    </div>
    <div>
        <label for="tanggal_bulan">Bulan:</label>
        <select name="tanggal_bulan" id="tanggal_bulan">
            <option value="">Semua Bulan</option>
            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $bulan)
                <option value="{{ $index + 1 }}" {{ request('tanggal_bulan') == ($index + 1) ? 'selected' : '' }}>
                    {{ $bulan }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="tanggal_tahun">Tahun:</label>
        <select name="tanggal_tahun" id="tanggal_tahun">
            <option value="">Semua Tahun</option>
            @for ($year = date('Y'); $year >= 2000; $year--)
                <option value="{{ $year }}" {{ request('tanggal_tahun') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>
    </div>
    <button type="submit">Filter</button>
    <a href="{{ route('superadmin.laporan') }}">Reset</a>
</form>

<div style="margin-top: 20px; margin-bottom: 20px;">
    <a href="{{ route('superadmin.laporan.downloadPDF', ['tanggal_hari' => request('tanggal_hari'), 'tanggal_bulan' => request('tanggal_bulan'), 'tanggal_tahun' => request('tanggal_tahun')]) }}" 
       class="btn btn-primary">
        Download PDF
    </a>
</div>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Penerimaan</th>
            <th>Pengeluaran</th>
            <th>Keterangan</th>
            <th>Cabang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $item)
            <tr>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ number_format($item->penerimaan, 0, ',', '.') }}</td>
                <td>{{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->cabang }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="totals">
    <strong>Total Penerimaan: </strong>{{ number_format($totalPenerimaan, 0, ',', '.') }}<br>
    <strong>Total Pengeluaran: </strong>{{ number_format($totalPengeluaran, 0, ',', '.') }}<br>
    <strong>Net Total: </strong>{{ number_format($netTotal, 0, ',', '.') }}
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        h3 {
            text-align: center;
            color: #34495e;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        .totals {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Laporan Keuangan</h1>
<h3>Periode: {{ $tanggalMulai }} hingga {{ $tanggalAkhir }}</h3>
<h3>Cabang: {{ $cabangId }}</h3>
<h3>Kategori: {{ $kategoriName }}</h3>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Penerimaan</th>
            <th>Pengeluaran</th>
            <th>Keterangan</th>
            <th>Cabang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporan as $item)
            <tr>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ number_format($item->penerimaan, 0, ',', '.') }}</td>
                <td>{{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->cabang }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="totals">
    <strong>Total Penerimaan: </strong>{{ number_format($totalPenerimaan, 0, ',', '.') }}<br>
    <strong>Total Pengeluaran: </strong>{{ number_format($totalPengeluaran, 0, ',', '.') }}<br>
    <strong>Net Total: </strong>{{ number_format($netTotal, 0, ',', '.') }}
</div>

</body>
</html>
