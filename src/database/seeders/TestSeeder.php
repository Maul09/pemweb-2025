<?php

namespace Database\Seeders;
use App\Models\Test;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Test::firstOrCreate([
            'name' => 'Sample Test',
            'description' => 'This is a sample test description.',
        ]);
    }
}
