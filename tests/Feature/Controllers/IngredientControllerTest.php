<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Ingredient;

use App\Models\MeasureUnit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_ingredients()
    {
        $ingredients = Ingredient::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('ingredients.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.ingredients.index')
            ->assertViewHas('ingredients');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_ingredient()
    {
        $response = $this->get(route('ingredients.create'));

        $response->assertOk()->assertViewIs('app.ingredients.create');
    }

    /**
     * @test
     */
    public function it_stores_the_ingredient()
    {
        $data = Ingredient::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('ingredients.store'), $data);

        $this->assertDatabaseHas('ingredients', $data);

        $ingredient = Ingredient::latest('id')->first();

        $response->assertRedirect(route('ingredients.edit', $ingredient));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_ingredient()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->get(route('ingredients.show', $ingredient));

        $response
            ->assertOk()
            ->assertViewIs('app.ingredients.show')
            ->assertViewHas('ingredient');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_ingredient()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->get(route('ingredients.edit', $ingredient));

        $response
            ->assertOk()
            ->assertViewIs('app.ingredients.edit')
            ->assertViewHas('ingredient');
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

        $response = $this->put(route('ingredients.update', $ingredient), $data);

        $data['id'] = $ingredient->id;

        $this->assertDatabaseHas('ingredients', $data);

        $response->assertRedirect(route('ingredients.edit', $ingredient));
    }

    /**
     * @test
     */
    public function it_deletes_the_ingredient()
    {
        $ingredient = Ingredient::factory()->create();

        $response = $this->delete(route('ingredients.destroy', $ingredient));

        $response->assertRedirect(route('ingredients.index'));

        $this->assertDeleted($ingredient);
    }
}
