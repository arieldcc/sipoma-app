<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Organisasi extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_organisasi'; // Nama tabel di database
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID tidak auto-increment
    protected $keyType = 'string'; // Tipe primary key adalah string (UUID)

    protected $fillable = [
        'id_periode',
        'gambar_struktur'
    ];

    /**
     * Relasi ke model M_Periode.
     * Setiap organisasi terhubung dengan satu periode.
     */
    public function periode()
    {
        return $this->belongsTo(M_Periode::class, 'id_periode');
    }
}
