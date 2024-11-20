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
        Schema::create('t_kepanitiaan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key menggunakan UUID
            $table->uuid('id_anggota'); // UUID untuk foreign key ke t_anggota
            $table->uuid('id_kegiatan'); // UUID untuk foreign key ke t_kegiatan
            $table->string('jabatan'); // Jabatan atau peran dalam kepanitiaan
            $table->text('tugas')->nullable(); // Tugas atau deskripsi pekerjaan
            $table->text('keterangan')->nullable(); // Keterangan tambahan
            $table->timestamps();

            // Definisikan foreign key dengan UUID
            $table->foreign('id_anggota')->references('id')->on('t_anggota')->onDelete('cascade');
            $table->foreign('id_kegiatan')->references('id')->on('t_kegiatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_kepanitiaan');
    }
};
