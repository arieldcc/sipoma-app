<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Keanggotaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_keanggotaan'; // Nama tabel di database
    protected $primaryKey = 'id';
    public $incrementing = false; // Karena menggunakan UUID
    protected $keyType = 'string'; // Tipe primary key adalah string (UUID)

    protected $fillable = [
        'id_anggota',
        'status_keanggotaan',
        'tanggal_bergabung',
        'tanggal_keluar',
        'keterangan'
    ];

    /**
     * Relasi ke model Anggota
     */
    public function anggota(){
        return $this->belongsTo(M_Anggota::class, 'id_anggota');
    }
}
