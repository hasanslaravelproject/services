<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\FinishedProductStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinishedProductStockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FinishedProductStock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->randomNumber,
            'validity' => $this->faker->text(255),
            'finished_product_stock_id' => function () {
                return \App\Models\FinishedProductStock::factory()->create([
                    'finished_product_stock_id' => null,
                ])->id;
            },
            'production_id' => \App\Models\Production::factory(),
        ];
    }
}
