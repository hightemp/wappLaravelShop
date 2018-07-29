<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    public function fnShow()
    {
        return fnAdminView('dashboard');
    }
}
