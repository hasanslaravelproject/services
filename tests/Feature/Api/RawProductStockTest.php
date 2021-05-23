<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RawProductStock;

use App\Models\Ingredient;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RawProductStockTest extends TestCase
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
    public function it_gets_raw_product_stocks_list()
    {
        $rawProductStocks = RawProductStock::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.raw-product-stocks.index'));

        $response->assertOk()->assertSee($rawProductStocks[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_raw_product_stock()
    {
        $data = RawProductStock::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.raw-product-stocks.store'),
            $data
        );

        $this->assertDatabaseHas('raw_product_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_raw_product_stock()
    {
        $rawProductStock = RawProductStock::factory()->create();

        $ingredient = Ingredient::factory()->create();

        $data = [
            'quantity' => $this->faker->randomNumber,
            'expiry_date' => $this->faker->dateTime,
            'ingredient_id' => $ingredient->id,
        ];

        $response = $this->putJson(
            route('api.raw-product-stocks.update', $rawProductStock),
            $data
        );

        $data['id'] = $rawProductStock->id;

        $this->assertDatabaseHas('raw_product_stocks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_raw_product_stock()
    {
        $rawProductStock = RawProductStock::factory()->create();

        $response = $this->deleteJson(
            route('api.raw-product-stocks.destroy', $rawProductStock)
        );

        $this->assertDeleted($rawProductStock);

        $response->assertNoContent();
    }
}
