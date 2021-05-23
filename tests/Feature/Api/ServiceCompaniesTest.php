<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Service;
use App\Models\Company;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceCompaniesTest extends TestCase
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
    public function it_gets_service_companies()
    {
        $service = Service::factory()->create();
        $companies = Company::factory()
            ->count(2)
            ->create([
                'service_id' => $service->id,
            ]);

        $response = $this->getJson(
            route('api.services.companies.index', $service)
        );

        $response->assertOk()->assertSee($companies[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_service_companies()
    {
        $service = Service::factory()->create();
        $data = Company::factory()
            ->make([
                'service_id' => $service->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.services.companies.store', $service),
            $data
        );

        $this->assertDatabaseHas('companies', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $company = Company::latest('id')->first();

        $this->assertEquals($service->id, $company->service_id);
    }
}
