@extends('layouts.master')

@section('title', 'Data Kegiatan')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Kegiatan Organisasi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="kegiatanTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Tempat</th>
                            <th>Penyelenggara</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $kegiatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kegiatan->nama_kegiatan }}</td>
                                <td>{{ $kegiatan->tanggal_mulai_kegiatan }}</td>
                                <td>{{ $kegiatan->tanggal_selesai_kegiatan ?? '-' }}</td>
                                <td>{{ $kegiatan->tempat ?? '-' }}</td>
                                <td>{{ $kegiatan->penyelenggara ?? '-' }}</td>
                                <td>
                                    <span class="badge
                                        {{ $kegiatan->status_kegiatan == 'Terjadwal' ? 'badge-primary' : ($kegiatan->status_kegiatan == 'Selesai' ? 'badge-success' : 'badge-danger') }}">
                                        {{ $kegiatan->status_kegiatan }}
                                    </span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" onclick="showDetail('{{ $kegiatan->id }}')" title="Tampil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/kegiatan/{{ $kegiatan->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $kegiatan->id }}')" title="Hapus">
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
    @include('Kegiatan.modal_detail')

    <!-- Floating Action Button -->
    <a href="/kegiatan/create" class="fab-btn" title="Tambah Kegiatan">+</a>
</div>


@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#kegiatanTable').DataTable({
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
                    form.action = '/kegiatan/' + id;
                    form.submit();
                }
            });
        }

        function showDetail(id) {
            $.ajax({
                url: `/kegiatan/${id}`, // URL untuk mengambil data detail kegiatan
                type: 'GET',
                success: function(data) {
                    // Isi data kegiatan ke dalam elemen modal
                    $('#detailNamaKegiatan').text(data.nama_kegiatan || '-');
                    $('#detailStatusKegiatan').text(data.status_kegiatan || '-');
                    $('#detailTanggalMulai').text(data.tanggal_mulai_kegiatan || '-');
                    $('#detailTanggalSelesai').text(data.tanggal_selesai_kegiatan || '-');
                    $('#detailDeskripsi').text(data.deskripsi || '-');
                    $('#detailTempat').text(data.tempat || '-');
                    $('#detailPenyelenggara').text(data.penyelenggara || '-');

                    // Tampilkan file kegiatan jika ada
                    if (data.gambar_kegiatan) {
                        const fileUrl = `/storage/${data.gambar_kegiatan}`;
                        const fileExtension = data.gambar_kegiatan.split('.').pop().toLowerCase();

                        $('#pdfViewer').hide();
                        $('#imageViewer').hide();
                        $('#fileDownloadLink').hide();

                        if (fileExtension === 'pdf') {
                            $('#pdfViewer').attr('src', fileUrl).show();
                        } else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                            $('#imageViewer').attr('src', fileUrl).show();
                        }
                        $('#fileDownloadLink').attr('href', fileUrl).show();
                    }

                    // Tampilkan modal
                    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    detailModal.show();
                },
                error: function() {
                    alert('Gagal memuat data kegiatan.');
                }
            });
        }
    </script>
@endsection
