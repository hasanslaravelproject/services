<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(ServiceSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(MeasureUnitSeeder::class);
        $this->call(IngredientSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(FinishedProductStockSeeder::class);
        $this->call(RawProductStockSeeder::class);
        $this->call(ProductionSeeder::class);
        $this->call(DeliverySeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(PackageTypeSeeder::class);
        $this->call(PackageSeeder::class);
    }
}
