<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'tags' => 'laravel,php,software',
            'company' => fake()->company(),
            'email' => fake()->companyEmail(),
            'location' => fake()->city(),
            'website' => fake()->url(),
            'description' => fake()->paragraph(5),
        ];
    }
}
