<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user1 = User::create([
        'name'=>'Abdallh',
        'phone'=>'0981502926',
        'password'=>Hash::make('ssss1111'),
       ]);
      $user1->assignRole('admin');
    }
}
