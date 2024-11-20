<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_Anggota;
use App\Models\M_Kegiatan;
use App\Models\M_Kepanitiaan;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class KepanitiaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua kegiatan yang tersedia
        $kegiatans = M_Kegiatan::all();

        foreach ($kegiatans as $kegiatan) {
            // Ambil 25 anggota acak dari tabel anggota untuk setiap kegiatan
            $anggotaList = M_Anggota::inRandomOrder()->take(25)->get();

            foreach ($anggotaList as $anggota) {
                M_Kepanitiaan::create([
                    'id' => Str::uuid(),
                    'id_anggota' => $anggota->id,
                    'id_kegiatan' => $kegiatan->id,
                    'jabatan' => $faker->jobTitle,
                    'tugas' => $faker->sentence,
                    'keterangan' => $faker->optional()->sentence,
                ]);
            }
        }
    }
}
