<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Package::class;

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
            'validity' => $this->faker->dateTime,
            'status' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'company_id' => \App\Models\Company::factory(),
            'package_type_id' => \App\Models\PackageType::factory(),
        ];
    }
}
