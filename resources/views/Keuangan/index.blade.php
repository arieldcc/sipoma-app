@extends('layouts.master')

@section('title', 'Data Keuangan')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Keuangan</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="keuanganTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Anggota</th>
                            <th>Nama Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Jenis Transaksi</th>
                            <th>Jumlah</th>
                            <th>Sumber Dana</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keuangan as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->anggota->nama ?? '-' }}</td>
                                <td>{{ $item->nama_transaksi ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                                <td>{{ $item->jenis_transaksi }}</td>
                                <td>Rp {{ number_format($item->jumlah, 2, ',', '.') }}</td>
                                <td>{{ $item->sumber_dana ?? '-' }}</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" onclick="showFile('{{ $item->bukti_transaksi }}')">
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-info btn-sm" onclick="showDetail('{{ $item->id }}')" title="Tampil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/keuangan/{{ $item->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
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

    @include('Keuangan.model_detail')

    @include('Anggota.modal_file')

    <a href="/keuangan/create" class="fab-btn" title="">+</a>
</div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#keuanganTable').DataTable({
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
                    form.action = '/keuangan/' + id;
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
                url: `/keuangan/${id}`, // Pastikan route ini sesuai dengan route detail di backend
                type: 'GET',
                success: function(data) {
                    // Isi data keuangan dalam elemen modal
                    $('#detailNamaTransaksi').text(data.nama_transaksi || '-');
                    $('#detailTanggalTransaksi').text(data.tanggal_transaksi || '-');
                    $('#detailJenisTransaksi').text(data.jenis_transaksi || '-');
                    $('#detailJumlah').text(data.jumlah ? 'Rp ' + parseFloat(data.jumlah).toLocaleString('id-ID') : '-');
                    $('#detailSumberDana').text(data.sumber_dana || '-');
                    $('#detailKeterangan').text(data.keterangan || '-');

                    // Tampilkan bukti transaksi sesuai tipe file
                    const buktiTransaksiUrl = `/storage/${data.bukti_transaksi}`;
                    const fileExtension = data.bukti_transaksi ? data.bukti_transaksi.split('.').pop().toLowerCase() : '';

                    $('#detailBuktiTransaksiPDF').hide();
                    $('#detailBuktiTransaksiImg').hide();

                    if (fileExtension === 'pdf') {
                        $('#detailBuktiTransaksiPDF').attr('src', buktiTransaksiUrl).show();
                    } else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
                        $('#detailBuktiTransaksiImg').attr('src', buktiTransaksiUrl).show();
                    }

                    // Tampilkan modal
                    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    detailModal.show();
                },
                error: function() {
                    alert('Gagal memuat detail data keuangan.');
                }
            });
        }
    </script>
@endsection
