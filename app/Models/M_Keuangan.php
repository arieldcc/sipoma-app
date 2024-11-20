<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Keuangan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_keuangan'; // Nama tabel di database
    protected $primaryKey = 'id';
    public $incrementing = false; // Menggunakan UUID sebagai primary key
    protected $keyType = 'string'; // UUID bertipe string

    protected $fillable = [
        'id_anggota',
        'nama_transaksi',
        'tanggal_transaksi',
        'jenis_transaksi',
        'jumlah',
        'sumber_dana',
        'keterangan',
        'bukti_transaksi'
    ];

    /**
     * Relasi ke model Anggota.
     * Setiap transaksi keuangan terkait dengan satu anggota.
     */
    public function anggota(){
        return $this->belongsTo(M_Anggota::class, 'id_anggota');
    }
}
