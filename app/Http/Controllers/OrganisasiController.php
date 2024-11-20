<?php

namespace App\Http\Controllers;

use App\Models\M_Organisasi;
use App\Models\M_Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganisasiController extends Controller
{
    public function index() {
        $organisasi = M_Organisasi::with('periode')->get();

        return view('Organisasi.index', compact('organisasi'));
    }

    public function create() {
        $periode = M_Periode::all();
        return view('Organisasi.create', compact('periode'));
    }

    public function store(Request $request) {
        // Validasi input
        $request->validate([
            'id_periode' => 'required|exists:t_periode,id',
            'gambar_struktur' => 'required|file|mimes:jpg,jpeg,png|max:1024' // Maksimal 1MB
        ], [
            'id_periode.required' => 'Periode harus dipilih.',
            'gambar_struktur.required' => 'Gambar struktur organisasi harus diunggah.',
            'gambar_struktur.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar_struktur.max' => 'Ukuran gambar maksimal 1MB.'
        ]);

        // Simpan data
        $data = $request->only('id_periode');

        // Proses upload gambar struktur organisasi
        if ($request->hasFile('gambar_struktur')) {
            $data['gambar_struktur'] = $request->file('gambar_struktur')->store('uploads/struktur_organisasi', 'public');
        }

        // Simpan ke database
        M_Organisasi::create($data);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect('/organisasi')->with('success', 'Struktur organisasi berhasil ditambahkan.');
    }

    public function show_detail($id) {
        // Ambil data organisasi berdasarkan ID, termasuk data relasi periode
        $organisasi = M_Organisasi::with('periode')->findOrFail($id);

        // Return data sebagai JSON untuk digunakan pada tampilan detail (modal)
        return response()->json($organisasi);
    }

    public function show_edit($id) {
        $organisasi = M_Organisasi::with('periode')->findOrFail($id);

        $periode = M_Periode::all();
        return view('Organisasi.edit', compact('organisasi', 'periode'));
    }

    public function update(Request $request, $id){
        // Validasi input
        $request->validate([
            'id_periode' => 'required|exists:t_periode,id',
            'gambar_struktur' => 'nullable|file|mimes:jpg,jpeg,png|max:1024' // Max size 1MB
        ], [
            'id_periode.required' => 'Periode wajib dipilih.',
            'id_periode.exists' => 'Periode yang dipilih tidak valid.',
            'gambar_struktur.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
            'gambar_struktur.max' => 'Ukuran gambar maksimal 1MB.',
        ]);

        // Temukan data organisasi berdasarkan ID
        $organisasi = M_Organisasi::findOrFail($id);

        // Perbarui data periode
        $organisasi->id_periode = $request->id_periode;

        // Periksa apakah ada file gambar struktur baru yang diunggah
        if ($request->hasFile('gambar_struktur')) {
            // Hapus gambar lama jika ada
            if ($organisasi->gambar_struktur && Storage::exists('public/' . $organisasi->gambar_struktur)) {
                Storage::delete('public/' . $organisasi->gambar_struktur);
            }

            // Simpan gambar struktur baru
            $organisasi->gambar_struktur = $request->file('gambar_struktur')->store('uploads/struktur_organisasi', 'public');
        }

        // Simpan perubahan
        $organisasi->save();

        // Redirect dengan pesan sukses
        return redirect('/organisasi')->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    public function delete($id) {
        // Temukan data organisasi berdasarkan ID
        $organisasi = M_Organisasi::findOrFail($id);

        // Hapus gambar struktur jika ada
        if ($organisasi->gambar_struktur && Storage::exists('public/' . $organisasi->gambar_struktur)) {
            Storage::delete('public/' . $organisasi->gambar_struktur);
        }

        // Hapus data organisasi
        $organisasi->delete();

        // Redirect kembali ke halaman utama organisasi dengan pesan sukses
        return redirect('/organisasi')->with('success', 'Data struktur organisasi berhasil dihapus.');
    }

    public function showStrukturOrganisasi(Request $request) {
        // Fetch periods for the dropdown
        $periods = M_Periode::all();

        // Get the active period by default, or the selected period from the request
        $selectedPeriodId = $request->input('id_periode') ?? M_Periode::where('status_periode', 'A')->value('id');

        // Fetch organizational structure for the selected period
        $strukturOrganisasi = M_Organisasi::where('id_periode', $selectedPeriodId)->with('periode')->first();

        return view('Organisasi.struktur', compact('periods', 'strukturOrganisasi', 'selectedPeriodId'));
    }
}
