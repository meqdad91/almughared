<?php

// app/Traits/UserSeederTrait.php

namespace App\Traits;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

trait UserSeederTrait
{
    public function generateUserData($count = 5)
    {
        $users = [];

        for ($i = 1; $i <= $count; $i++) {
            $users[] = [
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $users;
    }
}
