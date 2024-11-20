<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\M_Anggota;
use App\Models\M_Periode;
use App\Models\M_Pengurus;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PengurusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua periode yang tersedia
        $periodes = M_Periode::all();

        foreach ($periodes as $periode) {
            // Ambil 50 anggota acak dari tabel anggota untuk setiap periode
            $anggotaList = M_Anggota::inRandomOrder()->take(50)->get();

            foreach ($anggotaList as $anggota) {
                M_Pengurus::create([
                    'id' => Str::uuid(),
                    'id_anggota' => $anggota->id,
                    'id_periode' => $periode->id,
                    'jabatan' => $faker->jobTitle,
                    'periode_mulai' => $faker->dateTimeBetween('-5 years', '-1 years')->format('Y-m-d'),
                    'periode_selesai' => $faker->optional()->dateTimeBetween('-1 years', 'now')?->format('Y-m-d'),
                    'status_pengurus' => $faker->randomElement(['Aktif', 'Non-Aktif', 'Selesai']),
                    'keterangan' => $faker->sentence,
                ]);
            }
        }
    }
}
