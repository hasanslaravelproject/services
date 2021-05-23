<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\MeasureUnit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeasureUnitControllerTest extends TestCase
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
    public function it_displays_index_view_with_measure_units()
    {
        $measureUnits = MeasureUnit::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('measure-units.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.measure_units.index')
            ->assertViewHas('measureUnits');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_measure_unit()
    {
        $response = $this->get(route('measure-units.create'));

        $response->assertOk()->assertViewIs('app.measure_units.create');
    }

    /**
     * @test
     */
    public function it_stores_the_measure_unit()
    {
        $data = MeasureUnit::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('measure-units.store'), $data);

        $this->assertDatabaseHas('measure_units', $data);

        $measureUnit = MeasureUnit::latest('id')->first();

        $response->assertRedirect(route('measure-units.edit', $measureUnit));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_measure_unit()
    {
        $measureUnit = MeasureUnit::factory()->create();

        $response = $this->get(route('measure-units.show', $measureUnit));

        $response
            ->assertOk()
            ->assertViewIs('app.measure_units.show')
            ->assertViewHas('measureUnit');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_measure_unit()
    {
        $measureUnit = MeasureUnit::factory()->create();

        $response = $this->get(route('measure-units.edit', $measureUnit));

        $response
            ->assertOk()
            ->assertViewIs('app.measure_units.edit')
            ->assertViewHas('measureUnit');
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

        $response = $this->put(
            route('measure-units.update', $measureUnit),
            $data
        );

        $data['id'] = $measureUnit->id;

        $this->assertDatabaseHas('measure_units', $data);

        $response->assertRedirect(route('measure-units.edit', $measureUnit));
    }

    /**
     * @test
     */
    public function it_deletes_the_measure_unit()
    {
        $measureUnit = MeasureUnit::factory()->create();

        $response = $this->delete(route('measure-units.destroy', $measureUnit));

        $response->assertRedirect(route('measure-units.index'));

        $this->assertDeleted($measureUnit);
    }
}
