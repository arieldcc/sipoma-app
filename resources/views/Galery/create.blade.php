@extends('layouts.master')

@section('title', 'Tambah Galeri Kegiatan')

<!-- Select2 CSS -->
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-results__option .activity-info {
            display: flex;
            flex-direction: column;
            font-size: 0.9em;
        }
        .activity-info small {
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Galeri Kegiatan</h4>
        </div>
        <div class="card-body">
            <form action="/galery/store" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Pilih Kegiatan -->
                <div class="form-group">
                    <label for="id_kegiatan">Pilih Kegiatan</label>
                    <select name="id_kegiatan" id="id_kegiatan" class="form-control @error('id_kegiatan') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Kegiatan</option>
                        @foreach($kegiatan as $item)
                            <option value="{{ $item->id }}"
                                    data-nama="{{ $item->nama_kegiatan }}"
                                    data-tempat="{{ $item->tempat }}"
                                    data-waktu="{{ \Carbon\Carbon::parse($item->tanggal_mulai_kegiatan)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($item->tanggal_selesai_kegiatan)->format('d M Y') }}"
                                    data-pelaksana="{{ $item->penyelenggara }}">
                                {{ $item->nama_kegiatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Upload Gambar Galeri -->
                <div class="form-group mt-3">
                    <label for="gambar_galery">Gambar Galeri (jpg, jpeg, png, Max: 1MB per file) bisa lebih dari satu gambar</label>
                    <input type="file" name="gambar_galery[]" id="gambar_galery" class="form-control @error('gambar_galery') is-invalid @enderror" multiple required>
                    @error('gambar_galery.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Simpan Galeri</button>
                    <a href="/galery" class="btn btn-secondary">Batal</a>
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
            $('#id_kegiatan').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Kegiatan",
                allowClear: true,
                templateResult: formatKegiatan,
                templateSelection: formatKegiatanSelection
            });

            function formatKegiatan(kegiatan) {
                if (!kegiatan.id) {
                    return kegiatan.text;
                }

                const nama = $(kegiatan.element).data('nama');
                const tempat = $(kegiatan.element).data('tempat');
                const waktu = $(kegiatan.element).data('waktu');
                const pelaksana = $(kegiatan.element).data('pelaksana');

                return $(`
                    <div class="activity-info">
                        <strong>${nama}</strong>
                        <small>Tempat: ${tempat}</small>
                        <small>Waktu: ${waktu}</small>
                        <small>Pelaksana: ${pelaksana}</small>
                    </div>
                `);
            }

            function formatKegiatanSelection(kegiatan) {
                if (!kegiatan.id) {
                    return kegiatan.text;
                }

                return kegiatan.text; // Tampilkan hanya nama kegiatan saat dipilih
            }
        });
    </script>
@endsection

