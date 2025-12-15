<?php

namespace Database\Factories;

use App\Models\renter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now  = Carbon::now();
        $after = Carbon::now()->addMonth();
        return [
            'renter_id'=>renter::inRandomOrder()->first()->id,
            'Address'=>fake()->streetAddress(),
            'cost'=>fake()->numberBetween(1000,10000),
            'space'=>fake()->numberBetween(50,200),
            'rooms'=>fake()->numberBetween(1,6),
        ];
    }
}
