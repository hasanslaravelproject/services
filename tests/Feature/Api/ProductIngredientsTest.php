<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Ingredient;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductIngredientsTest extends TestCase
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
    public function it_gets_product_ingredients()
    {
        $product = Product::factory()->create();
        $ingredient = Ingredient::factory()->create();

        $product->ingredients()->attach($ingredient);

        $response = $this->getJson(
            route('api.products.ingredients.index', $product)
        );

        $response->assertOk()->assertSee($ingredient->name);
    }

    /**
     * @test
     */
    public function it_can_attach_ingredients_to_product()
    {
        $product = Product::factory()->create();
        $ingredient = Ingredient::factory()->create();

        $response = $this->postJson(
            route('api.products.ingredients.store', [$product, $ingredient])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->ingredients()
                ->where('ingredients.id', $ingredient->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_ingredients_from_product()
    {
        $product = Product::factory()->create();
        $ingredient = Ingredient::factory()->create();

        $response = $this->deleteJson(
            route('api.products.ingredients.store', [$product, $ingredient])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->ingredients()
                ->where('ingredients.id', $ingredient->id)
                ->exists()
        );
    }
}
