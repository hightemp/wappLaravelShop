<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $aModulesPaths = glob(app_path().DIRECTORY_SEPARATOR."Modules".DIRECTORY_SEPARATOR."*", GLOB_ONLYDIR);
    
    foreach($aModulesPaths as $sModulePath) {
      $sModuleName = dirname($sModulePath);

      $sRoutesFilePath = $sModulePath.DIRECTORY_SEPARATOR."Routes.php";
      if (file_exists($sRoutesFilePath))
        $this->loadRoutesFrom($sRoutesFilePath);

      $sViewsPath = $sModulePath.DIRECTORY_SEPARATOR."Views";
      if (is_dir($sViewsPath))
        $this->loadViewsFrom($sViewsPath, $sModuleName);

      //$sLanguagePath = $sModulePath.DIRECTORY_SEPARATOR."Language";
      //if (is_dir($sLanguagePath))
      //  $this->loadTranslationsFrom($sLanguagePath);

      $sMigrationsFilePath = $sModulePath.DIRECTORY_SEPARATOR."Migrations.php";
      if (file_exists($sMigrationsFilePath))
        $this->loadMigrationsFrom($sMigrationsFilePath);
    }
  }

  public function register()
  {

  }
}
