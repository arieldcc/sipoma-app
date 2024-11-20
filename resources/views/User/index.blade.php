@extends('layouts.master')

@section('title', 'User Management')

@section('css')
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
    <style>
        .user-card {
            border-radius: 8px;
            padding: 15px;
            transition: transform 0.2s;
        }
        .user-card:hover {
            transform: scale(1.02);
        }
        .user-card .card-body {
            text-align: center;
        }
        .fab-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 1.5rem;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">User Management</h2>

    <div class="row">
        @foreach ($users as $index => $user)
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card user-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="card-text"><strong>Level:</strong> {{ $user->level }}</p>
                        <div class="d-flex justify-content-center">
                            <a href="/user-manajemen/{{ $user->id }}/edit" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a> &nbsp;
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $user->id }}')" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <form id="delete-form" action="" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Floating Action Button for Adding New User -->
    <a href="/user-manajemen/create" class="fab-btn btn btn-primary" title="Add User">+</a>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
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
                    form.action = '/user-manajemen/' + id;
                    form.submit();
                }
            });
        }
    </script>
@endsection
