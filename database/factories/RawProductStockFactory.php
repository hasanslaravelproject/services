<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\RawProductStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class RawProductStockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RawProductStock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->randomNumber,
            'expiry_date' => $this->faker->dateTime,
            'ingredient_id' => \App\Models\Ingredient::factory(),
        ];
    }
}
