<?php

namespace App\Http\Controllers;

use App\Models\M_Anggota;
use App\Models\M_Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeuanganController extends Controller
{
    public function index() {
        $keuangan = M_Keuangan::with('anggota')->get();

        return view('Keuangan.index', compact('keuangan'));
    }

    public function create() {
        $anggota = M_Anggota::all();

        return view('Keuangan.create', compact('anggota'));
    }

    public function store(Request $request) {
        // Validasi input data
        $request->validate([
            'id_anggota' => 'required|exists:t_anggota,id',
            'nama_transaksi' => 'required|string|max:200',
            'tanggal_transaksi' => 'required|date',
            'jenis_transaksi' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|min:0',
            'sumber_dana' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'bukti_transaksi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024', // Max size 1MB
        ], [
            'id_anggota.exists' => 'Anggota yang dipilih tidak valid.',
            'bukti_transaksi.mimes' => 'Format file bukti harus pdf, jpg, jpeg, atau png.',
            'bukti_transaksi.max' => 'Ukuran file bukti maksimal 1MB.',
        ]);

        // Ambil semua data dari request
        $data = $request->all();

        // Konversi format Rupiah ke nilai numerik untuk `jumlah`
        $data['jumlah'] = str_replace(['Rp ', '.'], '', $request->jumlah);

        // Kelola unggahan file bukti transaksi, jika ada
        if ($request->hasFile('bukti_transaksi')) {
            $data['bukti_transaksi'] = $request->file('bukti_transaksi')->store('uploads/bukti_transaksi', 'public');
        }

        // Simpan data ke dalam tabel keuangan
        M_Keuangan::create($data);

        // Redirect ke halaman utama keuangan dengan pesan sukses
        return redirect('/keuangan')->with('success', 'Data keuangan berhasil disimpan.');
    }

    public function show_detail($id) {
        $keuangan = M_Keuangan::with('anggota')->findOrFail($id);
        return response()->json($keuangan);
    }

    public function show_edit($id) {
        $anggota = M_Anggota::all();
        $keuangan = M_Keuangan::findOrFail($id);

        return view('Keuangan.edit', compact('anggota', 'keuangan'));
    }

    public function update(Request $request, $id) {
        $keuangan = M_Keuangan::findOrFail($id);

        // Validasi input data
        $request->validate([
            'id_anggota' => 'required|exists:t_anggota,id',
            'nama_transaksi' => 'required|string|max:200',
            'tanggal_transaksi' => 'required|date',
            'jenis_transaksi' => 'required|in:Pemasukan,Pengeluaran',
            'jumlah' => 'required|min:0',
            'sumber_dana' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'bukti_transaksi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024'
        ]);

        $data = $request->except(['jumlah']);

        // Update jumlah
        $data['jumlah'] = str_replace(['Rp ', '.'], '', $request->jumlah);

        // Update file bukti jika ada file baru
        if ($request->hasFile('bukti_transaksi')) {
            if ($keuangan->bukti_transaksi && Storage::disk('public')->exists($keuangan->bukti_transaksi)) {
                Storage::disk('public')->delete($keuangan->bukti_transaksi);
            }
            $data['bukti_transaksi'] = $request->file('bukti_transaksi')->store('uploads/bukti_transaksi', 'public');
        }

        $keuangan->update($data);

        return redirect('/keuangan')->with('success', 'Data keuangan berhasil diperbarui.');
    }

    public function delete($id) {
        // Cari data keuangan berdasarkan ID
        $keuangan = M_Keuangan::findOrFail($id);

        // Hapus file bukti transaksi jika ada
        if ($keuangan->bukti_transaksi && Storage::disk('public')->exists($keuangan->bukti_transaksi)) {
            Storage::disk('public')->delete($keuangan->bukti_transaksi);
        }

        // Hapus data keuangan
        $keuangan->delete();

        // Redirect kembali ke halaman keuangan dengan pesan sukses
        return redirect('/keuangan')->with('success', 'Data keuangan berhasil dihapus.');
    }
}
