<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Kegiatan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 't_kegiatan';
    protected $primaryKey = 'id';
    public $incrementing = false; // UUID tidak auto-increment
    protected $keyType = 'string'; // UUID bertipe string

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'tanggal_mulai_kegiatan',
        'tanggal_selesai_kegiatan',
        'tempat',
        'penyelenggara',
        'status_kegiatan',
        'gambar_kegiatan'
    ];

    /**
     * Saran pengembangan ke depan:
     * Jika nantinya ada keperluan untuk melacak peserta kegiatan atau pengurus yang terkait dengan kegiatan,
     * bisa dipertimbangkan untuk membuat tabel `t_peserta_kegiatan` atau `t_panitia_kegiatan` dengan relasi
     * ke tabel `t_kegiatan`.
     * Ini akan memudahkan dalam pengelolaan data secara struktural, misalnya untuk melihat siapa saja yang
     * terlibat dalam suatu kegiatan.
     */

     public function galery()
    {
        return $this->hasMany(M_GaleryKegiatan::class, 'id_kegiatan');
    }

}
