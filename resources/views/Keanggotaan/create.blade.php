@extends('layouts.master')

@section('title', 'Tambah Keanggotaan')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Keanggotaan</h4>
        </div>
        <div class="card-body">
            <form action="/keanggotaan/store" method="POST">
                @csrf

                <div class="form-group">
                    <label for="id_anggota">Pilih Anggota</label>
                    <select name="id_anggota" id="id_anggota" class="form-control @error('id_anggota') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Anggota</option>
                        @foreach($anggota as $person)
                            <option value="{{ $person->id }}"
                                    data-noanggota="{{ $person->no_anggota }}"
                                    data-kampus="{{ $person->kampus }}"
                                    {{ old('id_anggota') == $person->id ? 'selected' : '' }}>
                                {{ $person->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_anggota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Keanggotaan -->
                <div class="form-group">
                    <label for="status_keanggotaan">Status Keanggotaan</label>
                    <select name="status_keanggotaan" id="status_keanggotaan" class="form-control @error('status_keanggotaan') is-invalid @enderror" required>
                        <option value="Aktif" {{ old('status_keanggotaan') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ old('status_keanggotaan') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        <option value="Alumni" {{ old('status_keanggotaan') == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                    </select>
                    @error('status_keanggotaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Bergabung -->
                <div class="form-group">
                    <label for="tanggal_bergabung">Tanggal Bergabung</label>
                    <input type="date" name="tanggal_bergabung" id="tanggal_bergabung" class="form-control @error('tanggal_bergabung') is-invalid @enderror" required value="{{ old('tanggal_bergabung') }}">
                    @error('tanggal_bergabung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Keluar -->
                <div class="form-group">
                    <label for="tanggal_keluar">Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control @error('tanggal_keluar') is-invalid @enderror" value="{{ old('tanggal_keluar') }}">
                    @error('tanggal_keluar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="/keanggotaan" class="btn btn-secondary">Batal</a>
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
                allowClear: true,
                templateResult: formatAnggota, // Menampilkan opsi dropdown dengan format khusus
                templateSelection: formatSelection // Menampilkan opsi terpilih dengan format khusus
            });

            // Format untuk opsi dropdown
            function formatAnggota(anggota) {
                if (!anggota.id) {
                    return anggota.text;
                }

                let kampus = $(anggota.element).data('kampus');
                let noAnggota = $(anggota.element).data('noanggota');
                let nama = $(anggota.element).text();

                var $anggota = $(`
                    <div style="display: flex; flex-direction: column;">
                        <span><strong>${noAnggota}</strong> - ${nama}</span>
                        <small>Kampus: ${kampus}</small>
                    </div>
                `);
                return $anggota;
            }

            // Format untuk opsi yang dipilih
            function formatSelection(anggota) {
                return anggota.text || 'Pilih Anggota';
            }
        });
    </script>
@endsection

