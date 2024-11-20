@extends('layouts.master')

@section('title', 'Edit Data Anggota')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Data Anggota</h4>
        </div>
        <div class="card-body">
            <form action="/anggota/{{ $anggota->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Data Pribadi -->
                <fieldset class="border p-3 mb-4">
                    <legend class="w-auto px-2">Data Pribadi</legend>

                    <div class="form-group">
                        <label for="no_anggota">No Anggota</label>
                        <input type="text" name="no_anggota" id="no_anggota" class="form-control @error('no_anggota') is-invalid @enderror" required value="{{ old('no_anggota', $anggota->no_anggota) }}">
                        @error('no_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" required value="{{ old('nama', $anggota->nama) }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="j_kel">Jenis Kelamin</label>
                        <select name="j_kel" id="j_kel" class="form-control @error('j_kel') is-invalid @enderror" required>
                            <option value="l" {{ old('j_kel', $anggota->j_kel) == 'l' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="p" {{ old('j_kel', $anggota->j_kel) == 'p' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('j_kel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror" required>
                            <option value="islam" {{ old('agama', $anggota->agama) == 'islam' ? 'selected' : '' }}>Islam</option>
                            <option value="kristen" {{ old('agama', $anggota->agama) == 'kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="katolik" {{ old('agama', $anggota->agama) == 'katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="hindu" {{ old('agama', $anggota->agama) == 'hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="budha" {{ old('agama', $anggota->agama) == 'budha' ? 'selected' : '' }}>Budha</option>
                            <option value="konghucu" {{ old('agama', $anggota->agama) == 'konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" required value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}">
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email', $anggota->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="no_telepon">No Telepon</label>
                        <input type="text" name="no_telepon" id="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon', $anggota->no_telepon) }}">
                        @error('no_telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @php
                        $currentYear = date('Y');
                        $years = range($currentYear - 10, $currentYear);
                    @endphp

                    <div class="form-group">
                        <label for="angkatan_anggota">Tahun Angkatan Sebagai Anggota Organisasi</label>
                        <select name="angkatan_anggota" id="angkatan_anggota" class="form-control @error('angkatan_anggota') is-invalid @enderror" required>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ old('angkatan_anggota', $anggota->angkatan_anggota) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('angkatan_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="foto_anggota">Foto Anggota (File Gambar: jpg, jpeg, png, Max: 1MB)</label>

                        <!-- Cek apakah ada foto anggota yang tersimpan -->
                        @if ($anggota->foto_anggota)
                            <div class="mb-3">
                                <p>Foto Saat Ini:</p>
                                <img src="{{ asset('storage/' . $anggota->foto_anggota) }}" alt="Foto Anggota" style="max-width: 200px; max-height: 200px; object-fit: cover; border: 1px solid #ddd; padding: 5px;">
                            </div>
                        @endif

                        <!-- Input untuk upload foto baru -->
                        <input type="file" class="form-control @error('foto_anggota') is-invalid @enderror" id="foto_anggota" name="foto_anggota" accept=".jpg, .jpeg, .png">
                        @error('foto_anggota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </fieldset>

                <!-- Data Alamat -->
                <fieldset class="border p-3 mb-4">
                    <legend class="w-auto px-2">Data Alamat</legend>

                    <div class="form-group">
                        <label for="alamat_jalan">Alamat Jalan</label>
                        <input type="text" name="alamat_jalan" id="alamat_jalan" class="form-control @error('alamat_jalan') is-invalid @enderror" value="{{ old('alamat_jalan', $anggota->alamat_jalan) }}">
                        @error('alamat_jalan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat_kelurahan">Alamat Kelurahan</label>
                        <input type="text" name="alamat_kelurahan" id="alamat_kelurahan" class="form-control @error('alamat_kelurahan') is-invalid @enderror" value="{{ old('alamat_kelurahan', $anggota->alamat_kelurahan) }}">
                        @error('alamat_kelurahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat_kecamatan">Alamat Kecamatan</label>
                        <input type="text" name="alamat_kecamatan" id="alamat_kecamatan" class="form-control @error('alamat_kecamatan') is-invalid @enderror" value="{{ old('alamat_kecamatan', $anggota->alamat_kecamatan) }}">
                        @error('alamat_kecamatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat_kota">Alamat Kota</label>
                        <input type="text" name="alamat_kota" id="alamat_kota" class="form-control @error('alamat_kota') is-invalid @enderror" value="{{ old('alamat_kota', $anggota->alamat_kota) }}">
                        @error('alamat_kota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="alamat_provinsi">Alamat Provinsi</label>
                        <input type="text" name="alamat_provinsi" id="alamat_provinsi" class="form-control @error('alamat_provinsi') is-invalid @enderror" value="{{ old('alamat_provinsi', $anggota->alamat_provinsi) }}">
                        @error('alamat_provinsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kode_pos">Kode Pos</label>
                        <input type="text" name="kode_pos" id="kode_pos" class="form-control @error('kode_pos') is-invalid @enderror" value="{{ old('kode_pos', $anggota->kode_pos) }}">
                        @error('kode_pos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>

                <!-- Data Kampus -->
                <fieldset class="border p-3 mb-4">
                    <legend class="w-auto px-2">Data Kampus</legend>

                    <div class="form-group">
                        <label for="kampus">Kampus</label>
                        <input type="text" name="kampus" id="kampus" class="form-control @error('kampus') is-invalid @enderror" required value="{{ old('kampus', $anggota->kampus) }}">
                        @error('kampus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="program_studi">Program Studi</label>
                        <input type="text" name="program_studi" id="program_studi" class="form-control @error('program_studi') is-invalid @enderror" required value="{{ old('program_studi', $anggota->program_studi) }}">
                        @error('program_studi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="angkatan_mahasiswa">Tahun Angkatan Sebagai Mahasiswa</label>
                        <select name="angkatan_mahasiswa" id="angkatan_mahasiswa" class="form-control @error('angkatan_mahasiswa') is-invalid @enderror" required>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ old('angkatan_mahasiswa', $anggota->angkatan_mahasiswa) == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                        @error('angkatan_mahasiswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </fieldset>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <a href="/anggota" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
