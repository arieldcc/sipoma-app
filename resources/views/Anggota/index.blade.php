@extends('layouts.master')

@section('title', 'Data Anggota')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Anggota</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="anggotaTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Anggota</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Kampus</th>
                            <th>Program Studi</th>
                            <th>Angkatan Anggota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->no_anggota }}</td>
                                <td>{{ $member->nama }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->no_telepon }}</td>
                                <td>{{ $member->kampus }}</td>
                                <td>{{ $member->program_studi }}</td>
                                <td>{{ $member->angkatan_anggota }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" onclick="showFile('{{ $member->foto_anggota }}')">
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                    <button type="button" class="action-btn btn-tampil" onclick="showDetail('{{ $member->id }}')" title="Tampil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/anggota/{{ $member->id }}/edit" class="action-btn btn-edit" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="action-btn btn-hapus" onclick="confirmDelete('{{ $member->id }}')" title="Hapus">
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

    @include('Anggota.modal_detail')

    @include('Anggota.modal_file')

    <!-- Floating Action Button -->
    <a href="/anggota/create" class="fab-btn" title="">+</a>
</div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#anggotaTable').DataTable({
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
                    form.action = '/anggota/' + id;
                    form.submit();
                }
            });
        }

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
                url: `/anggota/${id}`, // URL ke endpoint untuk mendapatkan detail anggota
                type: 'GET',
                success: function(data) {
                    // Mengisi data anggota
                    $('#detail_no_anggota').text(data.no_anggota);
                    $('#detail_nama').text(data.nama);
                    $('#detail_j_kel').text(data.j_kel === 'l' ? 'Laki-laki' : 'Perempuan');
                    $('#detail_agama').text(data.agama);
                    $('#detail_tanggal_lahir').text(data.tanggal_lahir);
                    $('#detail_email').text(data.email);
                    $('#detail_no_telepon').text(data.no_telepon);
                    $('#detail_angkatan_anggota').text(data.angkatan_anggota);
                    $('#detail_kampus').text(data.kampus);
                    $('#detail_program_studi').text(data.program_studi);
                    $('#detail_angkatan_mahasiswa').text(data.angkatan_mahasiswa);

                    // Mengisi foto anggota atau dokumen PDF
                    if (data.foto_anggota) {
                        const fileUrl = `/storage/${data.foto_anggota}`;
                        $('#pdfViewer, #imageViewer, #fileDownloadLink').hide();

                        if (data.foto_anggota.endsWith('.pdf')) {
                            $('#pdfViewer').attr('src', fileUrl).show();
                        } else {
                            $('#imageViewer').attr('src', fileUrl).show();
                        }
                        $('#fileDownloadLink').attr('href', fileUrl).show();
                    }

                    // Mengisi data keanggotaan
                    if (data.keanggotaan) {
                        $('#detail_status_keanggotaan').text(data.keanggotaan.status_keanggotaan || '-');
                        $('#detail_tanggal_bergabung').text(data.keanggotaan.tanggal_bergabung || '-');
                        $('#detail_tanggal_keluar').text(data.keanggotaan.tanggal_keluar || '-');
                        $('#detail_keterangan_keanggotaan').text(data.keanggotaan.keterangan || '-');
                    } else {
                        // Jika keanggotaan tidak ada, tampilkan tanda "-"
                        $('#detail_status_keanggotaan').text('-');
                        $('#detail_tanggal_bergabung').text('-');
                        $('#detail_tanggal_keluar').text('-');
                        $('#detail_keterangan_keanggotaan').text('-');
                    }

                    // Tampilkan modal detail
                    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    detailModal.show();
                },
                error: function() {
                    alert('Gagal memuat data anggota.');
                }
            });
        }

    </script>
@endsection
