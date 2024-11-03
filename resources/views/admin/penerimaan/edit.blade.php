@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Penerimaan</h1>

    <form action="{{ route('admin.penerimaan.update', $penerimaan->id_penerimaan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="bukti">Bukti</label>
            <input type="file" name="bukti" id="bukti" class="form-control" accept=".jpg,.jpeg,.png">
            <small>Biarkan kosong jika tidak ingin mengubah bukti</small>
            @if($penerimaan->bukti)
                <img src="{{ asset('storage/bukti/' . $penerimaan->bukti) }}" alt="Bukti" width="100" class="mt-2">
            @endif
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="datetime-local" name="tanggal" id="tanggal" class="form-control" value="{{ \Carbon\Carbon::parse($penerimaan->tanggal)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label for="nominal">Nominal</label>
            <input type="text" name="nominal" id="nominal" class="form-control" value="{{ number_format($penerimaan->nominal, 0, ',', '.') }}" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control">{{ $penerimaan->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Penerimaan</button>
        <a href="{{ route('admin.penerimaan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    // Script untuk format nominal
    document.addEventListener("DOMContentLoaded", function () {
        const nominalInput = document.getElementById('nominal');

        // Inisialisasi nominalInput dengan angka tanpa format
        const rawValue = "{{ $penerimaan->nominal }}"; // Ambil nominal asli
        nominalInput.dataset.rawValue = rawValue;

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
