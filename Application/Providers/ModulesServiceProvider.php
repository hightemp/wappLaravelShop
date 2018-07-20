<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $aModulesPaths = glob(app_path()."/Modules/*", GLOB_ONLYDIR);
    
    foreach($aModulesPaths as $sModulePath) {
      $sModuleName = dirname($sModulePath);

      if (file_exists($sModulePath."/Routes.php"))
        $this->loadRoutesFrom($sModulePath."/Routes.php");

      if (is_dir($sModulePath."/Views"))
        $this->loadViewsFrom($sModulePath."/Views", $sModuleName);

      if (file_exists($sModulePath."/Migrations.php"))
        $this->loadMigrationsFrom($sModulePath."/Migrations.php");
    }
  }

  public function register()
  {

  }
}
