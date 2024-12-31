<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use Faker\Factory as Faker;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $faker = Faker::create();

        // $teams = [
        //     [
        //         'name' => $faker->company,
        //         'state' => $faker->state,
        //         'country' => $faker->country,
        //     ],
        //     [
        //         'name' => $faker->company,
        //         'state' => $faker->state,
        //         'country' => $faker->country,
        //     ]
        // ];

        // foreach ($teams as $team) {
        //     Team::create($team);
        // }
        Team::factory(2)->create();
    }
}
