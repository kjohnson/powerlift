<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Kyle B. Johnson',
             'email' => 'kyle.johnson@hey.com',
             'password' => Hash::make('password'),
         ]);

         \App\Models\Member::create([
             'name' => 'Cory Johnson',
             'member_id' => '1234567890',
         ]);

         \App\Models\FitnessClass::create([
             'name' => 'Yoga with Adrian',
         ]);
    }
}
