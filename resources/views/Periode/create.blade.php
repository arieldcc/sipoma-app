@extends('layouts.master')

@section('title', 'Tambah Data Periode')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Data Periode</h4>
        </div>
        <div class="card-body">
            <form action="/periode/store" method="POST">
                @csrf

                <!-- Input Periode -->
                <div class="form-group">
                    <label for="periode">Periode</label>
                    <input type="text" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" required value="{{ old('periode') }}" placeholder="Contoh: 2023/2024">
                    @error('periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Periode -->
                {{-- <div class="form-group">
                    <label for="status_periode">Status Periode</label>
                    <select name="status_periode" id="status_periode" class="form-control @error('status_periode') is-invalid @enderror" required>
                        <option value="A" {{ old('status_periode') == 'A' ? 'selected' : '' }}>Aktif</option>
                        <option value="N" {{ old('status_periode') == 'N' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <!-- Tombol Simpan dan Batal -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="/periode" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
