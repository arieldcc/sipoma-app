@extends('layouts.master')

@section('title', 'Data Keanggotaan')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Keanggotaan</h4>
        </div>
        <div class="card-body">
            <!-- Custom Filter -->
            <div class="mb-3">
                <label for="statusFilter" class="form-label">Filter by Status Keanggotaan:</label>
                <select id="statusFilter" class="form-control">
                    <option value="" {{ $status == '' ? 'selected' : '' }}>All</option>
                    <option value="Aktif" {{ $status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Non-Aktif" {{ $status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    <option value="Alumni" {{ $status == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="Calon" {{ $status == 'Calon' ? 'selected' : '' }}>Calon</option>
                </select>
            </div>


            <div class="table-responsive">
                <table id="keanggotaanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Status Keanggotaan</th>
                            <th>Tanggal Bergabung</th>
                            <th>Tanggal Keluar</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $keanggotaan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $keanggotaan->anggota->no_anggota ?? '-' }}</td>
                                <td>{{ $keanggotaan->anggota->nama ?? '-' }}</td>
                                <td>
                                    <!-- Edit Status Keanggotaan -->
                                    <select class="form-control status-keanggotaan" data-id="{{ $keanggotaan->id }}">
                                        <option value="Aktif" {{ $keanggotaan->status_keanggotaan == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Non-Aktif" {{ $keanggotaan->status_keanggotaan == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                        <option value="Alumni" {{ $keanggotaan->status_keanggotaan == 'Alumni' ? 'selected' : '' }}>Alumni</option>
                                        <option value="Calon" {{ $keanggotaan->status_keanggotaan == 'Calon' ? 'selected' : '' }}>Calon</option>
                                    </select>
                                    <!-- Hidden element to store status text for filtering -->
                                    <span class="d-none">{{ $keanggotaan->status_keanggotaan }}</span>
                                </td>
                                <td>{{ $keanggotaan->tanggal_bergabung }}</td>
                                <td>
                                    <input type="date" class="form-control tanggal-keluar" data-id="{{ $keanggotaan->id }}" value="{{ $keanggotaan->tanggal_keluar }}">
                                </td>
                                <td>{{ $keanggotaan->keterangan ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" onclick="showDetail('{{ $keanggotaan->id }}')" title="Tampil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/keanggotaan/{{ $keanggotaan->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('Keanggotaan.modal_detail')
</div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $(document).ready(function() {
            // Event listener for custom filter dropdown
            $('#statusFilter').on('change', function() {
                const status = $(this).val();
                // Reload the page with the selected status as a query parameter
                const url = new URL(window.location.href);
                if (status) {
                    url.searchParams.set('status', status);
                } else {
                    url.searchParams.delete('status');
                }
                window.location.href = url.toString();
            });
        });

        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#keanggotaanTable').DataTable({
                responsive: true
            });


            @if(session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 2000,
                    timerProgressBar: true
                });
            @endif

            // AJAX for status update
            $(document).on('change', '.status-keanggotaan', function() {
                let id = $(this).data('id');
                let status = $(this).val();
                $.ajax({
                    url: `/keanggotaan/${id}/update-status`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status_keanggotaan: status
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal memperbarui status keanggotaan.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });

            // AJAX for tanggal keluar update
            $(document).on('change', '.tanggal-keluar', function() {
                let id = $(this).data('id');
                let tanggalKeluar = $(this).val();
                $.ajax({
                    url: `/keanggotaan/${id}/update-tanggal-keluar`,
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        tanggal_keluar: tanggalKeluar
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal memperbarui tanggal keluar.',
                            icon: 'error',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });

        function showDetail(id) {
            $.ajax({
                url: `/keanggotaan/${id}`,
                type: 'GET',
                success: function(data) {
                    $('#detailNamaAnggota').text(data.anggota.nama || '-');
                    $('#detailNoAnggota').text(data.anggota.no_anggota || '-');
                    $('#detailKampus').text(data.anggota.kampus || '-');
                    $('#detailProgramStudi').text(data.anggota.program_studi || '-');
                    $('#detailStatusKeanggotaan').text(data.status_keanggotaan || '-');
                    $('#detailTanggalBergabung').text(data.tanggal_bergabung || '-');
                    $('#detailTanggalKeluar').text(data.tanggal_keluar || '-');
                    $('#detailKeterangan').text(data.keterangan || '-');

                    if (data.anggota.foto_anggota) {
                        $('#detailFotoAnggota').attr('src', `/storage/${data.anggota.foto_anggota}`).show();
                    } else {
                        $('#detailFotoAnggota').hide();
                    }

                    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    detailModal.show();
                },
                error: function() {
                    alert('Gagal memuat data keanggotaan.');
                }
            });
        }
    </script>
@endsection
