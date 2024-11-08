<?php

namespace Database\Factories;

use App\Models\SittingRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sitting_request_id' => SittingRequest::factory(),
            'sitter_id' => User::factory(),
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']),
            'message' => $this->faker->realText(),
        ];
    }
}
