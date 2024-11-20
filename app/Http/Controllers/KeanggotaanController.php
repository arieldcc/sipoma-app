<?php

namespace App\Http\Controllers;

use App\Models\M_Anggota;
use App\Models\M_Keanggotaan;
use Illuminate\Http\Request;

class KeanggotaanController extends Controller
{
    public function index(Request $request) {
        // Check if a status filter is applied
        $status = $request->input('status');

        // Filter data based on the selected status
        $query = M_Keanggotaan::with('anggota'); // Assuming 'anggota' relation is loaded here

        if ($status) {
            $query->where('status_keanggotaan', $status);
        }

        // Fetch the filtered data
        $data = $query->get();

        return view('Keanggotaan.index', compact('data', 'status'));
    }

    public function create() {
        // Mengambil anggota yang belum memiliki keanggotaan
        $anggota = M_Anggota::whereDoesntHave('keanggotaan')->get();
        return view('Keanggotaan.create', compact('anggota'));
    }

    public function store(Request $request) {
        // Validasi input
        $request->validate([
            'id_anggota' => 'required|exists:t_anggota,id',
            'status_keanggotaan' => 'required|in:Aktif,Non-Aktif,Alumni',
            'tanggal_bergabung' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_bergabung',
            'keterangan' => 'nullable|string'
        ],[
            'tanggal_keluar.after_or_equal' => 'Tanggal keluar harus setelah atau sama dengan tanggal bergabung.',
            'tanggal_bergabung.before_or_equal' => 'Tanggal bergabung harus sebelum atau sama dengan tanggal keluar.',
        ]);

        // Simpan data keanggotaan
        M_Keanggotaan::create($request->all());

        return redirect('/keanggotaan')->with('success', 'Data keanggotaan berhasil ditambahkan.');
    }

    public function show_detail($id) {
        $keanggotaan = M_Keanggotaan::with('anggota')->findOrFail($id);

        return response()->json($keanggotaan);
    }

    public function show_edit($id) {
        $keanggotaan = M_Keanggotaan::with('anggota')->findOrFail($id); // Mengambil data keanggotaan dan anggota terkait

        return view('Keanggotaan.edit', compact('keanggotaan'));
    }

    public function update(Request $request, $id) {
        $keanggotaan = M_Keanggotaan::findOrFail($id);

        // Validasi input
        $request->validate([
            'status_keanggotaan' => 'required|in:Aktif,Non-Aktif,Alumni',
            'tanggal_bergabung' => 'required|date',
            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_bergabung',
            'keterangan' => 'nullable|string'
        ], [
            'tanggal_keluar.after_or_equal' => 'Tanggal keluar harus setelah atau sama dengan tanggal bergabung.',
            'tanggal_bergabung.before_or_equal' => 'Tanggal bergabung harus sebelum atau sama dengan tanggal keluar.',
        ]);

        // Update data keanggotaan
        $keanggotaan->update($request->all());

        return redirect('/keanggotaan')->with('success', 'Data keanggotaan berhasil diperbarui.');
    }

    public function update_status(Request $request, $id) {
        $keanggotaan = M_Keanggotaan::findOrFail($id);

        $request->validate([
            'status_keanggotaan' => 'required|in:Aktif,Non-Aktif,Alumni',
        ]);

        $keanggotaan->status_keanggotaan = $request->status_keanggotaan;
        $keanggotaan->save();

        return response()->json(['message' => 'Status keanggotaan berhasil diperbarui.']);
    }

    public function update_tanggal_keluar(Request $request, $id) {
        $keanggotaan = M_Keanggotaan::findOrFail($id);

        // Validasi format tanggal untuk tanggal_keluar
        $request->validate([
            'tanggal_keluar' => 'nullable|date',
        ]);

        // Ambil tanggal bergabung dari database
        $tanggalBergabung = $keanggotaan->tanggal_bergabung;

        // Cek jika tanggal_keluar lebih besar dari tanggal_bergabung
        if ($request->tanggal_keluar && $request->tanggal_keluar <= $tanggalBergabung) {
            return response()->json([
                'message' => 'Tanggal keluar harus lebih besar dari tanggal bergabung.'
            ], 422);
        }

        $keanggotaan->tanggal_keluar = $request->tanggal_keluar;
        $keanggotaan->save();

        return response()->json(['message' => 'Tanggal keluar berhasil diperbarui.']);
    }

    public function delete($id) {
        $keanggotaan = M_Keanggotaan::findOrFail($id);

        // Hapus data keanggotaan
        $keanggotaan->delete();

        return redirect('/keanggotaan')->with('success', 'Data keanggotaan berhasil dihapus.');
    }
}
