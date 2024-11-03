@extends('layouts.superadmin')

@section('content')
<div class="container">
    <h1>Daftar Akun</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('superadmin.user.create') }}" class="btn btn-primary mb-3">Tambah User</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Cabang</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Aksi</th> <!-- Kolom untuk aksi -->
            </tr>
        </thead>
        <tbody>
            @foreach($users as $userItem)
                <tr>
                    <td>{{ $userItem->id_user }}</td>
                    <td>{{ $userItem->username }}</td>
                    <td>{{ $userItem->nama }}</td>
                    <td>{{ $userItem->role }}</td>
                    <td>{{ $userItem->cabang }}</td>
                    <td>{{ $userItem->alamat }}</td>
                    <td>{{ $userItem->no_hp }}</td>
                    <td>
                        <a href="{{ route('superadmin.user.edit', $userItem->id_user) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('superadmin.user.destroy', $userItem->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
