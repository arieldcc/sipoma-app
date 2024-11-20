@extends('layouts.master')

@section('title', 'Struktur Organisasi')

@section('css')
    <link href="{{ asset('css/style-awal.css') }}" rel="stylesheet">
    <style>
        .struktur-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        .struktur-card {
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
            text-align: center;
        }
        .struktur-image img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        .struktur-info {
            padding: 15px;
            font-size: 1rem;
        }
        .dropdown {
            width: 100%;
            max-width: 300px;
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Struktur Organisasi</h2>

    <!-- Period Selection Dropdown -->
    <div class="struktur-container">
        <form method="GET" action="{{ route('struktur-organisasi') }}" class="dropdown">
            <select name="id_periode" class="form-control" onchange="this.form.submit()">
                @foreach($periods as $period)
                    <option value="{{ $period->id }}" {{ $selectedPeriodId == $period->id ? 'selected' : '' }}>
                        Periode {{ $period->periode }} - {{ $period->status_periode === 'A' ? 'Aktif' : 'Non-Aktif' }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Organizational Structure Display -->
        @if($strukturOrganisasi)
            <div class="struktur-card">
                <div class="struktur-image">
                    <img src="{{ asset('storage/' . $strukturOrganisasi->gambar_struktur) }}" alt="Struktur Organisasi">
                </div>
                <div class="struktur-info">
                    <p><strong>Periode:</strong> {{ $strukturOrganisasi->periode->periode }}</p>
                    <p><strong>Status:</strong> {{ $strukturOrganisasi->periode->status_periode === 'A' ? 'Aktif' : 'Non-Aktif' }}</p>
                </div>
            </div>
        @else
            <p class="text-center mt-4">Struktur organisasi untuk periode ini tidak ditemukan.</p>
        @endif
    </div>
</div>
@endsection
