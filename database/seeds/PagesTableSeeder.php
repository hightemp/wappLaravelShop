<?php

use Illuminate\Database\Seeder;
use App\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objPage = new Page();
        $objPage->uri = 'test';
        $objPage->layout_template = 'base';
        $objPage->template = 'article';
        $objPage->save();
    }
}
