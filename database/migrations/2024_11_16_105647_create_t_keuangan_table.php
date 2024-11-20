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
        Schema::create('t_keuangan', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Primary key
            $table->uuid('id_anggota'); // anggota yang bertugas di keuangan
            $table->string('nama_transaksi', 200)->nullable(); // Deskripsi atau keterangan transaksi
            $table->date('tanggal_transaksi'); // Tanggal transaksi
            $table->enum('jenis_transaksi', ['Pemasukan', 'Pengeluaran']); // Jenis transaksi
            $table->decimal('jumlah', 15, 2); // Jumlah uang
            $table->string('sumber_dana')->nullable(); // Sumber dana atau asal uang
            $table->text('keterangan')->nullable(); // Deskripsi atau keterangan transaksi
            $table->string('bukti_transaksi', 200)->nullable(); // Bukti transaksi berupa file gambar maupun pdf

            $table->foreign('id_anggota')->references('id')->on('t_anggota')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_keuangan');
    }
};
