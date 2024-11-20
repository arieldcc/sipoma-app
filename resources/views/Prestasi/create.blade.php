@extends('layouts.master')

@section('title', 'Tambah Data Prestasi')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Data Prestasi</h4>
        </div>
        <div class="card-body">
            <form action="/prestasi/store" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Pilih Anggota -->
                <div class="form-group">
                    <label for="id_anggota">Pilih Anggota</label>
                    <select name="id_anggota" id="id_anggota" class="form-control @error('id_anggota') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Anggota</option>
                        @foreach($anggota as $person)
                            <option value="{{ $person->id }}" {{ old('id_anggota') == $person->id ? 'selected' : '' }}>
                                {{ $person->nama }} - {{ $person->no_anggota }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_anggota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Prestasi -->
                <div class="form-group">
                    <label for="nama_prestasi">Nama Prestasi</label>
                    <input type="text" name="nama_prestasi" id="nama_prestasi" class="form-control @error('nama_prestasi') is-invalid @enderror" required value="{{ old('nama_prestasi') }}">
                    @error('nama_prestasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jenis Prestasi -->
                <div class="form-group">
                    <label for="jenis_prestasi">Jenis Prestasi</label>
                    <input type="text" name="jenis_prestasi" id="jenis_prestasi" class="form-control @error('jenis_prestasi') is-invalid @enderror" value="{{ old('jenis_prestasi') }}">
                    @error('jenis_prestasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Prestasi -->
                <div class="form-group">
                    <label for="tanggal">Tanggal Prestasi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required value="{{ old('tanggal') }}">
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan">Deskripsi Prestasi</label>
                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Upload File Prestasi -->
                <div class="form-group">
                    <label for="foto_prestasi">Dokumentasi Prestasi (pdf/jpg/jpeg/png, Max: 1MB)</label>
                    <input type="file" name="foto_prestasi" id="foto_prestasi" class="form-control @error('foto_prestasi') is-invalid @enderror" accept=".pdf, .jpg, .jpeg, .png">
                    @error('foto_prestasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="/prestasi" class="btn btn-secondary">Batal</a>
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
    </script>
@endsection
