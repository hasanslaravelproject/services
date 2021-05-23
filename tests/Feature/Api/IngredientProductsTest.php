<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Ingredient;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IngredientProductsTest extends TestCase
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
    public function it_gets_ingredient_products()
    {
        $ingredient = Ingredient::factory()->create();
        $product = Product::factory()->create();

        $ingredient->products()->attach($product);

        $response = $this->getJson(
            route('api.ingredients.products.index', $ingredient)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_ingredient()
    {
        $ingredient = Ingredient::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.ingredients.products.store', [$ingredient, $product])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $ingredient
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_ingredient()
    {
        $ingredient = Ingredient::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.ingredients.products.store', [$ingredient, $product])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $ingredient
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}
