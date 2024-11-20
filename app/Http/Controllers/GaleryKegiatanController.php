<?php

namespace App\Http\Controllers;

use App\Models\M_GaleryKegiatan;
use App\Models\M_Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleryKegiatanController extends Controller
{
    public function index() {
        // Ambil semua data kegiatan beserta relasi galery
        $kegiatan = M_Kegiatan::with('galery')->get();

        return view('Galery.index', compact('kegiatan'));
    }

    public function create(){
        // Ambil daftar kegiatan untuk dropdown
        $kegiatan = M_Kegiatan::all();
        return view('Galery.create', compact('kegiatan'));
    }

    public function store(Request $request) {
        // Validasi input data
        $request->validate([
            'id_kegiatan' => 'required|exists:t_kegiatan,id',
            'gambar_galery' => 'required|array', // Pastikan gambar_galery adalah array (untuk beberapa file)
            'gambar_galery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Setiap gambar maksimal 2MB
        ], [
            'id_kegiatan.exists' => 'Kegiatan yang dipilih tidak valid.',
            'gambar_galery.required' => 'Setidaknya satu gambar harus diunggah.',
            'gambar_galery.*.image' => 'Setiap file harus berupa gambar.',
            'gambar_galery.*.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'gambar_galery.*.max' => 'Setiap gambar maksimal berukuran 2MB.'
        ]);

        // Loop untuk setiap gambar yang diunggah
        foreach ($request->file('gambar_galery') as $file) {
            // Simpan gambar ke folder 'uploads/galery' di disk publik
            $path = $file->store('uploads/galery', 'public');

            // Simpan data ke database
            M_GaleryKegiatan::create([
                'id_kegiatan' => $request->id_kegiatan,
                'gambar_galery' => $path
            ]);
        }

        // Redirect ke halaman galeri dengan pesan sukses
        return redirect('/galery')->with('success', 'Galeri kegiatan berhasil ditambahkan.');
    }

    public function delete($id){
        // Temukan data galeri berdasarkan ID
        $galeryItem = M_GaleryKegiatan::findOrFail($id);

        // Hapus gambar dari penyimpanan
        if (Storage::disk('public')->exists($galeryItem->gambar_galery)) {
            Storage::disk('public')->delete($galeryItem->gambar_galery);
        }

        // Hapus data galeri dari database
        $galeryItem->delete();

        // Redirect dengan pesan sukses
        return redirect('/galery')->with('success', 'Gambar berhasil dihapus dari galeri.');
    }
}
