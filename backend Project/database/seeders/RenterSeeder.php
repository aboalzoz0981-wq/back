<?php

namespace Database\Seeders;

use App\Models\renter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       renter::factory()->count(10)->create();
    }
}
