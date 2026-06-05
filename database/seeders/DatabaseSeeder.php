<?php

namespace Database\Seeders;

use App\Models\Sample;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Sample::factory(10)->create();

        Sample::factory()->create([
            'name' => 'Test Sample',
            'email' => 'test@example.com',
        ]);
    }
}
