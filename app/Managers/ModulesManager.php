<?php

namespace App\Managers;

use App\Models\Module;

class ModulesManager
{
	public static function fnGetAllNames()
	{
		$aResult = [];

		$aModulesPaths = fnAppPathGlob("Modules", "*");

		foreach($aModulesPaths as $sModulePath) {
			$aResult[] = basename($sModulePath);
		}

		return $aResult;
  }
  
  public static function fnGetAll()
	{
		$aResult = [];

		$aModulesPaths = fnAppPathGlob("Modules", "*");

		foreach($aModulesPaths as $sModulePath) {
			$sModuleName = basename($sModulePath);

			$aResult[] = Module::firstOrNew([ 'sName' => $sModuleName ]);
		}

		return $aResult;
	}

	public static function fnGetInstalled() 
	{
		return Module::where('bStatus', 1)->get();
	}

}
