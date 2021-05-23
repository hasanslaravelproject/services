<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Delivery;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderDeliveriesTest extends TestCase
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
    public function it_gets_order_deliveries()
    {
        $order = Order::factory()->create();
        $deliveries = Delivery::factory()
            ->count(2)
            ->create([
                'order_id' => $order->id,
            ]);

        $response = $this->getJson(
            route('api.orders.deliveries.index', $order)
        );

        $response->assertOk()->assertSee($deliveries[0]->quantity);
    }

    /**
     * @test
     */
    public function it_stores_the_order_deliveries()
    {
        $order = Order::factory()->create();
        $data = Delivery::factory()
            ->make([
                'order_id' => $order->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.orders.deliveries.store', $order),
            $data
        );

        $this->assertDatabaseHas('deliveries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $delivery = Delivery::latest('id')->first();

        $this->assertEquals($order->id, $delivery->order_id);
    }
}
