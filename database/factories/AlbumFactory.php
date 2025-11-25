<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'cover' => $this->faker->unique()->word(),
            'year' => $this->faker->unique()->word(),
            'genre' => $this->faker->unique()->word(),
            'artist_id' => Artist::factory(),
        ];
    }
}
