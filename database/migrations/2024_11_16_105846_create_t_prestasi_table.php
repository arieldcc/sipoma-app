<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_prestasi', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key
            $table->uuid('id_anggota');
            $table->string('nama_prestasi'); // Nama prestasi atau penghargaan
            $table->string('jenis_prestasi')->nullable(); // Jenis prestasi (akademik, non-akademik, dll)
            $table->date('tanggal'); // Tanggal prestasi diraih
            $table->text('keterangan')->nullable(); // Deskripsi atau keterangan tambahan
            $table->string('foto_prestasi')->nullable(); // Dokumentasi prestasi berupa file pdf/gambar
            $table->timestamps();

            $table->foreign('id_anggota')->references('id')->on('t_anggota')->onDelete('cascade'); // Relasi ke tabel anggota
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_prestasi');
    }
};
