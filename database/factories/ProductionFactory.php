<?php

namespace Database\Factories;

use App\Models\Production;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Production::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'date' => $this->faker->dateTime,
            'validity' => $this->faker->text(255),
            'image' => $this->faker->text(255),
            'quanity' => $this->faker->text(255),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'order_id' => $this->faker->text(255),
            'product_id' => \App\Models\Product::factory(),
        ];
    }
}
