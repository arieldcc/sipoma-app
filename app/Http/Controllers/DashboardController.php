<?php

namespace App\Http\Controllers;

use App\Models\M_Keanggotaan;
use App\Models\M_Prestasi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $globalData = getGlobalStatistics();

        // Ambil data keanggotaan berdasarkan status
        $keanggotaanStatusCounts = M_Keanggotaan::select('status_keanggotaan', DB::raw('count(*) as count'))
            ->groupBy('status_keanggotaan')
            ->pluck('count', 'status_keanggotaan');

        // Data jumlah prestasi per bulan
        $prestasiPerBulan = M_Prestasi::select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as bulan'), DB::raw('count(*) as jumlah'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get()
        ->pluck('jumlah', 'bulan');

    return view('dashboard.index', compact('globalData', 'keanggotaanStatusCounts', 'prestasiPerBulan'));
    }
}
