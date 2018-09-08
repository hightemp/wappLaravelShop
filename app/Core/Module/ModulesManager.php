<?php

namespace App\Managers;

use App\Models\Module as ModuleModel;
use App\Core\Module\Module;
use App\Core\Installation\Installator;
use Illuminate\Support\Facades\Cache;

class ModulesManager
{
	protected $_oFileSystem;
	protected $_bIsInstalled;
	protected $_aModules = [];
	protected $_aInstalledModulesNames = [];

	function __construct($oFileSystem)
	{
		$this->_oFileSystem = $oFileSystem;
		$this->_bIsInstalled = Installator::fnIsInstalled();

		if ($this->_bIsInstalled) {
			$sCacheKey = "ModulesManager.aModules";
			if (Cache::has($sCacheKey)) {
				$this->_aModules = Cache::get($sCacheKey);
			} else {
				$aModulesPaths = fnAppPathGlob("Modules", "*");

				foreach ($aModulesPaths as $sModulePath) {
					$sModuleName = basename($sModulePath);
		
					$oModuleModel = ModuleModel::firstOrNew([ 'sName' => $sModuleName ]);
					$sModuleClassName = "App\Modules\$sModuleName\$sModuleName";
		
					$this->_aModules[$sModuleName] = new $sModuleClassName($oFileSystem, $oModuleModel);
				}

				Cache::put($sCacheKey, $aScriptsFilesMTime, config("cache.aCachePeriods.aModulesManager.iModulesTime"));
			}

			$sCacheKey = "ModulesManager.aInstalledModulesNames";
			if (Cache::has($sCacheKey)) {
				$this->_aInstalledModulesNames = Cache::get($sCacheKey);
			} else {
				$this->_aInstalledModulesNames = array_map(
					function($oModule) 
					{
						if ($oModule->fnIsInstalled) {
							return $oModule->fnGetName();
						}
					}, 
					$this->_aModules
					//Module::where('bStatus', 1)->get()
				);

				Cache::put($sCacheKey, $aScriptsFilesMTime, config("cache.aCachePeriods.aModulesManager.iInstalledModulesNamesTime"));
			}
		}
	}

	public static function fnGetNames()
	{
		return array_keys($this->_aModules);
  	}
  
  	public static function fnGetModules()
	{
		return $this->_aModules;
	}

	public static function fnGetInstalledNames() 
	{
		return $this->_aInstalledModulesNames;
	}

}
