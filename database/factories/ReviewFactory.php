<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SittingRequest;
use App\Models\Review;
use App\Models\User;
use App\Models\Pet;
use App\Models\Application;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Review::class;

    public function definition()
    {
        return [
        'application_id' => Application::factory()->create()->id,
        'rating' => $this->faker->numberBetween(1, 5),
        'comment' => $this->faker->sentence(),
        ];
    }
}
