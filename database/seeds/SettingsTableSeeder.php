<?php

use Illuminate\Database\Seeder;
use App\Settings;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objSettings = new Settings();
        $objSettings->name = "start page";
        $objSettings->type = "pages";
        $objSettings->value = "1";
        $objSettings->save();
    }
}
