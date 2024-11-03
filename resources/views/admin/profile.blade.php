@extends('layouts.admin')

@section('title', 'Profile Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Profile Admin</h1>
    <div class="card text-center" style="width: 20rem; margin: auto;">
        <img src="{{ asset('storage/' . $user->foto) }}" class="card-img-top rounded-circle" alt="Foto Profil" style="height: 200px; object-fit: cover;">
        
        <div class="card-body">
            <h5 class="card-title">{{ $user->nama }}</h5>
            <p class="card-text"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            <p class="card-text"><strong>Username:</strong> {{ $user->username }}</p>
            <p class="card-text"><strong>Alamat:</strong> {{ $user->alamat }}</p>
            <p class="card-text"><strong>No HP:</strong> {{ $user->no_hp }}</p>
            <p class="card-text"><strong>Cabang:</strong> {{ $user->cabang }}</p>
            <a href="{{ url('admin/dashboard') }}" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
            <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning mt-3">Edit Profile</a> <!-- Tambahkan tombol Edit Profile -->
        </div>
    </div>
</div>
@endsection
