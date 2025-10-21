<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Artist;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artist>
 */
class ArtistFactory extends Factory
{
    use RefreshDatabase; // FONTOS!
		
		protected $model = Artist::class;

		/**
		 * Define the model's default state.
		 *
		 * @return array<string, mixed>
		 */
		public function definition()
		{
			return [
				'name' => $this->faker->unique()->word(),
			];
		}
}
