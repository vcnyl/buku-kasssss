@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Daftar Pengeluaran</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.pengeluaran.create') }}" class="btn btn-primary mb-3">Tambah Pengeluaran</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Pengeluaran</th>
                <th>Nama Kategori</th>
                <th>Bukti</th>
                <th>Tanggal</th>
                <th>Nominal</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluaran as $item)
                <tr>
                    <td>{{ $item->id_pengeluaran }}</td>
                    <td>{{ $item->kategori->nama_kategori }}</td>
                    <td><img src="{{ asset('storage/bukti/' . $item->bukti) }}" alt="Bukti" width="100"></td>
                    <td>{{ $item->tanggal }}</td>
                    <td>Rp {{ number_format($item->nominal, 2, ',', '.') }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <a href="{{ route('admin.pengeluaran.edit', $item->id_pengeluaran) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.pengeluaran.destroy', $item->id_pengeluaran) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
