<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FinishedProductStock;

class FinishedProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FinishedProductStock::factory()
            ->count(5)
            ->create();
    }
}
