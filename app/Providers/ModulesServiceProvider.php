<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Module;
use App\Common\Installation\Installator;

class ModulesServiceProvider extends ServiceProvider
{

  public function boot()
  {
    if (Installator::fnIsInstalled()) {
      $aModules = Module::fnGetAll();

      foreach($aModules as $oModule) {
        $oModule->fnLoadRoutes();
        $oModule->fnLoadViews();
        $oModule->fnLoadTranslations();
        $oModule->fnLoadMigrations();
      }
    }
  }

}
