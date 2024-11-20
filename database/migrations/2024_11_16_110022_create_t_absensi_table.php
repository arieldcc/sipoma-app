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
        Schema::create('t_absensi', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key
            $table->uuid('id_anggota');
            $table->uuid('id_kegiatan');
            $table->enum('status_kehadiran', ['Hadir', 'Tidak Hadir'])->default('Tidak Hadir'); // Status kehadiran
            $table->timestamp('waktu_kehadiran')->nullable(); // Waktu anggota hadir
            $table->timestamps();

            $table->foreign('id_anggota')->references('id')->on('t_anggota')->onDelete('cascade'); // Relasi ke tabel anggota
            $table->foreign('id_kegiatan')->references('id')->on('t_kegiatan')->onDelete('cascade'); // Relasi ke tabel kegiatan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_absensi');
    }
};
