@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4 text-primary">Laporan Cabang {{ ucwords($cabang) }}</h3>

    <!-- Filter Form -->
    <div class="bg-light p-4 rounded shadow mb-4 border"> 
        <form method="GET" action="{{ route('admin.laporan') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-4">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-4">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select id="kategori_id" name="kategori_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori->id_kategori }}" {{ request('kategori_id') == $kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                    <div class="text-end mt-3">
                        <a href="{{ route('admin.laporan.download') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success">Download PDF</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary px-4">Filter</button>
            </div>
        </form>
    </div>

    <!-- Report Table -->
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-hover shadow-sm rounded">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Penerimaan (Rp)</th>
                    <th>Pengeluaran (Rp)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $item)
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td class="text-center">{{ $item->kategori ?? '-' }}</td>
                    <td class="text-end">{{ $item->penerimaan !== null ? number_format($item->penerimaan, 2) : '-' }}</td>
                    <td class="text-end">{{ $item->pengeluaran !== null ? number_format($item->pengeluaran, 2) : '-' }}</td>
                    <td class="text-center">{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Tidak ada data untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Summary Section -->
    <h4 class="text-center text-primary mb-4">Summary</h4>
    <div class="row text-center">
        <div class="col-md-3 mb-3">
            <div class="card border-info shadow-lg">
                <div class="card-header bg-info text-white fw-bold">Total Penerimaan</div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($totalPenerimaan, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-danger shadow-lg">
                <div class="card-header bg-danger text-white fw-bold">Total Pengeluaran</div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($totalPengeluaran, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success shadow-lg">
                <div class="card-header bg-success text-white fw-bold">Net Total</div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($totalPenerimaan - $totalPengeluaran, 2) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-primary shadow-lg">
                <div class="card-header bg-primary text-white fw-bold">Overall Total</div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($overallTotal, 2) }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
