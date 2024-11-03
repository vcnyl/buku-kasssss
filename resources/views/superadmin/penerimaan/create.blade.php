@extends('layouts.superadmin')

@section('content')
<div class="container">
    <h1>Tambah Penerimaan</h1>

    <form action="{{ route('superadmin.penerimaan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="id_user">User (Admin)</label>
            <select name="id_user" id="id_user" class="form-control" required>
                @foreach($adminUsers as $user)
                    <option value="{{ $user->id_user }}">{{ $user->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="bukti">Bukti</label>
            <input type="file" name="bukti" id="bukti" class="form-control" required accept=".jpg,.jpeg,.png">
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="datetime-local" name="tanggal" id="tanggal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nominal">Nominal</label>
            <input type="text" name="nominal" id="nominal" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Penerimaan</button>
        <a href="{{ route('superadmin.penerimaan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    // Script untuk format nominal
    document.addEventListener("DOMContentLoaded", function () {
        const nominalInput = document.getElementById('nominal');

        nominalInput.addEventListener('input', function (e) {
            // Hapus semua karakter yang bukan angka
            let value = e.target.value.replace(/\./g, '').replace(/\D/g, '');
            
            // Format angka dengan titik sebagai pemisah ribuan
            if (value) {
                value = Number(value).toLocaleString('id-ID');
            }
            
            e.target.value = value;
        });

        nominalInput.addEventListener('blur', function () {
            // Simpan nilai numerik untuk dikirim ke server
            this.dataset.rawValue = this.value.replace(/\./g, '');
        });

        // Tambahkan event listener untuk form submit
        const form = nominalInput.closest('form');
        form.addEventListener('submit', function () {
            // Saat form disubmit, ganti nilai input nominal dengan yang tanpa titik
            nominalInput.value = nominalInput.dataset.rawValue || '';
        });
    });
</script>
@endsection
