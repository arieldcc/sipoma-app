<?php

namespace App\Http\Controllers;

use App\Models\M_Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index() {
        $data = M_Kegiatan::all();

        return view('Kegiatan.index', compact('data'));
    }

    public function create() {
        return view('Kegiatan.create');
    }

    public function store(Request $request){
        // Validasi input data
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai_kegiatan' => 'required|date',
            'tanggal_selesai_kegiatan' => 'nullable|date|after_or_equal:tanggal_mulai_kegiatan',
            'tempat' => 'nullable|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'status_kegiatan' => 'required|in:Terjadwal,Selesai,Dibatalkan',
            'gambar_kegiatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
        ], [
            'tanggal_selesai_kegiatan.after_or_equal' => 'Tanggal selesai kegiatan harus lebih lambat atau sama dengan tanggal mulai kegiatan.',
        ]);

        $data = $request->all();

        // Handle file upload for 'foto_anggota'
        if ($request->hasFile('gambar_kegiatan')) {
            $data['gambar_kegiatan'] = $request->file('gambar_kegiatan')->store('uploads/gambar_kegiatan', 'public');
        }

        M_Kegiatan::create($data);

        // Redirect ke halaman daftar kegiatan dengan pesan sukses
        return redirect('/kegiatan')->with('success', 'Data kegiatan berhasil disimpan.');
    }

    public function show_detail($id) {
        $kegiatan = M_Kegiatan::findOrFail($id);
        return response()->json($kegiatan);
    }

    public function show_edit($id) {
        $kegiatan = M_Kegiatan::findOrFail($id);
        return view('Kegiatan.edit', compact('kegiatan'));
    }

    public function update(Request $request, $id) {
        // Validasi input data
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai_kegiatan' => 'required|date',
            'tanggal_selesai_kegiatan' => 'nullable|date|after_or_equal:tanggal_mulai_kegiatan',
            'tempat' => 'nullable|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'status_kegiatan' => 'required|in:Terjadwal,Selesai,Dibatalkan',
            'gambar_kegiatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
        ], [
            'tanggal_selesai_kegiatan.after_or_equal' => 'Tanggal selesai kegiatan harus lebih lambat atau sama dengan tanggal mulai kegiatan.',
        ]);

        // Temukan kegiatan yang akan di-update
        $kegiatan = M_Kegiatan::findOrFail($id);

        // Ambil semua data request
        $data = $request->except(['gambar_kegiatan']); // Kecualikan gambar_kegiatan jika tidak di-upload

        // Jika ada file gambar baru yang diupload
        if ($request->hasFile('gambar_kegiatan')) {
            // Hapus file lama jika ada
            if ($kegiatan->gambar_kegiatan && Storage::disk('public')->exists($kegiatan->gambar_kegiatan)) {
                Storage::disk('public')->delete($kegiatan->gambar_kegiatan);
            }

            // Simpan file baru
            $data['gambar_kegiatan'] = $request->file('gambar_kegiatan')->store('uploads/gambar_kegiatan', 'public');
        }

        // Update data kegiatan
        $kegiatan->update($data);

        // Redirect ke halaman daftar kegiatan dengan pesan sukses
        return redirect('/kegiatan')->with('success', 'Data kegiatan berhasil diperbarui.');
    }

    public function delete($id) {
        $kegiatan = M_Kegiatan::findOrFail($id);

        // Hapus file gambar_kegiatan jika ada
        if ($kegiatan->gambar_kegiatan && Storage::disk('public')->exists($kegiatan->gambar_kegiatan)) {
            Storage::disk('public')->delete($kegiatan->gambar_kegiatan);
        }

        // Hapus data kegiatan dari database
        $kegiatan->delete();

        // Redirect kembali ke halaman daftar kegiatan dengan pesan sukses
        return redirect('/kegiatan')->with('success', 'Data kegiatan berhasil dihapus.');
    }
}
