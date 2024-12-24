<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            [
                'title' => 'Общий клининг'
            ],
            [
                'title' => 'Генеральная уборка'
            ],
            [
                'title' => 'Послестроительная уборка'
            ],
            [
                'title' => 'Химчистка ковров и мебели'
            ],
        ]);
    }
}
