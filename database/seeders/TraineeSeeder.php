<?php

namespace Database\Seeders;

use App\Models\Trainee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TraineeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trainee::create([
            'name' => 'Trainee User',
            'email' => 'trainee@test.com',
            'password' => Hash::make('password'),
        ]);
    }
}
