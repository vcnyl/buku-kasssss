@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Dashboard Admin</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-header">Total Penerimaan</div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($totalPenerimaan ?? 0, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white mb-3">
                <div class="card-header">Total Pengeluaran</div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($totalPengeluaran ?? 0, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white mb-3">
                <div class="card-header">Saldo</div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($saldo ?? 0, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
