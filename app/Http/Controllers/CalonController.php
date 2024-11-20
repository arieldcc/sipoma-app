<?php

namespace App\Http\Controllers;

use App\Models\M_Keanggotaan;
use Illuminate\Http\Request;

class CalonController extends Controller
{
    public function index(){
        // Retrieve paginated members with 'Calon' status
        $calonAnggota = M_Keanggotaan::where('status_keanggotaan', 'Calon')
            ->with('anggota')
            ->paginate(12);

        // Count total calon anggota
        $totalCalonAnggota = M_Keanggotaan::where('status_keanggotaan', 'Calon')->count();

        // Prepare data for the chart
        $monthlyData = M_Keanggotaan::where('status_keanggotaan', 'Calon')
            ->selectRaw('MONTH(tanggal_bergabung) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = $monthlyData->get($i, 0); // Fill months with data or 0
        }

        return view('Calon_anggota.index', compact('calonAnggota', 'months', 'totalCalonAnggota'));
    }
}
