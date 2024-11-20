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
        Schema::create('t_kegiatan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key
            $table->string('nama_kegiatan'); // Nama kegiatan
            $table->text('deskripsi')->nullable(); // Deskripsi kegiatan
            $table->date('tanggal_mulai_kegiatan'); // Tanggal kegiatan
            $table->date('tanggal_selesai_kegiatan')->nullable(); // tanggal selesai
            $table->string('tempat')->nullable(); // Tempat pelaksanaan kegiatan
            $table->string('penyelenggara')->nullable(); // Nama penyelenggara atau penanggung jawab
            $table->enum('status_kegiatan', ['Terjadwal', 'Selesai', 'Dibatalkan'])->default('Terjadwal'); // Status kegiatan
            $table->string('gambar_kegiatan', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_kegiatan');
    }
};
