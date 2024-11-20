@extends('layouts.master')

@section('title', 'Edit Data Periode')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Data Periode</h4>
        </div>
        <div class="card-body">
            <form action="/periode/{{ $periode->id }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Input Periode -->
                <div class="form-group">
                    <label for="periode">Periode</label>
                    <input type="text" name="periode" id="periode" class="form-control @error('periode') is-invalid @enderror" required value="{{ old('periode', $periode->periode) }}">
                    @error('periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="/periode" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
