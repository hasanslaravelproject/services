<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'validity' => $this->faker->text(255),
            'barcode' => $this->faker->text(255),
            'package_id' => \App\Models\Package::factory(),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
