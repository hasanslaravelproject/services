<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FinishedProductStock;

use App\Models\Production;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinishedProductStockTest extends TestCase
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
    public function it_gets_finished_product_stocks_list()
    {
        $finishedProductStocks = FinishedProductStock::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.finished-product-stocks.index'));

        $response->assertOk()->assertSee($finishedProductStocks[0]->validity);
    }

    /**
     * @test
     */
    public function it_stores_the_finished_product_stock()
    {
        $data = FinishedProductStock::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.finished-product-stocks.store'),
            $data
        );

        $this->assertDatabaseHas('finished_product_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_finished_product_stock()
    {
        $finishedProductStock = FinishedProductStock::factory()->create();

        $finishedProductStock = FinishedProductStock::factory()->create();
        $production = Production::factory()->create();

        $data = [
            'quantity' => $this->faker->randomNumber,
            'validity' => $this->faker->text(255),
            'finished_product_stock_id' => $finishedProductStock->id,
            'production_id' => $production->id,
        ];

        $response = $this->putJson(
            route('api.finished-product-stocks.update', $finishedProductStock),
            $data
        );

        $data['id'] = $finishedProductStock->id;

        $this->assertDatabaseHas('finished_product_stocks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_finished_product_stock()
    {
        $finishedProductStock = FinishedProductStock::factory()->create();

        $response = $this->deleteJson(
            route('api.finished-product-stocks.destroy', $finishedProductStock)
        );

        $this->assertDeleted($finishedProductStock);

        $response->assertNoContent();
    }
}
