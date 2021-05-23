<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProductsTest extends TestCase
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
    public function it_gets_user_products()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $user->products()->attach($product);

        $response = $this->getJson(route('api.users.products.index', $user));

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_user()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.users.products.store', [$user, $product])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_user()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.users.products.store', [$user, $product])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}
