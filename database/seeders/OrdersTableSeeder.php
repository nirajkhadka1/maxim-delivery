<?php

namespace Database\Seeders;

use App\Models\DeliveryDate;
use App\Models\Order;
use App\Models\School;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $schools = School::all();
        $medium = ['sms','email','both'];
        foreach($schools as $school){
            for ($i = 0; $i < 3; $i++) {
                $date = $faker->date();
                DeliveryDate::updateOrCreate(['dates'=>$date],['dates'=>$date,'status'=>'on']);
                Order::create([
                    'school_id' => $school->id,
                    'address'=> $faker->address(),
                    'delivery_date' => $date,
                    'postal_code' => $faker->postcode(),
                    'geolocation' => $faker->address(),
                    'notification_medium' => $medium[rand(0,2)]
                ]);

        }
    }
    }
}
