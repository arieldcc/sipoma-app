<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class M_GaleryKegiatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_galery_kegiatan';
    protected $primaryKey = 'id';
    public $incrementing = false; // Karena menggunakan UUID
    protected $keyType = 'string'; // Tipe primary key adalah string (UUID)

    protected $fillable = [
        'id_kegiatan',
        'gambar_galery'
    ];

    /**
     * Relasi ke model M_Kegiatan.
     * Setiap galeri terhubung dengan satu kegiatan.
     */
    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(M_Kegiatan::class, 'id_kegiatan');
    }
}
