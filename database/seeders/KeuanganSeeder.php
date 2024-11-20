<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\M_Anggota;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ambil semua id anggota dari tabel anggota
        $anggotaIds = M_Anggota::pluck('id')->toArray();

        for ($i = 0; $i < 1000; $i++) {
            DB::table('t_keuangan')->insert([
                'id' => Str::uuid(),
                'id_anggota' => $faker->randomElement($anggotaIds),
                'nama_transaksi' => $faker->sentence(3),
                'tanggal_transaksi' => $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
                'jenis_transaksi' => $faker->randomElement(['Pemasukan', 'Pengeluaran']),
                'jumlah' => $faker->randomFloat(2, 1000, 50000), // nilai antara 1000 sampai 50000
                'sumber_dana' => $faker->company,
                'keterangan' => $faker->sentence,
                'bukti_transaksi' => $faker->optional()->imageUrl(640, 480, 'business', true, 'transaction'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
