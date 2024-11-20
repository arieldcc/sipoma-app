<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_Kegiatan;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 500; $i++) {
            M_Kegiatan::create([
                'id' => Str::uuid(),
                'nama_kegiatan' => $faker->sentence(3),
                'deskripsi' => $faker->paragraph,
                'tanggal_mulai_kegiatan' => $faker->dateTimeBetween('-2 years', '+1 years')->format('Y-m-d'),
                'tanggal_selesai_kegiatan' => $faker->optional()->dateTimeBetween('-1 years', '+1 years') ?
                    $faker->dateTimeBetween('-1 years', '+1 years')->format('Y-m-d') : null,
                'tempat' => $faker->city,
                'penyelenggara' => $faker->company,
                'status_kegiatan' => $faker->randomElement(['Terjadwal', 'Selesai', 'Dibatalkan']),
                'gambar_kegiatan' => $faker->optional()->imageUrl(640, 480, 'events', true, 'kegiatan'),
            ]);
        }
    }
}
