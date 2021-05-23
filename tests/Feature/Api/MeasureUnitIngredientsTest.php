<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Ingredient;
use App\Models\MeasureUnit;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeasureUnitIngredientsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_measure_unit_ingredients()
    {
        $measureUnit = MeasureUnit::factory()->create();
        $ingredients = Ingredient::factory()
            ->count(2)
            ->create([
                'measure_unit_id' => $measureUnit->id,
            ]);

        $response = $this->getJson(
            route('api.measure-units.ingredients.index', $measureUnit)
        );

        $response->assertOk()->assertSee($ingredients[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_measure_unit_ingredients()
    {
        $measureUnit = MeasureUnit::factory()->create();
        $data = Ingredient::factory()
            ->make([
                'measure_unit_id' => $measureUnit->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.measure-units.ingredients.store', $measureUnit),
            $data
        );

        $this->assertDatabaseHas('ingredients', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $ingredient = Ingredient::latest('id')->first();

        $this->assertEquals($measureUnit->id, $ingredient->measure_unit_id);
    }
}
