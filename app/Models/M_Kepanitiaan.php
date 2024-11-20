<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Kepanitiaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_kepanitiaan'; // Nama tabel
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID tidak auto-increment
    protected $keyType = 'string'; // UUID bertipe string

    protected $fillable = [
        'id_anggota',
        'id_kegiatan',
        'jabatan',
        'tugas',
        'keterangan',
    ];

    /**
     * Relasi ke model M_Anggota
     * Setiap kepanitiaan memiliki satu anggota.
     */
    public function anggota()
    {
        return $this->belongsTo(M_Anggota::class, 'id_anggota');
    }

    /**
     * Relasi ke model M_Kegiatan
     * Setiap kepanitiaan terkait dengan satu kegiatan.
     */
    public function kegiatan()
    {
        return $this->belongsTo(M_Kegiatan::class, 'id_kegiatan');
    }
}
