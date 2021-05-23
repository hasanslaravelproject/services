<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Production;
use App\Models\FinishedProductStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionFinishedProductStocksTest extends TestCase
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
    public function it_gets_production_finished_product_stocks()
    {
        $production = Production::factory()->create();
        $finishedProductStocks = FinishedProductStock::factory()
            ->count(2)
            ->create([
                'production_id' => $production->id,
            ]);

        $response = $this->getJson(
            route('api.productions.finished-product-stocks.index', $production)
        );

        $response->assertOk()->assertSee($finishedProductStocks[0]->validity);
    }

    /**
     * @test
     */
    public function it_stores_the_production_finished_product_stocks()
    {
        $production = Production::factory()->create();
        $data = FinishedProductStock::factory()
            ->make([
                'production_id' => $production->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.productions.finished-product-stocks.store', $production),
            $data
        );

        $this->assertDatabaseHas('finished_product_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $finishedProductStock = FinishedProductStock::latest('id')->first();

        $this->assertEquals(
            $production->id,
            $finishedProductStock->production_id
        );
    }
}
