<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Production;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductProductionsTest extends TestCase
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
    public function it_gets_product_productions()
    {
        $product = Product::factory()->create();
        $productions = Production::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.productions.index', $product)
        );

        $response->assertOk()->assertSee($productions[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_productions()
    {
        $product = Product::factory()->create();
        $data = Production::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.productions.store', $product),
            $data
        );

        $this->assertDatabaseHas('productions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $production = Production::latest('id')->first();

        $this->assertEquals($product->id, $production->product_id);
    }
}
