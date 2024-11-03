@extends('layouts.superadmin')

@section('content')
<div class="container">
    <h1 class="title">Laporan Keuangan</h1>
    <form action="{{ route('superadmin.laporan') }}" method="GET" class="filter-form">
        <div class="form-group">
            <label for="tanggal_mulai">Tanggal Mulai:</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
        </div>
        <div class="form-group">
            <label for="tanggal_akhir">Tanggal Akhir:</label>
            <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
        </div>
        <div class="form-group">
            <label for="cabang_id">Cabang:</label>
            <select name="cabang_id" id="cabang_id">
                <option value="">Semua Cabang</option>
                @foreach($cabangList as $cabang)
                    <option value="{{ $cabang->cabang }}" {{ request('cabang_id') == $cabang->cabang ? 'selected' : '' }}>
                        {{ $cabang->cabang }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="kategori_id">Kategori:</label>
            <select name="kategori_id" id="kategori_id">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ request('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn">Filter</button>
        <a href="{{ route('superadmin.laporan') }}" class="btn reset">Reset</a>
    </form>

    <table class="report-table">
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

    <a href="{{ route('superadmin.laporan.downloadPDF', ['tanggal_mulai' => request('tanggal_mulai'), 'tanggal_akhir' => request('tanggal_akhir'), 'cabang_id' => request('cabang_id'), 'kategori_id' => request('kategori_id')]) }}" class="btn download">Download PDF</a>
</div>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
        color: #333;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .title {
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }
    .filter-form {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
    }
    label {
        margin-bottom: 5px;
        font-weight: bold;
    }
    input[type="date"], select {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .btn {
        padding: 10px 15px;
        background-color: #3498db;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
    }
    .btn.reset {
        background-color: #e74c3c;
    }
    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
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
    .download {
        margin-top: 20px;
        display: block;
        text-align: center;
    }
</style>
@endsection
