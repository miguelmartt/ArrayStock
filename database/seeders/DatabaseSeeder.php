<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Salvador',
            'email' => 'admin@arraystock.es',
        ]);

        $this->call([
            CategorySeeder::class,
        ]);
    }
}
