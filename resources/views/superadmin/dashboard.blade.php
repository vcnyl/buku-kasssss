@extends('layouts.superadmin')

@section('content')
<div class="container">
    <h1 class="my-4">Dashboard Super Admin</h1>
    <div class="row">
        @foreach ($data as $item)
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">{{ $item['admin']->nama }}</h5> <!-- Menampilkan nama admin -->
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted">Cabang: {{ $item['admin']->cabang }}</h6>
                    <h6 class="card-subtitle mb-2 text-muted">No HP: {{ $item['admin']->no_hp }}</h6>
                    <hr>
                    <h5>Total Penerimaan: <span class="text-success">Rp {{ number_format($item['totalPenerimaan'], 2, ',', '.') }}</span></h5>
                    <h5>Total Pengeluaran: <span class="text-danger">Rp {{ number_format($item['totalPengeluaran'], 2, ',', '.') }}</span></h5>
                    <h5>Saldo: <span class="text-info">Rp {{ number_format($item['saldo'], 2, ',', '.') }}</span></h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
