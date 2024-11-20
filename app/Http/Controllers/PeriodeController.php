<?php

namespace App\Http\Controllers;

use App\Models\M_Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index() {
        $periode = M_Periode::all();

        return view('Periode.index', compact('periode'));
    }

    public function create() {
        return view('Periode.create');
    }

    public function store(Request $request) {
        // Validasi input tanpa 'status_periode'
        $request->validate([
            'periode' => 'required|string|max:100|unique:t_periode,periode',
        ], [
            'periode.required' => 'Periode wajib diisi.',
            'periode.unique' => 'Periode ini sudah ada.',
        ]);

        // Simpan data dengan status_periode default "N"
        M_Periode::create([
            'periode' => $request->periode,
            'status_periode' => 'N', // Default Non-Aktif
        ]);

        // Redirect ke halaman utama periode dengan pesan sukses
        return redirect('/periode')->with('success', 'Data periode berhasil disimpan dengan status Non-Aktif.');
    }

    public function show_edit($id) {
        $periode = M_Periode::findOrFail($id);

        return view('Periode.edit', compact('periode'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'periode' => 'required|string|max:100|unique:t_periode,periode,' . $id,
        ]);

        $periode = M_Periode::findOrFail($id);
        $periode->update(['periode' => $request->periode]);

        return redirect('/periode')->with('success', 'Data periode berhasil diperbarui.');
    }

    public function delete($id) {
        $periode = M_Periode::findOrFail($id);

        // Periksa apakah periode ini memiliki data terkait di tabel pengurus atau organisasi
        if ($periode->pengurus()->exists() || $periode->organisasi()->exists()) {
            return redirect('/periode')->with('error', 'Periode ini tidak dapat dihapus karena masih digunakan di data terkait.');
        }

        // Jika tidak ada relasi terkait, maka lanjutkan penghapusan
        $periode->delete();

        return redirect('/periode')->with('success', 'Data periode berhasil dihapus.');
    }

    public function toggleStatus($id, Request $request){
        $currentStatus = $request->currentStatus;

        // Jika status yang diterima adalah 'A', ubah status semua periode lain ke 'N'
        if ($currentStatus === 'N') {
            // Set semua periode ke 'Non-Aktif'
            M_Periode::where('status_periode', 'A')->update(['status_periode' => 'N']);

            // Set periode yang dipilih ke 'Aktif'
            $periode = M_Periode::findOrFail($id);
            $periode->status_periode = 'A';
            $periode->save();

            return response()->json(['message' => 'Status periode berhasil diubah menjadi Aktif.']);
        } else {
            // Jika status saat ini sudah 'Aktif', hanya ubah menjadi 'Non-Aktif'
            $periode = M_Periode::findOrFail($id);
            $periode->status_periode = 'N';
            $periode->save();

            return response()->json(['message' => 'Status periode berhasil diubah menjadi Non-Aktif.']);
        }
    }

}
