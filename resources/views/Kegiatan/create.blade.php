@extends('layouts.master')

@section('title', 'Tambah Data Kegiatan')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Data Kegiatan</h4>
        </div>
        <div class="card-body">
            <form action="/kegiatan/store" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nama Kegiatan -->
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror" required value="{{ old('nama_kegiatan') }}">
                    @error('nama_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Mulai Kegiatan -->
                <div class="form-group">
                    <label for="tanggal_mulai_kegiatan">Tanggal Mulai Kegiatan</label>
                    <input type="date" name="tanggal_mulai_kegiatan" id="tanggal_mulai_kegiatan" class="form-control @error('tanggal_mulai_kegiatan') is-invalid @enderror" required value="{{ old('tanggal_mulai_kegiatan') }}">
                    @error('tanggal_mulai_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Selesai Kegiatan -->
                <div class="form-group">
                    <label for="tanggal_selesai_kegiatan">Tanggal Selesai Kegiatan</label>
                    <input type="date" name="tanggal_selesai_kegiatan" id="tanggal_selesai_kegiatan" class="form-control @error('tanggal_selesai_kegiatan') is-invalid @enderror" value="{{ old('tanggal_selesai_kegiatan') }}">
                    @error('tanggal_selesai_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tempat -->
                <div class="form-group">
                    <label for="tempat">Tempat</label>
                    <input type="text" name="tempat" id="tempat" class="form-control @error('tempat') is-invalid @enderror" value="{{ old('tempat') }}">
                    @error('tempat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Penyelenggara -->
                <div class="form-group">
                    <label for="penyelenggara">Penyelenggara</label>
                    <input type="text" name="penyelenggara" id="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror" value="{{ old('penyelenggara') }}">
                    @error('penyelenggara')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Kegiatan -->
                <div class="form-group">
                    <label for="status_kegiatan">Status Kegiatan</label>
                    <select name="status_kegiatan" id="status_kegiatan" class="form-control @error('status_kegiatan') is-invalid @enderror" required>
                        <option value="Terjadwal" {{ old('status_kegiatan') == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="Selesai" {{ old('status_kegiatan') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ old('status_kegiatan') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    @error('status_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gambar Kegiatan -->
                <div class="form-group">
                    <label for="gambar_kegiatan">File Kegiatan (File pdf/ gambar: jpg, jpeg, png, Max: 1MB)</label>
                    <input type="file" class="form-control @error('gambar_kegiatan') is-invalid @enderror" id="gambar_kegiatan" name="gambar_kegiatan" accept=".pdf, .jpg, .jpeg, .png">
                    @error('gambar_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="/kegiatan" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
