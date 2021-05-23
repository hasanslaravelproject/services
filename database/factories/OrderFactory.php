<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->uuid,
            'delivery_date' => $this->faker->dateTime,
            'quantity' => $this->faker->text(255),
            'status' => $this->faker->text(255),
            'user_id' => \App\Models\User::factory(),
            'product_id' => \App\Models\Product::factory(),
        ];
    }
}
