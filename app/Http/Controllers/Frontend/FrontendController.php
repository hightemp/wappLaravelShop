<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller as BaseController;

class FrontendController extends BaseController
{
	function callAction($sMethod, $aParameters) 
	{
		return fnThemeView(
			"layout", 
			[
				"sTitle" => "TEST",
				"sContent" => call_user_func_array([$this, $sMethod], $aParameters),
			]
		);
	}
}
