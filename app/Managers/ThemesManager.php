<?php

namespace App\Managers;

use App\Models\Theme;

class ThemesManager
{
	public static function fnGetAllNames()
	{
		$aResult = [];

		$aThemesPaths = fnAppPathGlob("Resources", "Frontend", "*");

		foreach($aThemesPaths as $sThemePath) {
			$aResult[] = basename($sThemePath);
		}

		return $aResult;
  }

  public static function fnGetAll()
	{
		$aResult = [];

		$aThemesPaths = fnAppPathGlob("Resources", "Frontend", "*");

		foreach($aThemesPaths as $sThemePath) {
			$sThemeName = basename($sThemePath);

			$aResult[] = Module::firstOrNew([ 'sName' => $sThemeName ]);
		}

		return $aResult;
	}

	public static function fnGetInstalled() 
	{
		return Theme::where('bStatus', 1)->get();
	}
}
