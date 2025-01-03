<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $faker = \Faker\Factory::create('id_ID'); // Menggunakan lokal Indonesia

        // Loop untuk membuat 50 data dummy
        foreach (range(1, 50) as $index) {
            DB::table('guardians')->insert([
                'id' => str::ulid(),
                'nik' => $faker->unique()->numerify('################'), // 16 digit angka
                'name' => $faker->name,
                'phone_number' => $faker->optional()->phoneNumber,
                'address' => $faker->optional()->address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
