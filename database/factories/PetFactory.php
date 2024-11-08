<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Pet;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Pet::class;

    public function definition()
    {
        return [
            'owner_id' => User::factory(),
            'name' => $this->faker->firstName(),
            'species' => $this->faker->randomElement(['Dog', 'Cat', 'Other']),
            'description' => $this->faker->paragraph(),
        ];
    }
}
