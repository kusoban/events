<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder 
{
    public function run () {
        factory(Category::class, 33)->create();
    }
}