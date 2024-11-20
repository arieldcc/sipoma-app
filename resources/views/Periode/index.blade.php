@extends('layouts.master')

@section('title', 'Data Periode')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Periode</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="periodeTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Periode</th>
                            <th>Status Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($periode as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->periode }}</td>
                                <td>
                                    <a href="javascript:void(0);" onclick="toggleStatus('{{ $item->id }}', '{{ $item->status_periode }}')" class="btn btn-{{ $item->status_periode === 'A' ? 'success' : 'secondary' }} btn-sm">
                                        {{ $item->status_periode === 'A' ? 'Aktif' : 'Non-Aktif' }}
                                    </a>
                                </td>
                                <td>
                                    <a href="/periode/{{ $item->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
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

    <!-- Floating Action Button -->
    <a href="/periode/create" class="fab-btn" title="Tambah Data">+</a>
</div>

<!-- Modal for Detail View -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Periode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong>Periode:</strong> <span id="detailPeriode"></span><br>
                <strong>Status:</strong> <span id="detailStatus"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#periodeTable').DataTable({
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

            @if(session('error'))
                Swal.fire({
                    title: 'Kesalahan!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    timer: 2000,
                    timerProgressBar: true
                });
            @endif
        });

        function toggleStatus(id, currentStatus) {
            // Konfirmasi tindakan dari pengguna
            Swal.fire({
                title: 'Ubah status periode?',
                text: 'Mengaktifkan periode ini akan menonaktifkan periode lain yang aktif.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Ubah Status'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan ke server untuk mengubah status
                    $.ajax({
                        url: `/periode/toggle-status/${id}`,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            currentStatus: currentStatus
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Status Berubah!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                timerProgressBar: true
                            }).then(() => {
                                location.reload(); // Muat ulang halaman untuk memperbarui tampilan
                            });
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Gagal mengubah status periode.', 'error');
                        }
                    });
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
                    form.action = `/periode/${id}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
