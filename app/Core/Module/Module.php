<?php

namespace App\Core\Module;

abstract class Module
{
    protected $_sName;
    protected $_oFileSystem;

    function __construct($oFileSystem)
    {
        $this->_oFileSystem = $oFileSystem;
    }
    
    public function fnGetName()
    {
        return $this->_sName;
    }

	public function fnLoadRoutes()
	{
		$sRoutesFilePath = fnAppPath("Modules", $this->_sName, "Routes.php");

		if (file_exists($sRoutesFilePath)) {
			if (! app()->routesAreCached()) {
				require_once $sRoutesFilePath;
			}
		}
	}

	public function fnLoadViews()
	{
		$sViewsPath = fnAppPath("Modules", $this->_sName, "Views");

		if (is_dir($sViewsPath)) {
			app('view')
				->addNamespace($this->sName, $sViewsPath);
		}
	}

	public function fnLoadTranslations()
	{
		$sGlobalTranslationsPath = fnAppPath("Modules", $this->_sName, "Language", "Global");
		$sModuleTranslationsPath = fnAppPath("Modules", $this->_sName, "Language", "Module");

		$oTranslationLoader = app()->make('translation.loader');
		$oTranslationLoader->fnAddPath($sGlobalTranslationsPath);
		$oTranslationLoader->addNamespace($this->_sName, $sModuleTranslationsPath);
	}

	public function fnLoadMigrations()
	{
		$sMigrationsPath = fnAppPath("Modules", $this->_sName, "Migrations");

		app()
			->afterResolving(
				'migrator', 
				function ($oMigrator) use ($sMigrationsPath)
				{
					$oMigrator->path($sMigrationsPath);
				}
			);
	}

}