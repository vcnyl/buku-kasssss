@extends('layouts.admin')

@section('title', 'Edit Profile Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Profile Admin</h1>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="foto">Foto Profil</label>
            <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.jpeg,.png">
            <small>Biarkan kosong jika tidak ingin mengubah foto</small>
            @if($user->foto)
                <img src="{{ asset('storage/profile_pictures/' . $user->foto) }}" class="card-img-top rounded-circle" alt="Foto Profil" style="height: 200px; object-fit: cover;" class="mt-2">
            @endif
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $user->alamat) }}">
        </div>

        <div class="form-group">
            <label for="no_hp">No HP</label>
            <input type="text" name="no_hp" id="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
