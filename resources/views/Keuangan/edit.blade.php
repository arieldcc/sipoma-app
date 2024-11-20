@extends('layouts.master')

@section('title', 'Edit Data Keuangan')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Data Keuangan</h4>
        </div>
        <div class="card-body">
            <form action="/keuangan/{{ $keuangan->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Pilih Anggota -->
                <div class="form-group">
                    <label for="id_anggota">Pilih Anggota</label>
                    <select name="id_anggota" id="id_anggota" class="form-control @error('id_anggota') is-invalid @enderror" required>
                        <option value="" disabled>Pilih Anggota</option>
                        @foreach($anggota as $person)
                            <option value="{{ $person->id }}" {{ $keuangan->id_anggota == $person->id ? 'selected' : '' }}>
                                {{ $person->no_anggota }} - {{ $person->nama }} ({{ $person->kampus }})
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
                    <input type="text" name="nama_transaksi" id="nama_transaksi" class="form-control @error('nama_transaksi') is-invalid @enderror" required value="{{ old('nama_transaksi', $keuangan->nama_transaksi) }}">
                    @error('nama_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Transaksi -->
                <div class="form-group">
                    <label for="tanggal_transaksi">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" required value="{{ old('tanggal_transaksi', $keuangan->tanggal_transaksi) }}">
                    @error('tanggal_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jenis Transaksi -->
                <div class="form-group">
                    <label for="jenis_transaksi">Jenis Transaksi</label>
                    <select name="jenis_transaksi" id="jenis_transaksi" class="form-control @error('jenis_transaksi') is-invalid @enderror" required>
                        <option value="Pemasukan" {{ old('jenis_transaksi', $keuangan->jenis_transaksi) == 'Pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="Pengeluaran" {{ old('jenis_transaksi', $keuangan->jenis_transaksi) == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    @error('jenis_transaksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" required value="{{ number_format($keuangan->jumlah, 0, ',', '.') }}" oninput="formatRupiah(this)">
                    @error('jumlah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sumber Dana -->
                <div class="form-group">
                    <label for="sumber_dana">Sumber Dana</label>
                    <input type="text" name="sumber_dana" id="sumber_dana" class="form-control @error('sumber_dana') is-invalid @enderror" value="{{ old('sumber_dana', $keuangan->sumber_dana) }}">
                    @error('sumber_dana')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $keuangan->keterangan) }}</textarea>
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

                    <!-- Tampilkan file bukti transaksi langsung jika ada -->
                    @if ($keuangan->bukti_transaksi)
                        <div class="mt-3">
                            <small>File saat ini:</small>
                            @php
                                $fileExtension = pathinfo($keuangan->bukti_transaksi, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                <!-- Jika file adalah gambar, tampilkan sebagai gambar -->
                                <img src="{{ asset('storage/' . $keuangan->bukti_transaksi) }}" alt="Bukti Transaksi" class="img-fluid mt-2" style="max-width: 300px;">
                            @elseif ($fileExtension === 'pdf')
                                <!-- Jika file adalah PDF, tampilkan menggunakan iframe -->
                                <iframe src="{{ asset('storage/' . $keuangan->bukti_transaksi) }}" width="100%" height="400px" class="mt-2"></iframe>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

            // Format input jumlah sebagai Rupiah
            // $('#jumlah').on('input', function() {
            //     const value = $(this).val().replace(/[^\d]/g, '');
            //     $(this).val(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value / 100));
            // });
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
