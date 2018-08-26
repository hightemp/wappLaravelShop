<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Routing\Controller as BaseController;
use App\Common\Installation\Installator;

class InstallController extends BaseController
{
	function callAction($sMethod, $aParameters) 
	{
		$sLanguage = request('sLanguage');

		if (in_array($sLanguage, config('app.aLanguages'))) {
			config([ 'app.locale' => $sLanguage ]);
		}

		return fnDefaultThemeView(
			"layout", 
			[
				"sTitle" => __("installation"),
				"sContent" => call_user_func_array([$this, $sMethod], $aParameters),
			]
		);
	}

	function fnIndex()
	{
		$aErrors = [];

		if (request()->method() == 'POST') {
			try {
				$aParameters = request()->all();

				unset($aParameters['_token']);
				
				Installator::fnInstall($aParameters);
			} catch(\Exception $oException) {
				echo $oException->getMessage();
				$aErrors[] = $oException->getCode();
			}

			if (empty($aErrors)) {
				request()->session()->put('bIsInstalled', true);
				request()->session()->put('sLanguage', $aParameters['sLanguage']);

				return redirect('/install_complete');
			}
		}

		return fnDefaultThemeView(
			"install.index", 
			[ 
				'aErrors' => $aErrors
			]
		);
	}

	function fnInstallComplete()
	{
		return fnDefaultThemeView("install.complete");
	}
}