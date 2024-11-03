@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Pengeluaran</h1>

    <form action="{{ route('admin.pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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

        <div class="form-group">
            <label for="id_kategori">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Pengeluaran</button>
        <a href="{{ route('admin.pengeluaran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>



<script>
    // Script untuk format nominal
    document.addEventListener("DOMContentLoaded", function() {
        const nominalInput = document.getElementById('nominal');

        nominalInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\./g, '').replace(/\D/g, '');
            if (value) {
                value = Number(value).toLocaleString('id-ID');
            }
            e.target.value = value;
        });

        nominalInput.addEventListener('blur', function() {
            this.dataset.rawValue = this.value.replace(/\./g, '');
        });

        const form = nominalInput.closest('form');
        form.addEventListener('submit', function() {
            nominalInput.value = nominalInput.dataset.rawValue || '';
        });
    });
</script>
@endsection