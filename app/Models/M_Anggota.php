<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Anggota extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_anggota';
    protected $primaryKey = 'id';
    public $incrementing = false; // Since UUIDs are not auto-incrementing
    protected $keyType = 'string'; // UUIDs are strings

    // app/Models/M_Anggota.php
    protected $fillable = [
        'no_anggota', 'nama', 'j_kel', 'agama', 'tanggal_lahir', 'email',
        'no_telepon', 'alamat_jalan', 'alamat_kelurahan', 'alamat_kecamatan',
        'alamat_kota', 'alamat_provinsi', 'kode_pos', 'angkatan_anggota',
        'kampus', 'program_studi', 'angkatan_mahasiswa', 'foto_anggota'
    ];

    /**
     * Relasi ke model Keanggotaan
     */
    public function keanggotaan(){
        return $this->hasOne(M_Keanggotaan::class, 'id_anggota');
    }

    public function pengurus(){
        return $this->hasMany(M_Pengurus::class, 'id_anggota');
    }

    // Tambahkan relasi kepanitiaan di sini
    public function kepanitiaan() {
        return $this->hasMany(M_Kepanitiaan::class, 'id_anggota');
    }

    public function keuangan() {
        return $this->hasMany(M_Keuangan::class, 'id_anggota');
    }

    public function prestasi() {
        return $this->hasMany(M_Prestasi::class, 'id_anggota');
    }

    /**
     * Generate a new member number with the format A0000.
     *
     * @return string
     */
    public static function generateNoAnggota()
    {
        // Retrieve the latest member number
        $lastMember = self::orderByDesc('no_anggota')->first();

        if ($lastMember) {
            // Extract numeric part from the last member number
            $lastNumber = (int)substr($lastMember->no_anggota, 1);
            // Increment and format the next number as four digits with a leading 'A'
            return 'A' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        }

        // Default start number if no records exist
        return 'A0001';
    }

}
