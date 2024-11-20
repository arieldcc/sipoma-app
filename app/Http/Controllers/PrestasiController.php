<?php

namespace App\Http\Controllers;

use App\Models\M_Anggota;
use App\Models\M_Prestasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index() {
        $prestasi = M_Prestasi::with('anggota')->get();
        return view('Prestasi.index', compact('prestasi'));
    }

    public function create() {
        $anggota = M_Anggota::all();

        return view('Prestasi.create', compact('anggota'));
    }

    public function store(Request $request) {
        // Validasi input data
        $request->validate([
            'id_anggota' => 'required|exists:t_anggota,id',
            'nama_prestasi' => 'required|string|max:255',
            'jenis_prestasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto_prestasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024' // Max size 1MB
        ], [
            'id_anggota.exists' => 'Anggota yang dipilih tidak valid.',
            'foto_prestasi.mimes' => 'Format file harus berupa pdf, jpg, jpeg, atau png.',
            'foto_prestasi.max' => 'Ukuran file maksimal 1MB.',
        ]);

        // Ambil data dari request
        $data = $request->all();

        // Kelola file unggahan 'foto_prestasi', jika ada
        if ($request->hasFile('foto_prestasi')) {
            $data['foto_prestasi'] = $request->file('foto_prestasi')->store('uploads/foto_prestasi', 'public');
        }

        // Simpan data ke dalam tabel prestasi
        M_Prestasi::create($data);

        // Redirect ke halaman utama prestasi dengan pesan sukses
        return redirect('/prestasi')->with('success', 'Data prestasi berhasil disimpan.');
    }

    public function show_detail($id) {
        try {
            // Temukan prestasi dengan anggota dan keanggotaan terkait
            $prestasi = M_Prestasi::with(['anggota.keanggotaan' => function($query) {
                $query->where('status_keanggotaan', 'Aktif'); // Hanya keanggotaan dengan status aktif
            }])->findOrFail($id);

            // Set keanggotaan hanya ke item pertama, atau null jika tidak ada
            // $prestasi->anggota->keanggotaan = $prestasi->anggota->keanggotaan->first() ?? null;

            // Log::log('pesan: '.$prestasi);

            return response()->json($prestasi);
        } catch (Exception $e) {
            Log::error("Error memuat data prestasi: " . $e->getMessage());
            return response()->json(['error' => 'Gagal memuat data prestasi.'], 500);
        }
    }

    public function show_edit($id) {
        $prestasi = M_Prestasi::findOrFail($id);
        $anggota = M_Anggota::all();

        return view('Prestasi.edit', compact('prestasi', 'anggota'));
    }

    public function update(Request $request, $id) {
        $prestasi = M_Prestasi::findOrFail($id);

        // Validasi input
        $request->validate([
            'id_anggota' => 'required|exists:t_anggota,id',
            'nama_prestasi' => 'required|string|max:255',
            'jenis_prestasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'foto_prestasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024' // 1MB max
        ]);

        // Siapkan data yang akan diupdate
        $data = $request->all();

        // Mengelola file jika ada file baru
        if ($request->hasFile('foto_prestasi')) {
            // Hapus file lama jika ada
            if ($prestasi->foto_prestasi && Storage::disk('public')->exists($prestasi->foto_prestasi)) {
                Storage::disk('public')->delete($prestasi->foto_prestasi);
            }

            // Simpan file baru
            $data['foto_prestasi'] = $request->file('foto_prestasi')->store('uploads/foto_prestasi', 'public');
        }

        // Update data prestasi
        $prestasi->update($data);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect('/prestasi')->with('success', 'Data prestasi berhasil diperbarui.');
    }

    public function delete($id) {
        $prestasi = M_Prestasi::findOrFail($id);

        // Hapus file foto_prestasi jika ada
        if ($prestasi->foto_prestasi && Storage::disk('public')->exists($prestasi->foto_prestasi)) {
            Storage::disk('public')->delete($prestasi->foto_prestasi);
        }

        // Hapus data prestasi dari database
        $prestasi->delete();

        // Redirect kembali ke halaman utama dengan pesan sukses
        return redirect('/prestasi')->with('success', 'Data prestasi berhasil dihapus.');
    }
}
