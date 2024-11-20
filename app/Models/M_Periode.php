<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Periode extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_periode';
    protected $primaryKey = 'id';
    public $incrementing = false; // Karena menggunakan UUID
    protected $keyType = 'string';

    protected $fillable = [
        'periode',
        'status_periode'
    ];

    /**
     * Relasi ke model M_Pengurus.
     * Setiap periode bisa memiliki banyak pengurus.
     */
    public function pengurus()
    {
        return $this->hasMany(M_Pengurus::class, 'id_periode');
    }

    public function organisasi() {
        return $this->hasMany(M_Organisasi::class, 'id_periode');
    }
}
