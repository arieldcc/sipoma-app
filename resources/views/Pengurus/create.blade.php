@extends('layouts.master')

@section('title', 'Tambah Pengurus')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Tambah Pengurus</h4>
        </div>
        <div class="card-body">
            <form action="/pengurus/store" method="POST">
                @csrf

                <!-- Pilih Anggota -->
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

                <!-- Pilih Periode -->
                <div class="form-group">
                    <label for="id_periode">Pilih Periode</label>
                    <select name="id_periode" id="id_periode" class="form-control @error('id_periode') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Periode</option>
                        @foreach($periode as $item)
                            <option value="{{ $item->id }}"
                                    data-year-start="{{ substr($item->periode, 0, 4) }}"
                                    data-year-end="{{ substr($item->periode, -4) }}"
                                    {{ old('id_periode') == $item->id ? 'selected' : '' }}>
                                {{ $item->periode }} - {{ $item->status_periode === 'A' ? 'Aktif' : 'Non-Aktif' }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_periode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Jabatan -->
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" required value="{{ old('jabatan') }}">
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Periode Mulai -->
                <div class="form-group">
                    <label for="periode_mulai">Periode Mulai</label>
                    <input type="date" name="periode_mulai" id="periode_mulai" class="form-control @error('periode_mulai') is-invalid @enderror" required value="{{ old('periode_mulai') }}">
                    @error('periode_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Periode Selesai -->
                <div class="form-group">
                    <label for="periode_selesai">Periode Selesai</label>
                    <input type="date" name="periode_selesai" id="periode_selesai" class="form-control @error('periode_selesai') is-invalid @enderror" value="{{ old('periode_selesai') }}" readonly>
                    @error('periode_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Pengurus -->
                <div class="form-group">
                    <label for="status_pengurus">Status Pengurus</label>
                    <select name="status_pengurus" id="status_pengurus" class="form-control @error('status_pengurus') is-invalid @enderror" required>
                        <option value="Aktif" {{ old('status_pengurus') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Non-Aktif" {{ old('status_pengurus') == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        <option value="Selesai" {{ old('status_pengurus') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status_pengurus')
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
                    <a href="/pengurus" class="btn btn-secondary">Batal</a>
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

            $('#id_periode').select2({
                theme: 'bootstrap4',
                placeholder: "Pilih Periode",
                allowClear: true
            }).on('change', function() {
                // Ambil tahun mulai dan tahun selesai dari data attribute
                const selectedOption = $(this).find(':selected');
                const yearStart = selectedOption.data('year-start');
                const yearEnd = selectedOption.data('year-end');

                // Jika ada tahun yang dipilih, atur nilai periode mulai dan selesai
                if (yearStart && yearEnd) {
                    $('#periode_mulai').val(`${yearStart}-01-01`); // Set ke 1 Januari dari tahun mulai
                    $('#periode_selesai').val(`${yearEnd}-12-31`); // Set ke 31 Desember dari tahun selesai
                } else {
                    // Kosongkan jika tidak ada yang dipilih
                    $('#periode_mulai').val('');
                    $('#periode_selesai').val('');
                }
            });

            // Format opsi dropdown
            function formatAnggota(anggota) {
                if (!anggota.id) {
                    return anggota.text;
                }

                let noAnggota = $(anggota.element).data('noanggota');
                let nama = $(anggota.element).text();
                let kampus = $(anggota.element).data('kampus');

                var $anggota = $(
                    `<div style="display: flex; flex-direction: column;">
                        <span><strong>${noAnggota}</strong> - ${nama}</span>
                        <small>Kampus: ${kampus}</small>
                    </div>`
                );
                return $anggota;
            }

            // Format opsi terpilih
            function formatSelection(anggota) {
                return anggota.text || 'Pilih Anggota';
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Ambil elemen input
            const periodeMulaiInput = document.getElementById('periode_mulai');
            const periodeSelesaiInput = document.getElementById('periode_selesai');

            // Fungsi untuk menambah satu tahun ke tanggal
            function addOneYear(date) {
                const newDate = new Date(date);
                newDate.setFullYear(newDate.getFullYear() + 1);
                return newDate.toISOString().split('T')[0]; // Format YYYY-MM-DD
            }

            // Fungsi untuk mengurangi satu tahun dari tanggal
            function subtractOneYear(date) {
                const newDate = new Date(date);
                newDate.setFullYear(newDate.getFullYear() - 1);
                return newDate.toISOString().split('T')[0]; // Format YYYY-MM-DD
            }

            // Event listener untuk periode mulai
            periodeMulaiInput.addEventListener('change', function () {
                if (periodeMulaiInput.value && !periodeSelesaiInput.value) {
                    // Jika periode mulai diisi dan periode selesai kosong, otomatis isi periode selesai
                    periodeSelesaiInput.value = addOneYear(periodeMulaiInput.value);
                }
            });

            // Event listener untuk periode selesai
            periodeSelesaiInput.addEventListener('change', function () {
                if (periodeSelesaiInput.value && !periodeMulaiInput.value) {
                    // Jika periode selesai diisi dan periode mulai kosong, otomatis isi periode mulai
                    periodeMulaiInput.value = subtractOneYear(periodeSelesaiInput.value);
                }
            });
        });
    </script>
@endsection
