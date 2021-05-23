<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Delivery;

use App\Models\Order;
use App\Models\Production;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryTest extends TestCase
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
    public function it_gets_deliveries_list()
    {
        $deliveries = Delivery::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.deliveries.index'));

        $response->assertOk()->assertSee($deliveries[0]->quantity);
    }

    /**
     * @test
     */
    public function it_stores_the_delivery()
    {
        $data = Delivery::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.deliveries.store'), $data);

        $this->assertDatabaseHas('deliveries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_delivery()
    {
        $delivery = Delivery::factory()->create();

        $order = Order::factory()->create();
        $production = Production::factory()->create();

        $data = [
            'quantity' => $this->faker->text(255),
            'order_id' => $order->id,
            'production_id' => $production->id,
        ];

        $response = $this->putJson(
            route('api.deliveries.update', $delivery),
            $data
        );

        $data['id'] = $delivery->id;

        $this->assertDatabaseHas('deliveries', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_delivery()
    {
        $delivery = Delivery::factory()->create();

        $response = $this->deleteJson(
            route('api.deliveries.destroy', $delivery)
        );

        $this->assertDeleted($delivery);

        $response->assertNoContent();
    }
}
