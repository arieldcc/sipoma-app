@extends('layouts.master')

@section('title', 'Edit Keanggotaan')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Keanggotaan</h4>
        </div>
        <div class="card-body">
            <form action="/keanggotaan/{{ $keanggotaan->id }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Data Anggota (Read-Only) -->
                <fieldset class="border p-3 mb-4">
                    <legend class="w-auto px-2">Data Anggota</legend>

                    <div class="form-group">
                        <label for="nama">Nama Anggota</label>
                        <input type="text" id="nama" class="form-control" value="{{ $keanggotaan->anggota->nama }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="no_anggota">Nomor Anggota</label>
                        <input type="text" id="no_anggota" class="form-control" value="{{ $keanggotaan->anggota->no_anggota }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="kampus">Kampus</label>
                        <input type="text" id="kampus" class="form-control" value="{{ $keanggotaan->anggota->kampus }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="program_studi">Program Studi</label>
                        <input type="text" id="program_studi" class="form-control" value="{{ $keanggotaan->anggota->program_studi }}" readonly>
                    </div>
                </fieldset>

                <!-- Data Keanggotaan -->
                <fieldset class="border p-3 mb-4">
                    <legend class="w-auto px-2">Data Keanggotaan</legend>

                    <!-- Status Keanggotaan -->
                    <div class="form-group">
                        <label for="status_keanggotaan">Status Keanggotaan</label>
                        <select name="status_keanggotaan" id="status_keanggotaan" class="form-control @error('status_keanggotaan') is-invalid @enderror" required>
                            <option value="Aktif" {{ $keanggotaan->status_keanggotaan == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Non-Aktif" {{ $keanggotaan->status_keanggotaan == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                            <option value="Alumni" {{ $keanggotaan->status_keanggotaan == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                        </select>
                        @error('status_keanggotaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Bergabung -->
                    <div class="form-group">
                        <label for="tanggal_bergabung">Tanggal Bergabung</label>
                        <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" class="form-control @error('tanggal_bergabung') is-invalid @enderror" required value="{{ $keanggotaan->tanggal_bergabung }}">
                        @error('tanggal_bergabung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Keluar -->
                    <div class="form-group">
                        <label for="tanggal_keluar">Tanggal Keluar</label>
                        <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ $keanggotaan->tanggal_keluar }}">
                        @error('tanggal_keluar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ $keanggotaan->keterangan }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>

                <!-- Tombol Simpan -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="/keanggotaan" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
