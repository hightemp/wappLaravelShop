<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Routing\Controller as BaseController;

class BackendController extends BaseController
{
	function callAction($sMethod, $aParameters) 
	{
		return fnAdminView(
			"layout", 
			[
				"sTitle" => "ADMIN",
				"sContent" => call_user_func_array([$this, $sMethod], $aParameters),
			]
		);
	}
}
