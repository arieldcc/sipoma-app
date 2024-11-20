<?php

namespace App\Http\Controllers;

use App\Models\M_Anggota;
use App\Models\M_Pengurus;
use App\Models\M_Periode;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index() {
        $data = M_Pengurus::with('anggota.keanggotaan')->get();

        return view('Pengurus.index', compact('data'));
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

        // Ambil data periode
        $periode = M_Periode::all();

        return view('Pengurus.create', compact('anggota', 'periode'));
    }

    public function store(Request $request) {
        $request->validate([
            'id_anggota' => 'required|exists:t_anggota,id',
            'id_periode' => 'required|exists:t_periode,id',
            'jabatan' => 'required|string|max:255',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'nullable|date|after_or_equal:periode_mulai',
            'status_pengurus' => 'required|in:Aktif,Non-Aktif,Selesai',
            'keterangan' => 'nullable|string'
        ]);

        M_Pengurus::create([
            'id_anggota' => $request->id_anggota,
            'id_periode' => $request->id_periode,
            'jabatan' => $request->jabatan,
            'periode_mulai' => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'status_pengurus' => $request->status_pengurus,
            'keterangan' => $request->keterangan
        ]);

        return redirect('/pengurus')->with('success', 'Pengurus baru berhasil ditambahkan.');
    }

    public function show_detail($id) {
        $pengurus = M_Pengurus::with(['anggota.keanggotaan', 'periode'])->findOrFail($id);
        return response()->json($pengurus);
    }

    public function show_edit($id) {
        $pengurus = M_Pengurus::with('anggota.keanggotaan')->findOrFail($id);
        // Ambil anggota dengan status keanggotaan "Aktif" yang bukan pengurus aktif
        $anggota = M_Anggota::whereHas('keanggotaan', function($query) {
            $query->where('status_keanggotaan', 'Aktif');
        })->whereDoesntHave('pengurus', function($query) {
            $query->where('status_pengurus', 'Aktif');
        })->orWhere('id', $pengurus->id_anggota) // Tambahkan anggota yang sedang diedit
        ->get();

        $periode = M_Periode::all();

        return view('Pengurus.edit', compact('pengurus', 'anggota', 'periode'));
    }

    public function update(Request $request, $id) {
        // Validasi input
        $request->validate([
            'id_anggota' => 'required|exists:t_anggota,id',
            'jabatan' => 'required|string|max:255',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'nullable|date|after_or_equal:periode_mulai',
            'status_pengurus' => 'required|in:Aktif,Non-Aktif',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'periode_selesai.after_or_equal' => 'Periode selesai harus sama atau setelah periode mulai.',
        ]);

        // Temukan data pengurus berdasarkan ID
        $pengurus = M_Pengurus::findOrFail($id);

        // Update data pengurus
        $pengurus->update([
            'id_anggota' => $request->id_anggota,
            'jabatan' => $request->jabatan,
            'periode_mulai' => $request->periode_mulai,
            'periode_selesai' => $request->periode_selesai,
            'status_pengurus' => $request->status_pengurus,
            'keterangan' => $request->keterangan,
        ]);

        // Redirect kembali ke halaman data pengurus dengan pesan sukses
        return redirect('/pengurus')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function delete($id) {
        // Temukan data pengurus berdasarkan ID
        $pengurus = M_Pengurus::findOrFail($id);

        // Hapus data pengurus
        $pengurus->delete();

        // Redirect kembali ke halaman data pengurus dengan pesan sukses
        return redirect('/pengurus')->with('success', 'Data pengurus berhasil dihapus.');
    }
}
