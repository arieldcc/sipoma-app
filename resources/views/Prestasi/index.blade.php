@extends('layouts.master')

@section('title', 'Data Prestasi')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Prestasi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="prestasiTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Anggota</th>
                            <th>Nama Prestasi</th>
                            <th>Jenis Prestasi</th>
                            <th>Tanggal</th>
                            <th>Deskripsi Prestasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prestasi as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->anggota->nama ?? '-' }}</td>
                                <td>{{ $item->nama_prestasi }}</td>
                                <td>{{ $item->jenis_prestasi ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" onclick="showFile('{{ $item->foto_prestasi }}')">
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" onclick="showDetail('{{ $item->id }}')" title="Tampil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/prestasi/{{ $item->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $item->id }}')" title="Hapus">
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

    @include('Prestasi.modal_detail')

    @include('Anggota.modal_file')

    <!-- Floating Action Button -->
    <a href="/prestasi/create" class="fab-btn" title="Tambah Data">+</a>
</div>

@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#prestasiTable').DataTable({
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

        function showFile(filePath) {
            const fileUrl = `/storage/${filePath}`;
            const fileExtension = filePath.split('.').pop().toLowerCase();

            // Reset tampilkan
            $('#pdfViewer1').hide();
            $('#imageViewer1').hide();

            // Tampilkan file sesuai tipe
            if (fileExtension === 'pdf') {
                $('#pdfViewer1').attr('src', fileUrl).show();
                $('#imageViewer1').hide();
            } else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                // Tampilkan gambar langsung
                $('#imageViewer1').attr('src', fileUrl).show();
                $('#pdfViewer1').hide();
            }

            // Tampilkan modal
            const fileModal = new bootstrap.Modal(document.getElementById('fileModal'));
            fileModal.show();
        }

        function showDetail(id) {
            $.ajax({
                url: `/prestasi/${id}`,
                type: 'GET',
                success: function(data) {
                    // Mengisi data prestasi
                    $('#detailNamaPrestasi').text(data.nama_prestasi || '-');
                    $('#detailJenisPrestasi').text(data.jenis_prestasi || '-');
                    $('#detailTanggal').text(data.tanggal || '-');
                    $('#detailKeterangan').text(data.keterangan || '-');

                    // Mengisi data anggota
                    $('#detailNoAnggota').text(data.anggota.no_anggota || '-');
                    $('#detailNamaAnggota').text(data.anggota.nama || '-');
                    $('#detailKampus').text(data.anggota.kampus || '-');

                    // Pastikan keanggotaan tersedia sebelum akses
                    if (data.anggota.keanggotaan) {
                        $('#detailStatusKeanggotaan').text(data.anggota.keanggotaan.status_keanggotaan || '-');
                    } else {
                        $('#detailStatusKeanggotaan').text('-');
                    }

                    // Menampilkan foto atau PDF dari prestasi
                    if (data.foto_prestasi) {
                        const fileUrl = `/storage/${data.foto_prestasi}`;
                        const fileExtension = data.foto_prestasi.split('.').pop().toLowerCase();

                        $('#previewContainer').show();
                        $('#imagePreview').hide();
                        $('#pdfPreview').hide();

                        if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                            $('#detailFotoPrestasi').attr('src', fileUrl);
                            $('#imagePreview').show();
                        } else if (fileExtension === 'pdf') {
                            $('#detailPdfPrestasi').attr('src', fileUrl);
                            $('#pdfPreview').show();
                        }
                    } else {
                        $('#previewContainer').hide();
                    }

                    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    detailModal.show();
                },
                error: function() {
                    alert('Gagal memuat data prestasi.');
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
                    form.action = `/prestasi/${id}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
