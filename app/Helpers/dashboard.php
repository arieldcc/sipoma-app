<?php
use App\Models\M_Anggota;
use App\Models\M_Pengurus;
use App\Models\M_Kegiatan;
use App\Models\M_Kepanitiaan;
use App\Models\M_Prestasi;
use App\Models\M_Keuangan;

// if (! function_exists('getGlobalStatistics')) {
    function getGlobalStatistics(){
        return [
            'jumlahAnggota' => M_Anggota::count(),
            'jumlahPengurusAktif' => M_Pengurus::whereHas('periode', function($query) {
                $query->where('status_periode', 'A');
            })->count(),
            'jumlahKegiatan' => M_Kegiatan::count(),
            'jumlahKepanitiaan' => M_Kepanitiaan::distinct('id_kegiatan')->count('id_kegiatan'), // Menghitung unik id_kegiatan
            'jumlahPrestasi' => M_Prestasi::count(),
            'jumlahKeuangan' => M_Keuangan::count(),
        ];
    }
// }
