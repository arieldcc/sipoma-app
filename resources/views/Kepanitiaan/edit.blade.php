@extends('layouts.master')

@section('title', 'Edit Data Kepanitiaan')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Data Kepanitiaan</h4>
        </div>
        <div class="card-body">
            <form action="/kepanitiaan/{{ $kepanitiaan->id }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Pilih Kegiatan -->
                <div class="form-group">
                    <label for="id_kegiatan">Pilih Kegiatan</label>
                    <select name="id_kegiatan" id="id_kegiatan" class="form-control @error('id_kegiatan') is-invalid @enderror" required>
                        <option value="" disabled>Pilih Kegiatan</option>
                        @foreach($kegiatan as $event)
                            <option value="{{ $event->id }}" {{ $kepanitiaan->id_kegiatan == $event->id ? 'selected' : '' }}>
                                {{ $event->nama_kegiatan }} - ({{ \Carbon\Carbon::parse($event->tanggal_mulai_kegiatan)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($event->tanggal_selesai_kegiatan)->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilih Anggota -->
                <div class="form-group">
                    <label for="id_anggota">Pilih Anggota</label>
                    <select name="id_anggota" id="id_anggota" class="form-control @error('id_anggota') is-invalid @enderror" required>
                        <option value="" disabled>Pilih Anggota</option>
                        @foreach($anggota as $person)
                            <option value="{{ $person->id }}" {{ $kepanitiaan->id_anggota == $person->id ? 'selected' : '' }}>
                                {{ $person->no_anggota }} - {{ $person->nama }} ({{ $person->kampus }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_anggota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" required value="{{ old('jabatan', $kepanitiaan->jabatan) }}">
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tugas -->
                <div class="form-group">
                    <label for="tugas">Tugas</label>
                    <textarea name="tugas" id="tugas" class="form-control @error('tugas') is-invalid @enderror">{{ old('tugas', $kepanitiaan->tugas) }}</textarea>
                    @error('tugas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $kepanitiaan->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="/kepanitiaan" class="btn btn-secondary">Batal</a>
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

            $('#id_kegiatan').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Kegiatan",
                allowClear: true
            });
        });
    </script>
@endsection
