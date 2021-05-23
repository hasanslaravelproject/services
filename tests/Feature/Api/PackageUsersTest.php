<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Package;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PackageUsersTest extends TestCase
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
    public function it_gets_package_users()
    {
        $package = Package::factory()->create();
        $user = User::factory()->create();

        $package->users()->attach($user);

        $response = $this->getJson(route('api.packages.users.index', $package));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_package()
    {
        $package = Package::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.packages.users.store', [$package, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $package
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_package()
    {
        $package = Package::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.packages.users.store', [$package, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $package
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
