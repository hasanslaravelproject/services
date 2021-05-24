<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Package;

use App\Models\Company;
use App\Models\PackageType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageTest extends TestCase
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
    public function it_gets_packages_list()
    {
        $packages = Package::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.packages.index'));

        $response->assertOk()->assertSee($packages[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_package()
    {
        $data = Package::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.packages.store'), $data);

        $this->assertDatabaseHas('packages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_package()
    {
        $package = Package::factory()->create();

        $company = Company::factory()->create();
        $packageType = PackageType::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'validity' => $this->faker->dateTime,
            'status' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'company_id' => $company->id,
            'package_type_id' => $packageType->id,
        ];

        $response = $this->putJson(
            route('api.packages.update', $package),
            $data
        );

        $data['id'] = $package->id;

        $this->assertDatabaseHas('packages', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_package()
    {
        $package = Package::factory()->create();

        $response = $this->deleteJson(route('api.packages.destroy', $package));

        $this->assertDeleted($package);

        $response->assertNoContent();
    }
}
