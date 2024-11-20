<?php

namespace App\Http\Controllers;

use App\Models\M_Anggota;
use App\Models\M_Kegiatan;
use App\Models\M_Kepanitiaan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KepanitiaanController extends Controller
{
    public function index() {
        $kepanitiaan = M_Kepanitiaan::with(['anggota', 'kegiatan'])->get();
        return view('Kepanitiaan.index', compact('kepanitiaan'));
    }

    public function create() {
        // Ambil data anggota dengan status keanggotaan "Aktif" yang belum menjadi pengurus aktif
        $anggota = M_Anggota::whereHas('keanggotaan', function ($query) {
            $query->where('status_keanggotaan', 'Aktif');
        })
        ->whereDoesntHave('pengurus', function ($query) {
            $query->where('status_pengurus', 'Aktif');
        })
        ->get();

        $kegiatan = M_Kegiatan::all();
        return view('Kepanitiaan.create', compact('anggota', 'kegiatan'));
    }

    public function store(Request $request) {
        // Validasi input data
        $request->validate([
            'id_anggota' => 'required|exists:t_anggota,id', // Pastikan anggota valid
            'id_kegiatan' => 'required|exists:t_kegiatan,id', // Pastikan kegiatan valid
            'jabatan' => 'required|string|max:255',
            'tugas' => 'nullable|string',
            'keterangan' => 'nullable|string'
        ], [
            'id_anggota.required' => 'Pilih anggota untuk kepanitiaan ini.',
            'id_kegiatan.required' => 'Pilih kegiatan yang sesuai.',
            'jabatan.required' => 'Jabatan harus diisi.',
        ]);

        // Menyimpan data kepanitiaan
        M_Kepanitiaan::create([
            'id_anggota' => $request->id_anggota,
            'id_kegiatan' => $request->id_kegiatan,
            'jabatan' => $request->jabatan,
            'tugas' => $request->tugas,
            'keterangan' => $request->keterangan,
        ]);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect('/kepanitiaan')->with('success', 'Data kepanitiaan berhasil ditambahkan.');
    }

    public function getAvailableAnggota($id) {
        try {
            $anggota = M_Anggota::whereHas('keanggotaan', function ($query) {
                    $query->where('status_keanggotaan', 'Aktif');
                })
                ->whereDoesntHave('kepanitiaan', function ($query) use ($id) {
                    $query->where('id_kegiatan', $id);
                })
                ->get(['id', 'no_anggota', 'nama', 'kampus']);

            // Log data untuk debugging
            Log::info('Anggota yang tersedia:', $anggota->toArray());

            return response()->json($anggota);

        } catch (Exception $e) {
            Log::error('Error memuat data anggota: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data anggota'], 500);
        }
    }

    public function show_detail($id) {
        $kepanitiaan = M_Kepanitiaan::with(['anggota.keanggotaan', 'kegiatan'])->findOrFail($id);
        return response()->json($kepanitiaan);
    }

    public function show_edit($id) {
        // Ambil data anggota dengan status keanggotaan "Aktif" yang belum menjadi pengurus aktif
        $anggota = M_Anggota::whereHas('keanggotaan', function ($query) {
            $query->where('status_keanggotaan', 'Aktif');
        })
        ->whereDoesntHave('pengurus', function ($query) {
            $query->where('status_pengurus', 'Aktif');
        })
        ->get();

        $kegiatan = M_Kegiatan::all();
        $kepanitiaan = M_Kepanitiaan::findOrFail($id);
        return view('Kepanitiaan.edit', compact('anggota', 'kegiatan', 'kepanitiaan'));
    }

    public function update(Request $request, $id) {
        // Validasi input
        $request->validate([
            'id_kegiatan' => 'required|exists:t_kegiatan,id',
            'id_anggota' => 'required|exists:t_anggota,id',
            'jabatan' => 'required|string|max:255',
            'tugas' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        // Temukan data kepanitiaan berdasarkan ID
        $kepanitiaan = M_Kepanitiaan::findOrFail($id);

        // Perbarui data
        $kepanitiaan->update($request->only([
            'id_kegiatan',
            'id_anggota',
            'jabatan',
            'tugas',
            'keterangan'
        ]));

        // Redirect ke halaman utama kepanitiaan dengan pesan sukses
        return redirect('/kepanitiaan')->with('success', 'Data kepanitiaan berhasil diperbarui.');
    }

    public function delete($id) {
        // Temukan data kepanitiaan berdasarkan ID
        $kepanitiaan = M_Kepanitiaan::findOrFail($id);

        // Hapus data kepanitiaan
        $kepanitiaan->delete();

        // Redirect ke halaman utama kepanitiaan dengan pesan sukses
        return redirect('/kepanitiaan')->with('success', 'Data kepanitiaan berhasil dihapus.');
    }
}
