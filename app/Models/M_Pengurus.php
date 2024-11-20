<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_Pengurus extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_pengurus';
    protected $primaryKey = 'id';
    public $incrementing = false; // Karena menggunakan UUID
    protected $keyType = 'string'; // Tipe primary key adalah string (UUID)

    protected $fillable = [
        'id_anggota',
        'id_periode',
        'jabatan',
        'periode_mulai',
        'periode_selesai',
        'status_pengurus',
        'keterangan'
    ];

    /**
     * Relasi ke model M_Anggota.
     * Setiap pengurus terhubung ke satu anggota.
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(M_Anggota::class, 'id_anggota');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(M_Periode::class, 'id_periode');
    }

}
