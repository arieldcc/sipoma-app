@extends('layouts.master')

@section('title', 'Tambah Struktur Organisasi')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Struktur Organisasi</h4>
        </div>
        <div class="card-body">
            <form action="/organisasi/store" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Pilih Periode -->
                <div class="form-group">
                    <label for="id_periode">Pilih Periode</label>
                    <select name="id_periode" id="id_periode" class="form-control @error('id_periode') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Periode</option>
                        @foreach($periode as $item)
                            <option value="{{ $item->id }}" {{ old('id_periode') == $item->id ? 'selected' : '' }}>
                                {{ $item->periode }} - {{ $item->status_periode === 'A' ? 'Aktif' : 'Non-Aktif' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Upload Gambar Struktur -->
                <div class="form-group mt-3">
                    <label for="gambar_struktur">Upload Gambar Struktur (jpg, jpeg, png - Max: 1MB)</label>
                    <input type="file" name="gambar_struktur" id="gambar_struktur" class="form-control @error('gambar_struktur') is-invalid @enderror" accept=".jpg, .jpeg, .png" required>
                    @error('gambar_struktur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="/organisasi" class="btn btn-secondary">Batal</a>
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
            $('#id_periode').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Periode",
                allowClear: true
            });
        });
    </script>
@endsection
