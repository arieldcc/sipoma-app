<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(AnggotaKeanggotaanSeeder::class);
        $this->call(KegiatanSeeder::class);
        $this->call(PengurusSeeder::class);
        $this->call(KepanitiaanSeeder::class);
        $this->call(PrestasiSeeder::class);
        $this->call(KeuanganSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
