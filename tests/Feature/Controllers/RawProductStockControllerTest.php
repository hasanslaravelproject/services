<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\RawProductStock;

use App\Models\Ingredient;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RawProductStockControllerTest extends TestCase
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
    public function it_displays_index_view_with_raw_product_stocks()
    {
        $rawProductStocks = RawProductStock::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('raw-product-stocks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.raw_product_stocks.index')
            ->assertViewHas('rawProductStocks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_raw_product_stock()
    {
        $response = $this->get(route('raw-product-stocks.create'));

        $response->assertOk()->assertViewIs('app.raw_product_stocks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_raw_product_stock()
    {
        $data = RawProductStock::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('raw-product-stocks.store'), $data);

        $this->assertDatabaseHas('raw_product_stocks', $data);

        $rawProductStock = RawProductStock::latest('id')->first();

        $response->assertRedirect(
            route('raw-product-stocks.edit', $rawProductStock)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_raw_product_stock()
    {
        $rawProductStock = RawProductStock::factory()->create();

        $response = $this->get(
            route('raw-product-stocks.show', $rawProductStock)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.raw_product_stocks.show')
            ->assertViewHas('rawProductStock');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_raw_product_stock()
    {
        $rawProductStock = RawProductStock::factory()->create();

        $response = $this->get(
            route('raw-product-stocks.edit', $rawProductStock)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.raw_product_stocks.edit')
            ->assertViewHas('rawProductStock');
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

        $response = $this->put(
            route('raw-product-stocks.update', $rawProductStock),
            $data
        );

        $data['id'] = $rawProductStock->id;

        $this->assertDatabaseHas('raw_product_stocks', $data);

        $response->assertRedirect(
            route('raw-product-stocks.edit', $rawProductStock)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_raw_product_stock()
    {
        $rawProductStock = RawProductStock::factory()->create();

        $response = $this->delete(
            route('raw-product-stocks.destroy', $rawProductStock)
        );

        $response->assertRedirect(route('raw-product-stocks.index'));

        $this->assertDeleted($rawProductStock);
    }
}
