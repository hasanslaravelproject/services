<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PackageType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageTypeControllerTest extends TestCase
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
    public function it_displays_index_view_with_package_types()
    {
        $packageTypes = PackageType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('package-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.package_types.index')
            ->assertViewHas('packageTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_package_type()
    {
        $response = $this->get(route('package-types.create'));

        $response->assertOk()->assertViewIs('app.package_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_package_type()
    {
        $data = PackageType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('package-types.store'), $data);

        $this->assertDatabaseHas('package_types', $data);

        $packageType = PackageType::latest('id')->first();

        $response->assertRedirect(route('package-types.edit', $packageType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_package_type()
    {
        $packageType = PackageType::factory()->create();

        $response = $this->get(route('package-types.show', $packageType));

        $response
            ->assertOk()
            ->assertViewIs('app.package_types.show')
            ->assertViewHas('packageType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_package_type()
    {
        $packageType = PackageType::factory()->create();

        $response = $this->get(route('package-types.edit', $packageType));

        $response
            ->assertOk()
            ->assertViewIs('app.package_types.edit')
            ->assertViewHas('packageType');
    }

    /**
     * @test
     */
    public function it_updates_the_package_type()
    {
        $packageType = PackageType::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->put(
            route('package-types.update', $packageType),
            $data
        );

        $data['id'] = $packageType->id;

        $this->assertDatabaseHas('package_types', $data);

        $response->assertRedirect(route('package-types.edit', $packageType));
    }

    /**
     * @test
     */
    public function it_deletes_the_package_type()
    {
        $packageType = PackageType::factory()->create();

        $response = $this->delete(route('package-types.destroy', $packageType));

        $response->assertRedirect(route('package-types.index'));

        $this->assertDeleted($packageType);
    }
}
