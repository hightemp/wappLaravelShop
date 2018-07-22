<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	protected $table = 'Modules';
	protected $primaryKey = 'iModuleID';
	public $timestamps = false;

	protected $fillable = ['sName', 'bStatus'];

	public static function fnGetAll()
	{
		$aResult = [];

		$aModulesPaths = glob(fnAppPath("Modules", "*"), GLOB_ONLYDIR);

		foreach($aModulesPaths as $sModulePath) {
			$sModuleName = basename($sModulePath);

			$aResult[] = self::firstOrNew([ 'sName' => $sModuleName ]);
		}

		return $aResult;
	}

	public static function fnGetInstalled() 
	{
		return self::where('bStatus', 1)->get();
	}

	public function fnLoadRoutes()
	{
		$sRoutesFilePath = fnAppPath("Modules", $this->sName, "Routes.php");

		if (file_exists($sRoutesFilePath)) {
			if (! app()->routesAreCached()) {
				require_once $sRoutesFilePath;
			}
		}
	}

	public function fnLoadViews()
	{
		$sViewsPath = fnAppPath("Modules", $this->sName, "Views");

		if (is_dir($sViewsPath)) {
			app('view')
				->addNamespace($this->sName, $sViewsPath);
		}
	}

	public function fnLoadTranslations()
	{
		$sGlobalTranslationsPath = fnAppPath("Modules", $this->sName, "Language", "Global");
		$sModuleTranslationsPath = fnAppPath("Modules", $this->sName, "Language", "Module");

		$oTranslationLoader = app()->make('translation.loader');
		$oTranslationLoader->addPath($sGlobalTranslationsPath);
		$oTranslationLoader->addNamespace($this->sName, $sModuleTranslationsPath);
	}

	public function fnLoadMigrations()
	{
		$sMigrationsPath = fnAppPath("Modules", $this->sName, "Migrations");

		app()
			->afterResolving(
				'migrator', 
				function ($oMigrator) 
				{
					$oMigrator->path($sMigrationsPath);
				}
			);
	}
}