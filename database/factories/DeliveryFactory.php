<?php

namespace Database\Factories;

use App\Models\Delivery;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Delivery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->text(255),
            'order_id' => \App\Models\Order::factory(),
            'production_id' => \App\Models\Production::factory(),
        ];
    }
}
