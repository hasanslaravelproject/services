<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Production;

use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionTest extends TestCase
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
    public function it_gets_productions_list()
    {
        $productions = Production::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.productions.index'));

        $response->assertOk()->assertSee($productions[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_production()
    {
        $data = Production::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.productions.store'), $data);

        $this->assertDatabaseHas('productions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_production()
    {
        $production = Production::factory()->create();

        $product = Product::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'date' => $this->faker->dateTime,
            'validity' => $this->faker->text(255),
            'image' => $this->faker->text(255),
            'quanity' => $this->faker->text(255),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'order_id' => $this->faker->text(255),
            'product_id' => $product->id,
        ];

        $response = $this->putJson(
            route('api.productions.update', $production),
            $data
        );

        $data['id'] = $production->id;

        $this->assertDatabaseHas('productions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_production()
    {
        $production = Production::factory()->create();

        $response = $this->deleteJson(
            route('api.productions.destroy', $production)
        );

        $this->assertDeleted($production);

        $response->assertNoContent();
    }
}
