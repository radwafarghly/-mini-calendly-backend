<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = [
            [
                'id' => 1,
               
                'name' => 'Saturday',

            ],
            [
                'id' => 2,
                
                'name' => 'Sunday',

            ],
            [
                'id' => 3,
              
                'name' => 'Monday',

            ],
            [
                'id' => 4,
               
                'name' => 'Tuesday',

            ],
            [
                'id' => 5,
               
                'name' => 'Wednesday',

            ],
            [
                'id' => 6,
               
                'name' => 'Thursday',

            ],
            [
                'id' => 7,
              
                'name' => 'Saturday',
            ],

        ];
        foreach ($days as $key => $value) {
            Day::create($value);
        }
    }
}
