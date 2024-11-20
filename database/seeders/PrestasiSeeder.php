<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_Anggota;
use App\Models\M_Prestasi;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua anggota yang tersedia
        $anggotaList = M_Anggota::all();

        // Looping untuk menghasilkan total 1500 prestasi
        for ($i = 0; $i < 1500; $i++) {
            // Pilih anggota acak untuk setiap prestasi
            $anggota = $anggotaList->random();

            M_Prestasi::create([
                'id' => Str::uuid(),
                'id_anggota' => $anggota->id,
                'nama_prestasi' => $faker->words(3, true),
                'jenis_prestasi' => $faker->randomElement(['Akademik', 'Non-Akademik', 'Olahraga', 'Seni']),
                'tanggal' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'keterangan' => $faker->optional()->sentence,
                'foto_prestasi' => $faker->optional()->imageUrl(640, 480, 'awards', true, 'prestasi'),
            ]);
        }
    }
}
