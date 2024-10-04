<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'imageurl' => $this->faker->imageUrl(),
            'nama' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'deskripsi' => $this->faker->sentence(2),
            'harga' => $this->faker->numberBetween(1000, 10000),
            'stok' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
