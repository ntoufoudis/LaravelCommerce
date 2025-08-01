<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            $user = User::factory()->create();
            $user->assignRole('customer');
        }
    }
}
