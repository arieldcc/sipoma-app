@extends('layouts.master')

@section('title', 'Data Pengurus')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Pengurus Organisasi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="pengurusTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Anggota</th>
                            <th>Nama Anggota</th>
                            <th>Jabatan</th>
                            <th>Periode</th>
                            <th>Status Pengurus</th>
                            <th>Status Keanggotaan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $pengurus)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pengurus->anggota->no_anggota ?? '-' }}</td>
                                <td>{{ $pengurus->anggota->nama ?? '-' }}</td>
                                <td>{{ $pengurus->jabatan }}</td>
                                <td>{{ $pengurus->periode->periode ?? '-' }}</td> <!-- Tampilkan nama periode -->
                                <td>{{ $pengurus->status_pengurus }}</td>
                                <td>{{ optional($pengurus->anggota->keanggotaan)->status_keanggotaan ?? '-' }}</td>
                                <td>{{ $pengurus->keterangan ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" onclick="showDetail('{{ $pengurus->id }}')" title="Tampil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/pengurus/{{ $pengurus->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $pengurus->id }}')" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <form id="delete-form" action="" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    @include('Pengurus.modal_detail')
    <!-- Floating Action Button -->
    <a href="/pengurus/create" class="fab-btn" title="">+</a>
</div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#pengurusTable').DataTable({
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

        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = document.getElementById('delete-form');
                    form.action = '/pengurus/' + id;
                    form.submit();
                }
            });
        }

        function showDetail(id) {
            $.ajax({
                url: `/pengurus/${id}`,
                type: 'GET',
                success: function(data) {
                    $('#detailNoAnggota').text(data.anggota.no_anggota || '-');
                    $('#detailNamaAnggota').text(data.anggota.nama || '-');
                    $('#detailKampus').text(data.anggota.kampus || '-');
                    $('#detailProgramStudi').text(data.anggota.program_studi || '-');
                    $('#detailStatusKeanggotaan').text(data.anggota.keanggotaan?.status_keanggotaan || '-');
                    $('#detailTanggalBergabung').text(data.anggota.keanggotaan?.tanggal_bergabung || '-');
                    $('#detailJabatan').text(data.jabatan || '-');
                    $('#detailPeriode').text(data.periode?.periode || '-'); // Tampilkan nama periode
                    $('#detailPeriodeMulai').text(data.periode_mulai || '-');
                    $('#detailPeriodeSelesai').text(data.periode_selesai || '-');
                    $('#detailStatusPengurus').text(data.status_pengurus || '-');
                    $('#detailKeterangan').text(data.keterangan || '-');

                    // Data Periode
                    $('#detailPeriode').text(data.periode?.periode || '-');
                    $('#detailStatusPeriode').text(data.periode?.status_periode === 'A' ? 'Aktif' : 'Non-Aktif');

                    if (data.anggota.foto_anggota) {
                        $('#detailFotoAnggota').attr('src', `/storage/${data.anggota.foto_anggota}`).show();
                    } else {
                        $('#detailFotoAnggota').hide();
                    }

                    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                    detailModal.show();
                },
                error: function() {
                    Swal.fire('Error', 'Gagal memuat detail data pengurus.', 'error');
                }
            });
        }
    </script>
@endsection
