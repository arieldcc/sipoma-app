@extends('layouts.master')

@section('title', 'Galeri Kegiatan')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">

    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }
        .gallery-item {
            position: relative;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.2s;
        }
        .gallery-item img:hover {
            transform: scale(1.05);
        }
        .delete-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            padding: 5px;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Galeri Kegiatan</h2>

    @forelse($kegiatan as $item)
        <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4>{{ $item->nama_kegiatan }}</h4>
                <p class="mb-0"><small>Tanggal: {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small></p>
            </div>
            <div class="card-body">
                <div class="gallery-grid">
                    @foreach($item->galery as $galeryItem)
                        <div class="gallery-item">
                            <a href="{{ asset('storage/' . $galeryItem->gambar_galery) }}" data-lightbox="gallery-{{ $item->id }}" data-title="{{ $item->nama_kegiatan }}">
                                <img src="{{ asset('storage/' . $galeryItem->gambar_galery) }}" alt="Galeri Kegiatan" class="img-fluid rounded">
                            </a>
                            <!-- Tombol Hapus -->
                            <button class="delete-btn" onclick="confirmDelete('{{ $galeryItem->id }}')">&times;</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <p class="text-center">Tidak ada galeri kegiatan tersedia.</p>
    @endforelse

    <!-- Floating Action Button -->
    <a href="/galery/create" class="fab-btn" title="Tambah Data">+</a>

    <!-- Form untuk Hapus -->
    <form id="delete-form" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(galeryId) {
            Swal.fire({
                title: 'Yakin ingin menghapus gambar ini?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.action = `/galery/${galeryId}`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
