<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Ingredient;

use App\Models\MeasureUnit;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientTest extends TestCase
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
    public function it_gets_ingredients_list()
    {
        $ingredients = Ingredient::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.ingredients.index'));

        $response->assertOk()->assertSee($ingredients[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_ingredient()
    {
        $data = Ingredient::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.ingredients.store'), $data);

        $this->assertDatabaseHas('ingredients', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_ingredient()
    {
        $ingredient = Ingredient::factory()->create();

        $measureUnit = MeasureUnit::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'measure_unit_id' => $measureUnit->id,
        ];

        $response = $this->putJson(
            route('api.ingredients.update', $ingredient),
            $data
        );

        $data['id'] = $ingredient->id;

        $this->assertDatabaseHas('ingredients', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_ingredient()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->deleteJson(
            route('api.ingredients.destroy', $ingredient)
        );

        $this->assertDeleted($ingredient);

        $response->assertNoContent();
    }
}
