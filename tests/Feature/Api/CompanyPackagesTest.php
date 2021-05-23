<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\Package;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyPackagesTest extends TestCase
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
    public function it_gets_company_packages()
    {
        $company = Company::factory()->create();
        $packages = Package::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.packages.index', $company)
        );

        $response->assertOk()->assertSee($packages[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_company_packages()
    {
        $company = Company::factory()->create();
        $data = Package::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.packages.store', $company),
            $data
        );

        $this->assertDatabaseHas('packages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $package = Package::latest('id')->first();

        $this->assertEquals($company->id, $package->company_id);
    }
}
