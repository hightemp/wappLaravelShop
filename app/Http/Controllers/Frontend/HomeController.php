<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    public function fnShow()
    {
        return theme_view('home');
    }
}
