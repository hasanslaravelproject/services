<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Package;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageProductsTest extends TestCase
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
    public function it_gets_package_products()
    {
        $package = Package::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'package_id' => $package->id,
            ]);

        $response = $this->getJson(
            route('api.packages.products.index', $package)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_package_products()
    {
        $package = Package::factory()->create();
        $data = Product::factory()
            ->make([
                'package_id' => $package->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.packages.products.store', $package),
            $data
        );

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($package->id, $product->package_id);
    }
}
