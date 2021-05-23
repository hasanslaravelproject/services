<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Ingredient;
use App\Models\RawProductStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientRawProductStocksTest extends TestCase
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
    public function it_gets_ingredient_raw_product_stocks()
    {
        $ingredient = Ingredient::factory()->create();
        $rawProductStocks = RawProductStock::factory()
            ->count(2)
            ->create([
                'ingredient_id' => $ingredient->id,
            ]);

        $response = $this->getJson(
            route('api.ingredients.raw-product-stocks.index', $ingredient)
        );

        $response->assertOk()->assertSee($rawProductStocks[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_ingredient_raw_product_stocks()
    {
        $ingredient = Ingredient::factory()->create();
        $data = RawProductStock::factory()
            ->make([
                'ingredient_id' => $ingredient->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.ingredients.raw-product-stocks.store', $ingredient),
            $data
        );

        $this->assertDatabaseHas('raw_product_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $rawProductStock = RawProductStock::latest('id')->first();

        $this->assertEquals($ingredient->id, $rawProductStock->ingredient_id);
    }
}
