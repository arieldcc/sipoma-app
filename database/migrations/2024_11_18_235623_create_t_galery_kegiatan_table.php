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
        Schema::create('t_galery_kegiatan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key menggunakan UUID
            $table->uuid('id_kegiatan'); // Foreign key ke tabel kegiatan
            $table->string('gambar_galery'); // File gambar galeri kegiatan
            $table->timestamps();

            // Definisi foreign key untuk id_kegiatan
            $table->foreign('id_kegiatan')->references('id')->on('t_kegiatan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_galery_kegiatan');
    }
};
