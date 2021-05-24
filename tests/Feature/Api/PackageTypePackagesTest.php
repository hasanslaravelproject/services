<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Package;
use App\Models\PackageType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageTypePackagesTest extends TestCase
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
    public function it_gets_package_type_packages()
    {
        $packageType = PackageType::factory()->create();
        $packages = Package::factory()
            ->count(2)
            ->create([
                'package_type_id' => $packageType->id,
            ]);

        $response = $this->getJson(
            route('api.package-types.packages.index', $packageType)
        );

        $response->assertOk()->assertSee($packages[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_package_type_packages()
    {
        $packageType = PackageType::factory()->create();
        $data = Package::factory()
            ->make([
                'package_type_id' => $packageType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.package-types.packages.store', $packageType),
            $data
        );

        $this->assertDatabaseHas('packages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $package = Package::latest('id')->first();

        $this->assertEquals($packageType->id, $package->package_type_id);
    }
}
