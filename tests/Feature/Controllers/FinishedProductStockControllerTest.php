<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FinishedProductStock;

use App\Models\Production;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FinishedProductStockControllerTest extends TestCase
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
    public function it_displays_index_view_with_finished_product_stocks()
    {
        $finishedProductStocks = FinishedProductStock::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('finished-product-stocks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.finished_product_stocks.index')
            ->assertViewHas('finishedProductStocks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_finished_product_stock()
    {
        $response = $this->get(route('finished-product-stocks.create'));

        $response
            ->assertOk()
            ->assertViewIs('app.finished_product_stocks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_finished_product_stock()
    {
        $data = FinishedProductStock::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('finished-product-stocks.store'), $data);

        $this->assertDatabaseHas('finished_product_stocks', $data);

        $finishedProductStock = FinishedProductStock::latest('id')->first();

        $response->assertRedirect(
            route('finished-product-stocks.edit', $finishedProductStock)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_finished_product_stock()
    {
        $finishedProductStock = FinishedProductStock::factory()->create();

        $response = $this->get(
            route('finished-product-stocks.show', $finishedProductStock)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.finished_product_stocks.show')
            ->assertViewHas('finishedProductStock');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_finished_product_stock()
    {
        $finishedProductStock = FinishedProductStock::factory()->create();

        $response = $this->get(
            route('finished-product-stocks.edit', $finishedProductStock)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.finished_product_stocks.edit')
            ->assertViewHas('finishedProductStock');
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

        $response = $this->put(
            route('finished-product-stocks.update', $finishedProductStock),
            $data
        );

        $data['id'] = $finishedProductStock->id;

        $this->assertDatabaseHas('finished_product_stocks', $data);

        $response->assertRedirect(
            route('finished-product-stocks.edit', $finishedProductStock)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_finished_product_stock()
    {
        $finishedProductStock = FinishedProductStock::factory()->create();

        $response = $this->delete(
            route('finished-product-stocks.destroy', $finishedProductStock)
        );

        $response->assertRedirect(route('finished-product-stocks.index'));

        $this->assertDeleted($finishedProductStock);
    }
}
