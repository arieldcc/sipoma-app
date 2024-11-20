@extends('layouts.master')

@section('title', 'Data Struktur Organisasi')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Data Struktur Organisasi</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="organisasiTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Periode</th>
                            <th>Status Periode</th>
                            {{-- <th>Gambar Struktur</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organisasi as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->periode->periode }}</td>
                                <td>{{ $item->periode->status_periode === 'A' ? 'Aktif' : 'Non-Aktif' }}</td>
                                {{-- <td>
                                    @if($item->gambar_struktur)
                                        <a href="{{ asset('storage/' . $item->gambar_struktur) }}" target="_blank">Lihat Gambar</a>
                                    @else
                                        Tidak ada gambar
                                    @endif
                                </td> --}}
                                <td>
                                    <button type="button" class="btn btn-info" onclick="showDetail('{{ $item->id }}')" title="Tampil">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="/organisasi/{{ $item->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
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
    <a href="/organisasi/create" class="fab-btn" title="Tambah Data">+</a>
</div>

<!-- Modal for Detail View -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Struktur Organisasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong>Periode:</strong> <span id="detailPeriode"></span><br>
                <strong>Status Periode:</strong> <span id="detailStatusPeriode"></span><br>
                <strong>Gambar Struktur:</strong>
                <div id="imageContainer">
                    <img id="detailImage" src="" alt="Gambar Struktur" class="img-fluid mt-2" style="max-height: 300px;">
                </div>
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
            $('#organisasiTable').DataTable({
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
                url: `/organisasi/${id}`,
                type: 'GET',
                success: function(data) {
                    $('#detailPeriode').text(data.periode.periode);
                    $('#detailStatusPeriode').text(data.periode.status_periode === 'A' ? 'Aktif' : 'Non-Aktif');
                    $('#imageContainer').hide();

                    if (data.gambar_struktur) {
                        const imageUrl = `/storage/${data.gambar_struktur}`;
                        $('#detailImage').attr('src', imageUrl);
                        $('#imageContainer').show();
                    }

                    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                    detailModal.show();
                },
                error: function() {
                    Swal.fire('Error', 'Gagal memuat detail data organisasi.', 'error');
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
                    form.action = '/organisasi/' + id;
                    form.submit();
                }
            });
        }
    </script>
@endsection
