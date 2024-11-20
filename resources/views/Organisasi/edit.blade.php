@extends('layouts.master')

@section('title', 'Edit Struktur Organisasi')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Struktur Organisasi</h4>
        </div>
        <div class="card-body">
            <form action="/organisasi/{{ $organisasi->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Pilih Periode -->
                <div class="form-group">
                    <label for="id_periode">Pilih Periode</label>
                    <select name="id_periode" id="id_periode" class="form-control @error('id_periode') is-invalid @enderror" required>
                        <option value="" disabled>Pilih Periode</option>
                        @foreach($periode as $item)
                            <option value="{{ $item->id }}" {{ $organisasi->id_periode == $item->id ? 'selected' : '' }}>
                                {{ $item->periode }} - {{ $item->status_periode === 'A' ? 'Aktif' : 'Non-Aktif' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Upload Gambar Struktur Organisasi -->
                <div class="form-group mt-4">
                    <label for="gambar_struktur">Gambar Struktur Organisasi (jpg, jpeg, png, Max: 1MB)</label>
                    <input type="file" name="gambar_struktur" id="gambar_struktur" class="form-control @error('gambar_struktur') is-invalid @enderror" accept=".jpg, .jpeg, .png">
                    @error('gambar_struktur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pratinjau Gambar Struktur Organisasi -->
                <div class="form-group mt-4">
                    <label>Pratinjau Gambar Struktur:</label>
                    <div id="gambarPreview">
                        @if($organisasi->gambar_struktur)
                            <img src="{{ asset('storage/' . $organisasi->gambar_struktur) }}" alt="Gambar Struktur" class="img-fluid mt-2" style="max-width: 400px;">
                        @else
                            <p>Tidak ada gambar struktur yang diunggah.</p>
                        @endif
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

            // Pratinjau gambar ketika ada file baru yang dipilih
            $('#gambar_struktur').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $('#gambarPreview').html(`<img src="${event.target.result}" alt="Gambar Struktur" class="img-fluid mt-2" style="max-width: 400px;">`);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
