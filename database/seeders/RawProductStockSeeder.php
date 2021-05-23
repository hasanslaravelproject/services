<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RawProductStock;

class RawProductStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RawProductStock::factory()
            ->count(5)
            ->create();
    }
}
