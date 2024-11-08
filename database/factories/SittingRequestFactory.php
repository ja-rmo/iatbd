<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pet;
use App\Models\User;
use App\Models\SittingRequest;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SittingRequest>
 */
class SittingRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = SittingRequest::class;

    public function definition()
    {
        return [
            'pet_id' => Pet::factory(),
            'start_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'message' => $this->faker->paragraph(),
            'rate' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
