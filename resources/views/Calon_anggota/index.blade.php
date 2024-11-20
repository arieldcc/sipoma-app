@extends('layouts.master')

@section('title', 'Calon Anggota')

@section('css')
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
    <style>
        .member-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s ease-in-out;
            position: relative;
        }
        .member-card:hover {
            transform: scale(1.02);
        }
        .member-photo {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .member-info {
            padding: 10px;
        }
        .member-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .member-details {
            font-size: 0.9rem;
            color: #555;
        }
        /* Pagination Alignment */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        /* Chart Container for responsive sizing */
        #anggotaChart {
            max-width: 100%;
            height: 400px;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Daftar Calon Anggota</h2>

    <!-- Display Total Calon Anggota -->
    <div class="total-info text-center">
        Total Calon Anggota: {{ $totalCalonAnggota }}
    </div>

    <!-- Nav Tabs for Members and Statistics -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#members" role="tab">Calon Anggota</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#statistics" role="tab">Statistik</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Members List Tab -->
        <div class="tab-pane fade show active" id="members" role="tabpanel">
            <div class="row g-3">
                @foreach ($calonAnggota as $index => $item)
                    <div class="col-md-4 col-sm-6">
                        <div class="card member-card">
                            <img src="{{ $item->anggota->foto_anggota ? asset('storage/' . $item->anggota->foto_anggota) : asset('images/default-avatar.jpg') }}" alt="Foto Anggota" class="member-photo">
                            <div class="member-info">
                                <h5 class="member-name">{{ $item->anggota->nama }}</h5>
                                <p class="member-details">
                                    <strong>Email:</strong> {{ $item->anggota->email }}<br>
                                    <strong>No. Anggota:</strong> {{ $item->anggota->no_anggota }}<br>
                                    <strong>Program Studi:</strong> {{ $item->anggota->program_studi }}<br>
                                    <strong>Kampus:</strong> {{ $item->anggota->kampus }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="pagination-wrapper d-flex justify-content-center mt-4">
                {{ $calonAnggota->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <!-- Statistics Tab -->
        <div class="tab-pane fade" id="statistics" role="tabpanel">
            <h4 class="text-center my-4">Statistik Calon Anggota Berdasarkan Bulan Bergabung</h4>
            <div class="d-flex justify-content-center">
                <canvas id="anggotaChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('anggotaChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Jumlah Calon Anggota',
                        data: @json($months),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
