<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductUsersTest extends TestCase
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
    public function it_gets_product_users()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();

        $product->users()->attach($user);

        $response = $this->getJson(route('api.products.users.index', $product));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_product()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.products.users.store', [$product, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_product()
    {
        $product = Product::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.products.users.store', [$product, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
