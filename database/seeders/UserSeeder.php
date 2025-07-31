<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Vasileios Ntoufoudis',
            'email' => 'info@ntoufoudis.com',
        ]);

        User::factory(50)->create();
    }
}
