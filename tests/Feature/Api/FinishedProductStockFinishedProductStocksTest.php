<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FinishedProductStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinishedProductStockFinishedProductStocksTest extends TestCase
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
    public function it_gets_finished_product_stock_finished_product_stocks()
    {
        $finishedProductStock = FinishedProductStock::factory()->create();
        $finishedProductStocks = FinishedProductStock::factory()
            ->count(2)
            ->create([
                'finished_product_stock_id' => $finishedProductStock->id,
            ]);

        $response = $this->getJson(
            route(
                'api.finished-product-stocks.finished-product-stocks.index',
                $finishedProductStock
            )
        );

        $response->assertOk()->assertSee($finishedProductStocks[0]->validity);
    }

    /**
     * @test
     */
    public function it_stores_the_finished_product_stock_finished_product_stocks()
    {
        $finishedProductStock = FinishedProductStock::factory()->create();
        $data = FinishedProductStock::factory()
            ->make([
                'finished_product_stock_id' => $finishedProductStock->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.finished-product-stocks.finished-product-stocks.store',
                $finishedProductStock
            ),
            $data
        );

        $this->assertDatabaseHas('finished_product_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $finishedProductStock = FinishedProductStock::latest('id')->first();

        $this->assertEquals(
            $finishedProductStock->id,
            $finishedProductStock->finished_product_stock_id
        );
    }
}
