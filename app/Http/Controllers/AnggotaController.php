<?php

namespace App\Http\Controllers;

use App\Models\M_Anggota;
use App\Models\M_Keanggotaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    public function index() {
        $data = M_Anggota::all();
        return view('Anggota.index', compact('data'));
    }

    public function create() {
        return view('Anggota.create');
    }

    public function store(Request $request) {
        // Validasi input data
        $request->validate([
            // Validasi data anggota
            // 'no_anggota' => 'required|unique:t_anggota|max:20',
            'nama' => 'required|string|max:255',
            'j_kel' => 'required|in:l,p',
            'agama' => 'required|in:islam,kristen,katolik,hindu,budha,konghucu',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:t_anggota|max:255',
            'no_telepon' => 'nullable|string|max:15',
            'alamat_jalan' => 'nullable|string|max:255',
            'alamat_kelurahan' => 'nullable|string|max:255',
            'alamat_kecamatan' => 'nullable|string|max:255',
            'alamat_kota' => 'nullable|string|max:255',
            'alamat_provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'angkatan_anggota' => 'required|string|max:10',
            'kampus' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'angkatan_mahasiswa' => 'required|string|max:10',
            'foto_anggota' => 'nullable|file|mimes:jpg,jpeg,png|max:1024', // Maksimal 1MB

            // Validasi data keanggotaan
            'status_keanggotaan' => 'required|in:Calon,Aktif,Non-Aktif,Alumni',
            'tanggal_bergabung' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Generate no_anggota in the format 'A0000'
        $dataAnggota['no_anggota'] = M_Anggota::generateNoAnggota();

        // Prepare anggota data excluding keanggotaan data
        $dataAnggota = array_merge(
            $request->only([
                'nama', 'j_kel', 'agama', 'tanggal_lahir', 'email',
                'no_telepon', 'alamat_jalan', 'alamat_kelurahan', 'alamat_kecamatan',
                'alamat_kota', 'alamat_provinsi', 'kode_pos', 'angkatan_anggota',
                'kampus', 'program_studi', 'angkatan_mahasiswa'
            ]),
            ['no_anggota' => M_Anggota::generateNoAnggota()]
        );

        // Kelola file upload untuk 'foto_anggota' jika ada
        if ($request->hasFile('foto_anggota')) {
            $dataAnggota['foto_anggota'] = $request->file('foto_anggota')->store('uploads/foto_anggota', 'public');
        }

        // Simpan data anggota
        $anggota = M_Anggota::create($dataAnggota);

        // Simpan data keanggotaan dengan id_anggota yang baru saja dibuat
        M_Keanggotaan::create([
            'id_anggota' => $anggota->id,
            'status_keanggotaan' => $request->status_keanggotaan,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'keterangan' => $request->keterangan,
        ]);

        return redirect('/anggota')->with('success', 'Data anggota dan keanggotaan berhasil ditambahkan');
    }

    public function show_detail($id) {
        // Muat data anggota beserta relasi keanggotaan
        $anggota = M_Anggota::with('keanggotaan')->findOrFail($id);

        // Logging untuk memeriksa apakah data keanggotaan ikut termuat
        // Log::info('Data anggota dengan keanggotaan:', $anggota->toArray());

        return response()->json($anggota);
    }

    public function show_edit($id) {
        $anggota = M_Anggota::findOrFail($id);
        return view('Anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id) {
        // Cari anggota berdasarkan ID
        $anggota = M_Anggota::findOrFail($id);

        // Validasi data yang dikirim
        $request->validate([
            'no_anggota' => 'required|unique:t_anggota,no_anggota,' . $anggota->id . '|max:20',
            'nama' => 'required|string|max:255',
            'j_kel' => 'required|in:l,p',
            'agama' => 'required|in:islam,kristen,katolik,hindu,budha,konghucu',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:t_anggota,email,' . $anggota->id . '|max:255',
            'no_telepon' => 'nullable|string|max:15',
            'alamat_jalan' => 'nullable|string|max:255',
            'alamat_kelurahan' => 'nullable|string|max:255',
            'alamat_kecamatan' => 'nullable|string|max:255',
            'alamat_kota' => 'nullable|string|max:255',
            'alamat_provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'angkatan_anggota' => 'nullable|string|max:10',
            'kampus' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'angkatan_mahasiswa' => 'required|string|max:10',
            'foto_anggota' => 'nullable|file|mimes:jpg,jpeg,png|max:1024' // 1MB
        ]);

        // Ambil data yang telah divalidasi
        $data = $request->all();

        // Proses unggah foto anggota jika ada file baru
        if ($request->hasFile('foto_anggota')) {
            // Hapus file lama jika ada
            if ($anggota->foto_anggota && Storage::disk('public')->exists($anggota->foto_anggota)) {
                Storage::disk('public')->delete($anggota->foto_anggota);
            }

            // Simpan file baru
            $data['foto_anggota'] = $request->file('foto_anggota')->store('uploads/foto_anggota', 'public');
        }

        // Update data anggota di database
        $anggota->update($data);

        // Redirect ke halaman indeks dengan pesan sukses
        return redirect('/anggota')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function delete($id) {
        $anggota = M_Anggota::findOrFail($id);

        // Hapus foto anggota jika ada
        if ($anggota->foto_anggota && Storage::disk('public')->exists($anggota->foto_anggota)) {
            Storage::disk('public')->delete($anggota->foto_anggota);
        }

        // Hapus data anggota
        $anggota->delete();

        // Redirect kembali ke halaman data anggota dengan pesan sukses
        return redirect('/anggota')->with('success', 'Data anggota berhasil dihapus.');
    }
}
