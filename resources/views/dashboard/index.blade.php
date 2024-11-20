@extends('layouts.master')

@section('title', 'Dashboard')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMlCsfz1Zq5rr7IMSH7z4m+AXhgjj4JXUwh7izf" crossorigin="anonymous">

    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
    <style>
        .dashboard-card {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border-radius: 10px;
            color: white;
            transition: transform 0.2s ease-in-out;
            text-align: center;
        }
        .dashboard-card:hover {
            transform: scale(1.05);
        }
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')

<div class="container mt-5">
    <h2 class="text-center mb-4">Dashboard</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="dashboard-card bg-primary shadow-sm">
                <div>
                    <div class="card-icon"><i class="fas fa-users"></i></div>
                    <h5>Jumlah Anggota</h5>
                    <h3>{{ $globalData['jumlahAnggota'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card bg-success shadow-sm">
                <div>
                    <div class="card-icon"><i class="fas fa-user-tie"></i></div>
                    <h5>Pengurus di Periode Aktif</h5>
                    <h3>{{ $globalData['jumlahPengurusAktif'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card bg-warning shadow-sm">
                <div>
                    <div class="card-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h5>Jumlah Kegiatan</h5>
                    <h3>{{ $globalData['jumlahKegiatan'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card bg-info shadow-sm">
                <div>
                    <div class="card-icon"><i class="fas fa-users-cog"></i></div>
                    <h5>Jumlah Kepanitiaan</h5>
                    <h3>{{ $globalData['jumlahKepanitiaan'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card bg-danger shadow-sm">
                <div>
                    <div class="card-icon"><i class="fas fa-award"></i></div>
                    <h5>Jumlah Prestasi</h5>
                    <h3>{{ $globalData['jumlahPrestasi'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card bg-secondary shadow-sm">
                <div>
                    <div class="card-icon"><i class="fas fa-wallet"></i></div>
                    <h5>Jumlah Catatan Keuangan</h5>
                    <h3>{{ $globalData['jumlahKeuangan'] }}</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Diagram Keanggotaan Berdasarkan Status -->
    <div class="mt-5">
        <h3 class="text-center">Diagram Keanggotaan Berdasarkan Status</h3>
        <canvas id="keanggotaanChart" width="400" height="200"></canvas>
    </div>

    <!-- Grafik Prestasi Berdasarkan Tanggal -->
    <div class="mt-5">
        <h3 class="text-center">Grafik Prestasi Berdasarkan Tanggal Perolehan</h3>
        <canvas id="prestasiChart" width="400" height="200"></canvas>
    </div>

</div>
@endsection

@section('js')
    {{-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> --}}
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include Date Adapter -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const keanggotaanCtx = document.getElementById('keanggotaanChart').getContext('2d');
            const prestasiCtx = document.getElementById('prestasiChart').getContext('2d');

            // Data untuk diagram keanggotaan berdasarkan status
            const keanggotaanData = {
                labels: ['Aktif', 'Non-Aktif', 'Alumni', 'Calon'],
                datasets: [{
                    label: 'Jumlah Keanggotaan',
                    data: [
                        {{ $keanggotaanStatusCounts['Aktif'] ?? 0 }},
                        {{ $keanggotaanStatusCounts['Non-Aktif'] ?? 0 }},
                        {{ $keanggotaanStatusCounts['Alumni'] ?? 0 }},
                        {{ $keanggotaanStatusCounts['Calon'] ?? 0 }}
                    ],
                    backgroundColor: ['#4caf50', '#f44336', '#2196f3', '#ffc107']
                }]
            };

            new Chart(keanggotaanCtx, {
                type: 'bar',
                data: keanggotaanData,
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });

            // Data untuk grafik prestasi berdasarkan tanggal
            const prestasiData = {
                labels: {!! json_encode($prestasiPerBulan->keys()->toArray()) !!},
                datasets: [{
                    label: 'Jumlah Prestasi',
                    data: {!! json_encode($prestasiPerBulan->values()->toArray()) !!},
                    borderColor: '#3e95cd',
                    fill: false
                }]
            };

            new Chart(prestasiCtx, {
                type: 'line',
                data: prestasiData,
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true },
                        x: { type: 'time', time: { unit: 'month' } }
                    }
                }
            });
        });
    </script>
@endsection
