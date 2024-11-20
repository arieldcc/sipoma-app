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
        Schema::create('t_pengurus', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key
            $table->foreignUuid('id_anggota')->constrained('t_anggota')->onDelete('cascade'); // Relasi ke tabel anggota
            $table->foreignUuid('id_periode')->constrained('t_periode')->onDelete('cascade'); // Relasi ke tabel periode
            $table->string('jabatan'); // Jabatan atau posisi dalam organisasi
            $table->date('periode_mulai'); // Tanggal mulai menjabat
            $table->date('periode_selesai')->nullable(); // Tanggal selesai menjabat (nullable jika masih menjabat)
            $table->enum('status_pengurus', ['Aktif', 'Non-Aktif', 'Selesai'])->default('Aktif'); // Status pengurus (Aktif atau Non-Aktif)
            $table->text('keterangan')->nullable(); // Keterangan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_pengurus');
    }
};
