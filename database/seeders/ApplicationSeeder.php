<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = User::where('login', 'adminka')
            ->first()
            ->id;

        Application::factory(30)->create([
            'user_id' => $adminId
        ]);

        Application::factory(5)->create();
    }
}
