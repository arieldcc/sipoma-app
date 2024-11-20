<?php

namespace Database\Seeders;

use App\Models\M_Anggota;
use App\Models\M_Keanggotaan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class AnggotaKeanggotaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 1000; $i++) {
            // Insert data anggota
            $anggota = M_Anggota::create([
                'id' => Str::uuid(),
                'no_anggota' => 'A' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nama' => $faker->name,
                'j_kel' => $faker->randomElement(['l', 'p']),
                'agama' => $faker->randomElement(['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu']),
                'tanggal_lahir' => $faker->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
                'email' => $faker->unique()->safeEmail,
                'no_telepon' => $faker->phoneNumber,
                'alamat_jalan' => $faker->streetAddress,
                'alamat_kelurahan' => $faker->citySuffix,
                'alamat_kecamatan' => $faker->streetSuffix,
                'alamat_kota' => $faker->city,
                'alamat_provinsi' => $faker->state,
                'kode_pos' => $faker->postcode,
                'angkatan_anggota' => $faker->year,
                'kampus' => 'Universitas ' . $faker->city,
                'program_studi' => 'Program Studi ' . $faker->word,
                'angkatan_mahasiswa' => $faker->year,
                'foto_anggota' => null, // Bisa diatur sesuai kebutuhan
            ]);

            // Insert data keanggotaan
            M_Keanggotaan::create([
                'id' => Str::uuid(),
                'id_anggota' => $anggota->id,
                'status_keanggotaan' => $faker->randomElement(['Aktif', 'Non-Aktif', 'Alumni', 'Calon']),
                'tanggal_bergabung' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                'tanggal_keluar' => $faker->optional()->dateTimeBetween('-1 years', 'now')?->format('Y-m-d'), // Perbaikan di sini
                'keterangan' => $faker->sentence,
            ]);
        }
    }
}
