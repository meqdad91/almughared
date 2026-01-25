<?php

namespace Database\Seeders;

use App\Models\Qa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class QaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Qa::create([
            'name' => 'QA User',
            'email' => 'qa@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}
