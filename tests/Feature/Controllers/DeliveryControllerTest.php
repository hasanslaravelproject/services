<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Delivery;

use App\Models\Order;
use App\Models\Production;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeliveryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_deliveries()
    {
        $deliveries = Delivery::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('deliveries.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.deliveries.index')
            ->assertViewHas('deliveries');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_delivery()
    {
        $response = $this->get(route('deliveries.create'));

        $response->assertOk()->assertViewIs('app.deliveries.create');
    }

    /**
     * @test
     */
    public function it_stores_the_delivery()
    {
        $data = Delivery::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('deliveries.store'), $data);

        $this->assertDatabaseHas('deliveries', $data);

        $delivery = Delivery::latest('id')->first();

        $response->assertRedirect(route('deliveries.edit', $delivery));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_delivery()
    {
        $delivery = Delivery::factory()->create();

        $response = $this->get(route('deliveries.show', $delivery));

        $response
            ->assertOk()
            ->assertViewIs('app.deliveries.show')
            ->assertViewHas('delivery');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_delivery()
    {
        $delivery = Delivery::factory()->create();

        $response = $this->get(route('deliveries.edit', $delivery));

        $response
            ->assertOk()
            ->assertViewIs('app.deliveries.edit')
            ->assertViewHas('delivery');
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

        $response = $this->put(route('deliveries.update', $delivery), $data);

        $data['id'] = $delivery->id;

        $this->assertDatabaseHas('deliveries', $data);

        $response->assertRedirect(route('deliveries.edit', $delivery));
    }

    /**
     * @test
     */
    public function it_deletes_the_delivery()
    {
        $delivery = Delivery::factory()->create();

        $response = $this->delete(route('deliveries.destroy', $delivery));

        $response->assertRedirect(route('deliveries.index'));

        $this->assertDeleted($delivery);
    }
}
