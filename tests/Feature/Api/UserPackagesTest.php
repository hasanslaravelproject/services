<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Package;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPackagesTest extends TestCase
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
    public function it_gets_user_packages()
    {
        $user = User::factory()->create();
        $package = Package::factory()->create();

        $user->packages()->attach($package);

        $response = $this->getJson(route('api.users.packages.index', $user));

        $response->assertOk()->assertSee($package->name);
    }

    /**
     * @test
     */
    public function it_can_attach_packages_to_user()
    {
        $user = User::factory()->create();
        $package = Package::factory()->create();

        $response = $this->postJson(
            route('api.users.packages.store', [$user, $package])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->packages()
                ->where('packages.id', $package->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_packages_from_user()
    {
        $user = User::factory()->create();
        $package = Package::factory()->create();

        $response = $this->deleteJson(
            route('api.users.packages.store', [$user, $package])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->packages()
                ->where('packages.id', $package->id)
                ->exists()
        );
    }
}
