<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\House;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = House::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'address' => $this->faker->address(),
            'description' => $this->faker->paragraph(),
        ];
    }
}
