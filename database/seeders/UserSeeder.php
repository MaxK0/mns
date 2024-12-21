<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'login' => 'adminka',
            'email' => 'admin@admin.com',
            'phone' => '9999999999',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        User::factory(10)->create();
    }
}
