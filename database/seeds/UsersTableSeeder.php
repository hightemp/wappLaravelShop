<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objUser = new User();
        $objUser->name = "admin";
        $objUser->email = "admin@gmail.com";
        $objUser->password = Hash::make("123123");
        $objUser->save();
    }
}
