<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Prestasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_prestasi'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key menggunakan UUID
    public $incrementing = false; // UUID tidak auto-increment
    protected $keyType = 'string'; // UUID bertipe string

    protected $fillable = [
        'id_anggota',
        'nama_prestasi',
        'jenis_prestasi',
        'tanggal',
        'keterangan',
        'foto_prestasi',
    ];

    /**
     * Relasi ke model M_Anggota.
     * Setiap prestasi dimiliki oleh satu anggota.
     */
    public function anggota(){
        return $this->belongsTo(M_Anggota::class, 'id_anggota');
    }
}
