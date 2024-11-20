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
        Schema::create('t_anggota', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key menggunakan UUID
            $table->string('no_anggota')->unique();
            $table->string('nama');
            $table->set('j_kel', ['l','p']);
            $table->set('agama',['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu']);
            $table->date('tanggal_lahir');
            $table->string('email')->unique();
            $table->string('no_telepon')->nullable();
            $table->string('alamat_jalan')->nullable();
            $table->string('alamat_kelurahan')->nullable();
            $table->string('alamat_kecamatan')->nullable();
            $table->string('alamat_kota')->nullable();
            $table->string('alamat_provinsi')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('angkatan_anggota', 10)->nullable();
            $table->string('kampus');
            $table->string('program_studi');
            $table->string('angkatan_mahasiswa',10);
            $table->string('foto_anggota',200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_anggota');
    }
};
