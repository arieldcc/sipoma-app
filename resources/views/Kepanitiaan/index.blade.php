@extends('layouts.master')

@section('title', 'Data Kepanitiaan')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Kepanitiaan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="kepanitiaanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Anggota</th>
                            <th>Nama Kegiatan</th>
                            <th>Jabatan</th>
                            <th>Tugas</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kepanitiaan as $index => $panitia)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $panitia->anggota->nama ?? '-' }}</td>
                                <td>{{ $panitia->kegiatan->nama_kegiatan ?? '-' }}</td>
                                <td>{{ $panitia->jabatan }}</td>
                                <td>{{ $panitia->tugas ?? '-' }}</td>
                                <td>{{ $panitia->keterangan ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" onclick="showDetail('{{ $panitia->id }}')" title="Tampil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/kepanitiaan/{{ $panitia->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $panitia->id }}')" title="Hapus">
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

    @include('Kepanitiaan.modal_detail')

    <!-- Floating Action Button untuk Tambah Data -->
    <a href="/kepanitiaan/create" class="fab-btn" title="Tambah Data Kepanitiaan">+</a>
</div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#kepanitiaanTable').DataTable({
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

        function showDetail(id) {
            $.ajax({
                url: `/kepanitiaan/${id}`,
                type: 'GET',
                success: function(data) {
                    // Set data panitia (anggota)
                    $('#detailNoAnggota').text(data.anggota.no_anggota || '-');
                    $('#detailNamaAnggota').text(data.anggota.nama || '-');
                    $('#detailKampus').text(data.anggota.kampus || '-');
                    $('#detailStatusKeanggotaan').text(data.anggota.keanggotaan.status_keanggotaan || '-');
                    $('#detailJabatanPanitia').text(data.jabatan || '-');
                    $('#detailTugasPanitia').text(data.tugas || '-');

                    // Tampilkan foto anggota jika ada
                    if (data.anggota.foto_anggota) {
                        $('#detailFotoAnggota').attr('src', `/storage/${data.anggota.foto_anggota}`).show();
                    } else {
                        $('#detailFotoAnggota').hide();
                    }

                    // Set data kegiatan
                    $('#detailNamaKegiatan').text(data.kegiatan.nama_kegiatan || '-');
                    $('#detailTempatKegiatan').text(data.kegiatan.tempat || '-');
                    $('#detailPenyelenggaraKegiatan').text(data.kegiatan.penyelenggara || '-');
                    $('#detailWaktuKegiatan').text(`${data.kegiatan.tanggal_mulai_kegiatan} s/d ${data.kegiatan.tanggal_selesai_kegiatan}` || '-');

                    // Tampilkan file kegiatan (gambar atau PDF)
                    if (data.kegiatan.gambar_kegiatan) {
                        const fileUrl = `/storage/${data.kegiatan.gambar_kegiatan}`;
                        const fileExtension = data.kegiatan.gambar_kegiatan.split('.').pop().toLowerCase();

                        if (fileExtension === 'pdf') {
                            $('#fileKegiatanPDF').attr('src', fileUrl).show();
                            $('#fileKegiatanImage').hide();
                        } else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                            $('#fileKegiatanImage').attr('src', fileUrl).show();
                            $('#fileKegiatanPDF').hide();
                        }
                    } else {
                        $('#fileKegiatanPDF').hide();
                        $('#fileKegiatanImage').hide();
                    }

                    // Tampilkan modal
                    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    detailModal.show();
                },
                error: function() {
                    alert('Gagal memuat detail kepanitiaan.');
                }
            });
        }

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
                    form.action = '/kepanitiaan/' + id;
                    form.submit();
                }
            });
        }
    </script>
@endsection
