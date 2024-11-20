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
        Schema::create('t_keanggotaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_anggota')->constrained('t_anggota')->onDelete('cascade'); // Relasi ke tabel anggota
            $table->enum('status_keanggotaan', ['Aktif', 'Non-Aktif', 'Alumni', 'Calon']); // Status keanggotaan
            $table->date('tanggal_bergabung'); // Tanggal awal keanggotaan
            $table->date('tanggal_keluar')->nullable(); // Tanggal keluar (null jika masih aktif)
            $table->text('keterangan')->nullable(); // Keterangan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_keanggotaan');
    }
};
