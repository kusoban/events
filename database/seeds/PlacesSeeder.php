<?php

use Illuminate\Database\Seeder;
use App\Place;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Place::create([
                'owner_id' => 1,
                'name' => 'Krobik',
                'address' => 'Krobik street 1',
            ]);
    }
}
