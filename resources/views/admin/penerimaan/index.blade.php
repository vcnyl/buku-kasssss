@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Penerimaan</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.penerimaan.create') }}" class="btn btn-primary mb-3">Tambah Penerimaan</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Penerimaan</th>
                <th>Bukti</th>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penerimaan as $item)
                <tr>
                    <td>{{ $item->id_penerimaan }}</td>
                    <td><img src="{{ asset('storage/bukti/' . $item->bukti) }}" alt="Bukti" width="100"></td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ number_format($item->nominal) }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <a href="{{ route('admin.penerimaan.edit', $item->id_penerimaan) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.penerimaan.destroy', $item->id_penerimaan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
