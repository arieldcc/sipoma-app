@extends('layouts.master')

@section('title', 'Tambah Data Keuangan')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Data Keuangan</h4>
        </div>
        <div class="card-body">
            <form action="/keuangan/store" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Pilih Anggota -->
                <div class="form-group">
                    <label for="id_anggota">Pilih Anggota</label>
                    <select name="id_anggota" id="id_anggota" class="form-control @error('id_anggota') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Anggota</option>
                        @foreach($anggota as $person)
                            <option value="{{ $person->id }}" {{ old('id_anggota') == $person->id ? 'selected' : '' }}>
                                {{ $person->nama }} ({{ $person->no_anggota }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_anggota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Transaksi -->
                <div class="form-group">
                    <label for="nama_transaksi">Nama Transaksi</label>
                    <input type="text" name="nama_transaksi" id="nama_transaksi" class="form-control @error('nama_transaksi') is-invalid @enderror" required value="{{ old('nama_transaksi') }}">
                    @error('nama_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Transaksi -->
                <div class="form-group">
                    <label for="tanggal_transaksi">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" required value="{{ old('tanggal_transaksi') }}">
                    @error('tanggal_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jenis Transaksi -->
                <div class="form-group">
                    <label for="jenis_transaksi">Jenis Transaksi</label>
                    <select name="jenis_transaksi" id="jenis_transaksi" class="form-control @error('jenis_transaksi') is-invalid @enderror" required>
                        <option value="Pemasukan" {{ old('jenis_transaksi') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="Pengeluaran" {{ old('jenis_transaksi') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('jenis_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" required value="{{ old('jumlah') }}" oninput="formatRupiah(this)">
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sumber Dana -->
                <div class="form-group">
                    <label for="sumber_dana">Sumber Dana</label>
                    <input type="text" name="sumber_dana" id="sumber_dana" class="form-control @error('sumber_dana') is-invalid @enderror" value="{{ old('sumber_dana') }}">
                    @error('sumber_dana')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bukti Transaksi -->
                <div class="form-group">
                    <label for="bukti_transaksi">Bukti Transaksi (pdf/jpg/jpeg/png, Max: 1MB)</label>
                    <input type="file" name="bukti_transaksi" id="bukti_transaksi" class="form-control @error('bukti_transaksi') is-invalid @enderror" accept=".pdf, .jpg, .jpeg, .png">
                    @error('bukti_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="/keuangan" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#id_anggota').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Anggota",
                allowClear: true
            });
        });

        function formatRupiah(input) {
            let angka = input.value.replace(/[^,\d]/g, ''); // Hanya mengambil angka
            if (angka) {
                let sisa = angka.length % 3;
                let rupiah = angka.substr(0, sisa);
                let ribuan = angka.substr(sisa).match(/\d{3}/g);
                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                input.value = 'Rp ' + rupiah;
            } else {
                input.value = ''; // Bersihkan jika input kosong
            }
        }
    </script>
@endsection
