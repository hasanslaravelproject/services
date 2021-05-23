<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Delivery;
use App\Models\Production;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionDeliveriesTest extends TestCase
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
    public function it_gets_production_deliveries()
    {
        $production = Production::factory()->create();
        $deliveries = Delivery::factory()
            ->count(2)
            ->create([
                'production_id' => $production->id,
            ]);

        $response = $this->getJson(
            route('api.productions.deliveries.index', $production)
        );

        $response->assertOk()->assertSee($deliveries[0]->quantity);
    }

    /**
     * @test
     */
    public function it_stores_the_production_deliveries()
    {
        $production = Production::factory()->create();
        $data = Delivery::factory()
            ->make([
                'production_id' => $production->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.productions.deliveries.store', $production),
            $data
        );

        $this->assertDatabaseHas('deliveries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $delivery = Delivery::latest('id')->first();

        $this->assertEquals($production->id, $delivery->production_id);
    }
}
