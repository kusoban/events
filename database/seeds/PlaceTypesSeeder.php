<?php

use Illuminate\Database\Seeder;
use App\PlaceType;

class PlaceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['restauran', 'pub', 'music', 'bar', 'museum', 'theater', 'cinema', 'club', 'night club', 'party', 'recreational', 'adult'];

        foreach($types as $typeName) {
            PlaceType::create([
                'name' => $typeName,
            ]);
        };
    }
}
