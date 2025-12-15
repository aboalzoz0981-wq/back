<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Renter>
 */
class RenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'first_name'=>fake()->firstName(),
           'last_name'=>fake()->lastName(),
           'phone'=>fake()->unique()->phoneNumber(),
           'personal_photo'=>fake()->url(),
           'date_of_birth'=>fake()->date('Y-m-d'),
           'An_ID_photo'=>fake()->url(),
           'password' =>fake()->password()
        ];
    }
}
