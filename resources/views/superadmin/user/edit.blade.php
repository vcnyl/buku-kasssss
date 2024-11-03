@extends('layouts.superadmin')

@section('title', 'Edit Akun')

@section('content')
<div class="container">
    <h1>Edit Akun</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('superadmin.user.update', $userToEdit->id_user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $userToEdit->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $userToEdit->username) }}" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin" {{ $userToEdit->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $userToEdit->alamat) }}" required>
        </div>

        <div class="mb-3">
            <label for="cabang" class="form-label">Cabang</label>
            <input type="text" class="form-control" id="cabang" name="cabang" value="{{ old('cabang', $userToEdit->cabang) }}" required>
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">No Telepon</label>
            <input type="tel" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $userToEdit->no_hp) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('superadmin.user.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
