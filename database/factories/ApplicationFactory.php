<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition()
    {
        return [
            'address' => $this->faker->address(),
            'phone' => $this->faker->numerify('##########'),
            'receipt_date' => Carbon::tomorrow(),
            'payment_type' => $this->faker->numberBetween(0, 1),
            'status' => $this->faker->numberBetween(0, 2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'service_id' => Service::inRandomOrder()->first()->id,
        ];
    }
}
