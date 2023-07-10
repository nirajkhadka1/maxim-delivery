<?php

namespace Database\Seeders;

use App\Models\School;
use Faker\Factory as Faker;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for($i=0;$i<50;$i++){
            School::create([
                'name' => $faker->name(),
                'primary_contact_number' => $faker->phoneNumber(),
                'secondary_contact_number' => $faker->phoneNumber(),
                'primary_email_address' => $faker->email(),
                'secondary_email_address' => $faker->email(),
                'address' => $faker->address(),
            ]);

        }
    }
}
