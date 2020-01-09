<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Event;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder 
{
    public function run () {
        factory(User::class, 2)->create();
    }
}