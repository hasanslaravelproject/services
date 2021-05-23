<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MeasureUnit;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeasureUnitTest extends TestCase
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
    public function it_gets_measure_units_list()
    {
        $measureUnits = MeasureUnit::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.measure-units.index'));

        $response->assertOk()->assertSee($measureUnits[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_measure_unit()
    {
        $data = MeasureUnit::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.measure-units.store'), $data);

        $this->assertDatabaseHas('measure_units', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_measure_unit()
    {
        $measureUnit = MeasureUnit::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->putJson(
            route('api.measure-units.update', $measureUnit),
            $data
        );

        $data['id'] = $measureUnit->id;

        $this->assertDatabaseHas('measure_units', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_measure_unit()
    {
        $measureUnit = MeasureUnit::factory()->create();

        $response = $this->deleteJson(
            route('api.measure-units.destroy', $measureUnit)
        );

        $this->assertDeleted($measureUnit);

        $response->assertNoContent();
    }
}
