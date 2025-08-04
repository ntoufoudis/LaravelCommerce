<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 1, 4),
            'short_description' => $this->faker->text(),
            'sku' => $this->faker->uuid(),
            'featured' => $this->faker->boolean(),
            'status' => $this->faker->randomElement(['draft', 'pending', 'private', 'publish']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
